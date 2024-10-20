<?php

namespace App\Providers;

use App\Services\Interfaces\IPurchase;
use App\Services\Interfaces\IUser;
use App\Services\PurchaseService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void {
        $this->app->bind(IPurchase::class, PurchaseService::class);
        $this->app->bind(IUser::class, UserService::class);
    }
}
