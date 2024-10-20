<?php

use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\LoginController;

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');

Route::apiResource('/user', UserController::class);
Route::apiResource('/purchases', PurchaseController::class)->middleware('auth:sanctum');
