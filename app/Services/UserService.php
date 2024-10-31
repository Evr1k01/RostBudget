<?php

namespace App\Services;

use App\Enums\CurrencyEnum;
use App\Models\User;
use App\Models\UserCurrency;
use App\Services\Interfaces\IUser;

class UserService implements IUser {

    public function createUser(array $attributes): User {
        $user = User::query()->create($attributes);
        UserCurrency::query()->create(['user_id' => $user->id, 'currency_id' => CurrencyEnum::EUR]);
        return $user;
    }

    public function findByEmail(string $email): bool {
        $user = User::query()->where('email', $email)->first();
        return !is_null($user);
    }
}
