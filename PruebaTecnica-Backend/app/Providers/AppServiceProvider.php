<?php

namespace App\Providers;

use App\Http\Services\PasswordResetTokenService;
use App\Http\Services\UserService;
use App\Models\PasswordResetToken;
use App\Observers\PasswordResetTokenObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PasswordResetTokenService::class, function ($app) {
            return new PasswordResetTokenService();
        });
        $this->app->bind(UserService::class, function ($app) {
            return new UserService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        PasswordResetToken::observe(PasswordResetTokenObserver::class);
    }
}
