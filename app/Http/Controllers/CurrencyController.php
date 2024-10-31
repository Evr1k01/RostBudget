<?php

namespace App\Http\Controllers;

use App\Http\Resources\CurrencyResource;
use App\Models\Currency;
use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyController extends Controller {

    public function index(): JsonResource {
        return CurrencyResource::collection(Currency::all());
    }
}
