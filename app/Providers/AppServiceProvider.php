<?php

namespace App\Providers;

use App\Models\Asset;
use App\Models\ViewedAlert;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

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
        Paginator::useTailwind();

        view()->composer('*', function ($view) {
            if (Auth::check()) {
                $user = User::where('username', Auth::user()->username)->first();
                if ($user) {
                    $totalPastDueAssets = Asset::whereHas('condition', function ($query) {
                        $query->where('condition', 'Maintenance');
                    })
                    ->whereDate('maintenance_end_date', '<', now())
                    ->whereDoesntHave('viewedAlerts', function ($query) use ($user) {
                        $query->where('user_id', $user->id);
                    })
                    ->get();
                    $view->with('totalPastDueAssets', $totalPastDueAssets);
                }
            }
        });
    }
}
