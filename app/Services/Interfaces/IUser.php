<?php

namespace App\Services\Interfaces;

use App\Models\User;

interface IUser {
    public function createUser(array $attributes): User;
    public function findByEmail(string $email): bool;
}
