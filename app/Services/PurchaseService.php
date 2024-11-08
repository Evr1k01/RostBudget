<?php

namespace App\Services;

use App\Models\Currency;
use App\Models\Purchase;
use App\Models\MonthReport;
use App\Models\User;
use App\Services\Interfaces\IPurchase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Number;

class PurchaseService implements IPurchase {
    public function getPurchases(Model $user): Collection {
        $currentDate = Carbon::now();
        $startOfTheMonth = $currentDate->copy()->startOfMonth()->format('Y-m-d');
        $endOfTheMonth = $currentDate->copy()->endOfMonth()->format('Y-m-d');

        return Purchase::query()
            ->where('user_id', $user->id)
            ->where('date', '>=', $startOfTheMonth)
            ->where('date', '<=', $endOfTheMonth)
            ->get()->sortByDesc('date');
    }

    public function addPurchase(array $attributes): Collection|null {
        $currentUser = Auth::user();

        DB::beginTransaction();
        try {
            $currencies = $this->getCurrencyExchange();
            if (count($currencies) == 0) {
                throw new Exception('Currencies Exchange failed');
            }

            $expenseWithCurrencies = $this->calculateExpenseForAllCurrencies($currentUser, $attributes['expense'], $currencies['eur']);

            $purchaseData = [
                'user_id' => $currentUser->id,
                'description' => $attributes['description'],
                'expense' => $expenseWithCurrencies,
                'date' => $attributes['date'],
                'category_id' => $attributes['categoryId'],
            ];

            Purchase::query()->create($purchaseData);
            DB::commit();
            return $this->getPurchases($currentUser);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return null;
        }
    }

    public function updatePurchase(string $id, array $attributes): Collection|null {
        $currentUser = Auth::user();

        DB::beginTransaction();
        try {
            $purchase = Purchase::query()->find($id);
            if (is_null($purchase)) {
                return null;
            }

            if ($currentUser->id !== $purchase->user_id) {
                return null;
            }

            $expenseWithCurrencies = $purchase->expense;
            $expense = $expenseWithCurrencies[$currentUser->currency->currency_code];

            if ($attributes['expense'] !== $expense) {
                $currencies = $this->getCurrencyExchange();
                if (count($currencies) == 0) {
                    throw new Exception('Currencies Exchange failed');
                }

                $expenseWithCurrencies = $this->calculateExpenseForAllCurrencies($currentUser, $attributes['expense'], $currencies['eur']);
            }

            $purchaseData = [
                'description' => $attributes['description'],
                'expense' => $expenseWithCurrencies,
                'date' => $attributes['date'],
                'category_id' => $attributes['categoryId'],
            ];

            $purchase->update($purchaseData);
            DB::commit();
            return $this->getPurchases($currentUser);

        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return null;
        }
    }

    public function calculateMonthExpenses(): array {
        $currentUser = Auth::user();
        $purchases = $this->getPurchases($currentUser);
        return $this->sumExpenses($purchases);
    }

    public function getMonthOverview(): Collection {
        $currentUser = Auth::user();
        return MonthReport::query()->where(
            'user_id', $currentUser->id
        )->get()->sortByDesc('created_at');
    }

    public function setMonthsOverview(): void {
        $userReports = $this->getUsersMonthReport();
        dd($userReports);
        foreach ($userReports as $report) {
            MonthReport::query()->create([
                'sum' => $report['sum'],
                'month' => $report['month'],
                'year' => $report['year'],
                'top_category' => $report['category'],
                'user_id' => $report['user_id'],
            ]);
        }
    }

    private function getUsersMonthReport(): array {
        $result = [];
        $dates = $this->getMonthBoundaries();
        User::with('purchases')->each(function ($user) use ($dates, &$result) {
            $filteredPurchases = $user->purchases->filter(function ($purchase) use ($dates) {
               return $dates['firstDay'] <= $purchase->date && $dates['lastDay'] >= $purchase->date;
            });

            $categoryCounts = $filteredPurchases->groupBy('category_id')->map(function ($category) {
                return $category->count();
            });

            $userExpenses = $this->sumExpenses($filteredPurchases);

            $result[] = [
                'user_id' => $user->id,
                'sum' => $userExpenses,
                'category' => $categoryCounts->search($categoryCounts->max()),
                'month' => Carbon::now()->subMonth()->format('F'),
                'year' => Str::substr($dates['firstDay'], 0, 4),
            ];
        });
        return $result;
    }

    private function getMonthBoundaries(): array {
        $currentDate = Carbon::now()->subMonth(); // Переходим к предыдущему месяцу
        return [
            'firstDay' => $currentDate->copy()->startOfMonth()->format('Y-m-d'),
            'lastDay' => $currentDate->copy()->endOfMonth()->format('Y-m-d')
        ];
    }

    private function sumExpenses(Collection $purchases): array {
        $userExpenses = [];
        foreach ($purchases as $purchase) {
            $expense = $purchase->expense;
            foreach ($expense as $currency => $amount) {
                if (!isset($userExpenses[$currency])) {
                    $userExpenses[$currency] = 0;
                }
                $userExpenses[$currency] += round((float) $amount, 1);
            }
        }
        return $userExpenses;
    }

    /**
     * @throws ConnectionException
     */
    private function getCurrencyExchange(): array {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get(env('CURRENCY_EXCHANGE_URL'));

        if ($response->successful()) {
            return json_decode($response->body(), true);
        }
        return [];
    }

    private function calculateExpenseForAllCurrencies(Model $user, float $expense, array $currencies): array {
        $currentCurrencies = Currency::query()->pluck('currency_code')->map(function ($currency) {
            return Str::lower($currency);
        })->toArray();

        $exchangeRates = array_intersect_key($currencies, array_flip($currentCurrencies));

        // коэффициент валюты к евро
        $userCurrency = Str::lower($user->currency->currency_code);
        $baseExpense = $expense / $exchangeRates[$userCurrency];

        $result = [];
        foreach ($exchangeRates as $currency => $rate) {
            $calculatedCurrency = $baseExpense * $rate;
            $result[Str::upper($currency)] = round($calculatedCurrency, 1);
        }
        return $result;
    }
}
