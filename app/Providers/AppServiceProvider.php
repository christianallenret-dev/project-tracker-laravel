<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

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
        Gate::define('manage-tasks', function (User $user) {
            return (bool) $user->is_manager;
        });

        // Share projects with registration view
        view()->composer('auth.register', function ($view) {
            $view->with('projects', \App\Models\Project::all());
        });
    }
}
