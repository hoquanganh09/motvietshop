<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Paginator::useBootstrapFive();

        Gate::define('update-profile', function (User $user, ?User $user2 = null) {
            return $user->isRoot() || $user->isSuperAdmin() || ($user->isAdmin() && $user2 && $user2->id == $user->id);
        });

        Gate::define('manager-user', function (User $user) {
            return $user->isRoot() || $user->isSuperAdmin();
        });

        Gate::define('manager-coupon', function (User $user) {
            return $user->isRoot() || $user->isSuperAdmin();
        });

        Gate::define('delete-order', function (User $user) {
            return $user->isRoot() || $user->isSuperAdmin();
        });

        Gate::define('dashboard', function (User $user) {
            return $user->isRoot() || $user->isSuperAdmin();
        });
    }
}
