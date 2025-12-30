<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Pump;
use App\Models\Sale;
use App\Policies\UserPolicy;
use App\Policies\PumpPolicy;
use App\Policies\SalePolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // register simple authorization policies and admin gate
        try {
            Gate::policy(User::class, UserPolicy::class);
            Gate::policy(Pump::class, PumpPolicy::class);
            Gate::policy(Sale::class, SalePolicy::class);

            Gate::define('admin', function (?User $user) {
                return $user && method_exists($user, 'isAdmin') && $user->isAdmin();
            });
        } catch (\Throwable $e) {
            // ignore during early bootstrap when classes may not be available (e.g., artisan vendor:publish)
        }
    }
}
