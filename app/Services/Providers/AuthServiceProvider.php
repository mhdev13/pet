<?php

namespace App\Services\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\RegisterService;
use App\Services\LoginService;
use App\Services\Contracts\AuthServiceInterface;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services into the container
     */
    public function register(): void
    {
        $this->registerAuthServices();
    }

    /**
     * Bootstrap services
     */
    public function boot(): void
    {
        //
    }

    /**
     * Register authentication services
     */
    private function registerAuthServices(): void
    {
        // Singleton instances for services
        $this->app->singleton(RegisterService::class, function ($app) {
            return new RegisterService();
        });

        $this->app->singleton(LoginService::class, function ($app) {
            return new LoginService();
        });
    }
}
