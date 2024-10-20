<?php

namespace App\Services;

use App\Models\Purchase;
use App\Services\Interfaces\IPurchase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PurchaseService implements IPurchase {
    public function getPurchases(): Collection {
        $currentUser = Auth::user();
        return Purchase::query()->where('user_id', $currentUser->id)->get();
    }

    public function addPurchase(array $attributes): Collection {
        $currentUser = Auth::user();

        DB::beginTransaction();
        try {
            $purchaseData = [
                'user_id' => $currentUser->id,
                'description' => $attributes['description'],
                'expense' => $attributes['expense'],
                'date' => $attributes['date'],
                'category_id' => $attributes['categoryId'],
            ];

            Purchase::query()->create($purchaseData);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
        } finally {
            return Purchase::query()->where('user_id', $currentUser->id)->get();
        }
    }
}
