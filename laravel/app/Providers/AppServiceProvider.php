<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Booking;

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
        Gate::define('buat-pengaduan', function ($user) {
            return Booking::where('user_id', $user->id)
                ->where('status', Booking::STATUS_DISETUJUI)
                ->exists();
        });
    }
}
