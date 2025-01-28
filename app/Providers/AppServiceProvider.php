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

        view()->composer('*', function ($view) {
            $user = auth()->user();
            if ($user) {
                $pastDueCount = \App\Models\Asset::whereHas('condition', function ($query) {
                    $query->where('condition', 'Maintenance');
                })
                ->whereDate('maintenance_end_date', '<', now())
                ->count();

                $pendingRequestsCount = \App\Models\SupplyRequest::where('status', 'pending')
                    ->distinct('request_group_id')
                    ->count('request_group_id');

                // Only show pending requests that haven't been viewed
                if ($user) {
                    if ($user->last_checked_alerts) {
                        $pendingRequestsCount = \App\Models\SupplyRequest::where('status', 'pending')
                            ->where('created_at', '>', $user->last_checked_alerts)
                            ->distinct('request_group_id')
                            ->count('request_group_id');
                    }
                }

                // Count expiring leases that haven't been viewed
                $expiringLeasesCount = \App\Models\Lease::where('lease_expiration', '>', now())
                    ->where('lease_expiration', '<=', now()->addDays(7))
                    ->when($user->last_checked_alerts, function ($query) use ($user) {
                        return $query->where(function ($q) use ($user) {
                            $q->where('updated_at', '>', $user->last_checked_alerts)
                                ->orWhere('created_at', '>', $user->last_checked_alerts);
                        });
                    })
                    ->count();

                $totalAlerts = $pastDueCount + $pendingRequestsCount + $expiringLeasesCount;

                $view->with('totalAlerts', $totalAlerts);
                $view->with('pendingRequestsCount', $pendingRequestsCount);
                $view->with('pastDueCount', $pastDueCount);
                $view->with('expiringLeasesCount', $expiringLeasesCount);
            }
        });

        view()->composer('*', function ($view) {
            $user = auth()->user();
            if ($user && $user->role->role === 'Department') {
                \Log::info('User notifications check', [
                    'user_id' => $user->id,
                    'department_id' => $user->department_id,
                    'last_checked' => $user->last_checked_notifications,
                    'role' => $user->role->role
                ]);

                $query = \App\Models\SupplyRequest::where('department_id', $user->department_id)
                    ->whereIn('status', ['approved', 'rejected', 'partially_approved'])
                    ->when($user->last_checked_notifications, function ($query) use ($user) {
                        return $query->where(function ($q) use ($user) {
                            $q->where('updated_at', '>', $user->last_checked_notifications)
                              ->orWhere('created_at', '>', $user->last_checked_notifications);
                        });
                    });

                \Log::info('Query debug', [
                    'sql' => $query->toSql(),
                    'bindings' => $query->getBindings(),
                    'count' => $query->count()
                ]);

                $unreadNotificationsCount = $query->distinct('request_group_id')->count('request_group_id');

                $view->with('unreadNotificationsCount', $unreadNotificationsCount);
            }
        });
    }
}
