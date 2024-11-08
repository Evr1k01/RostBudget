<?php

use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CurrencyController;

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');

Route::apiResource('/user', UserController::class);
Route::get('/get-user-currency', [UserController::class, 'getUserCurrency'])->middleware('auth:sanctum');
Route::post('/set-user-currency', [UserController::class, 'setUserCurrency'])->middleware('auth:sanctum');

Route::apiResource('/purchases', PurchaseController::class)->middleware('auth:sanctum');
Route::get('/month-overview', [PurchaseController::class, 'monthOverview'])->middleware('auth:sanctum');
Route::get('/month-expenses', [PurchaseController::class, 'calculateMonthExpenses'])->middleware('auth:sanctum');

Route::apiResource('/categories', CategoryController::class)->middleware('auth:sanctum');
Route::apiResource('/currencies', CurrencyController::class)->middleware('auth:sanctum');
