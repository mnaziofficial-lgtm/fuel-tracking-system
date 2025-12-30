<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Models\Pump;
use App\Models\Sale;
use App\Policies\UserPolicy;
use App\Policies\PumpPolicy;
use App\Policies\SalePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // register model policies
        $this->registerPolicies();

        // map policies explicitly (helps some setups)
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Pump::class, PumpPolicy::class);
        Gate::policy(Sale::class, SalePolicy::class);

        // simple admin gate
        Gate::define('admin', function (?User $user) {
            return $user && method_exists($user, 'isAdmin') && $user->isAdmin();
        });
    }

    /**
     * Register the policies array (no-op here, policies registered above).
     */
    protected function registerPolicies(): void
    {
        // intentionally left blank; explicit mapping done in boot()
    }
}
