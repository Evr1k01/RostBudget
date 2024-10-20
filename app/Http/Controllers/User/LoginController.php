<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Services\Interfaces\IUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use function Laravel\Prompts\password;

class LoginController extends Controller
{
    private IUser $userService;

    public function __construct(IUser $userService)
    {
        $this->userService = $userService;
    }

    public function login(LoginRequest $request): Response|JsonResponse
    {
        $email = $request->input('email');
        if(filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $loginData = $request->validated();
        }
        else
        {
            if (!$this->userService->findByEmail($email)) {
                return response(['custom' => 'Пользователь с почтой '.$email.' не найден!'],404);
            }

            $loginData = ([
                'email' => $email,
                'password' => $request->input('password')
            ]);
        }

        if(!auth()->attempt($loginData)){
            return response(['custom' => 'Указаны неверные данные'],422);
        }

        $accessToken = auth()->user()->createToken('accessToken')->plainTextToken;;

        return response([
            'access_token' => $accessToken,
        ]);
    }

    public function logout(): Response
    {
        auth()->user()->tokens()->delete();
        return response()->noContent();
    }
}
