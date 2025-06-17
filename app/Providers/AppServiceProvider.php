<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Enums\UserRole;

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
        /**
         * Gate untuk menentukan siapa yang boleh mengakses modul manajemen utama.
         * Hanya Admin yang boleh.
         */
        Gate::define('manage-master-data', function (User $user) {
            return $user->role === UserRole::ADMIN;
        });

        /**
         * Gate untuk menentukan siapa yang boleh mengakses modul operasional.
         * Admin dan Petugas boleh.
         */
        Gate::define('manage-operations', function (User $user) {
            // ====================================================
            // ==> PERBAIKAN ADA DI BARIS INI <==
            // ====================================================
            return $user->role === UserRole::ADMIN || $user->role === UserRole::OFFICER;
        });
    }
}