<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Services\Interfaces\IUser;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController extends Controller {
    private IUser $userService;

    public function __construct(IUser $userService) {
        $this->userService = $userService;
    }

    public function store(UserRequest $userRequest): JsonResource {
        return new UserResource($this->userService->createUser($userRequest->validated()));
    }
}
