<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
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
        // Register @role('slug') / @endrole Blade directive
        Blade::if('role', function (string ...$roles) {
            $user = auth()->user();

            if (!$user || !$user->role) {
                return false;
            }

            return in_array($user->role->slug, $roles, true);
        });
    }
}

