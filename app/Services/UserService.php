<?php

namespace App\Services;

use App\Models\User;
use App\Services\Interfaces\IUser;

class UserService implements IUser {

    public function createUser(array $attributes): User {
        return User::query()->create($attributes);
    }

    public function findByEmail(string $email): bool {
        $user = User::query()->where('email', $email)->first();
        return !is_null($user);
    }
}
