<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CurrencyRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\CurrencyResource;
use App\Http\Resources\UserResource;
use App\Models\Currency;
use App\Models\UserCurrency;
use App\Services\Interfaces\IUser;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {
    private IUser $userService;

    public function __construct(IUser $userService) {
        $this->userService = $userService;
    }

    public function store(UserRequest $userRequest): JsonResource {
        return new UserResource($this->userService->createUser($userRequest->validated()));
    }

    public function getUserCurrency(): JsonResource {
        $currentUser = Auth::user();
        return new CurrencyResource($currentUser->currency);
    }

    public function setUserCurrency(CurrencyRequest $request): JsonResource {
        $currentUser = Auth::user();
        $validatedRequest = $request->validated();
        $currentCurrency = UserCurrency::query()->where('user_id', $currentUser->id)->firstOrFail();
        $currentCurrency->update(['currency_id' => $validatedRequest['currencyId']]);
        return new CurrencyResource($currentUser->currency);
    }
}
