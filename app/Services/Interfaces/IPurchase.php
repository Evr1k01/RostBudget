<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface IPurchase {
    public function getPurchases(): Collection;
    public function addPurchase(array $attributes): Collection;
}
