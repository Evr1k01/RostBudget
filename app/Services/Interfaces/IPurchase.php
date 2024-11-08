<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface IPurchase {
    public function getPurchases(Model $user): Collection;
    public function addPurchase(array $attributes): Collection|null;
    public function updatePurchase(string $id, array $attributes): Collection|null;
    public function getMonthOverview(): Collection;
    public function calculateMonthExpenses(): array;
}
