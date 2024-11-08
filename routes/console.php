<?php

use Illuminate\Support\Facades\Schedule;
use App\Services\PurchaseService;

Schedule::call(function (PurchaseService $purchaseService) {
    $purchaseService->setMonthsOverview();
})->everyMinute();
