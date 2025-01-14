<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class CheckUserRole
{
    public function handle($request, Closure $next)
    {
        $allowedRoutesForViewer = [
            'asset.list',
            'inventory.list',
            'profile.index',
            'profile.update',
            'profile.updatePersonalInformation',
            'asset.view',
            'logout',
            'inventory.supply.request',
            'inventory.supply.request.store',
            'inventory.low.stock',
            'inventory.out.of.stock',
            'inventory.my.requests',
            'inventory.supply-request.details',
            'inventory.search.items',
            'request.notifications',
            'inventory.request.item.store',
            'inventory.supply-request.cancel',
        ];

        $deniedRoutesForManager = [
            'user.index',
            'user.add',
            'user.update',
            'user.destroy',
        ];

        if (Auth::check() && Auth::user()->role->role == 'Viewer' && !in_array(Route::currentRouteName(),
        $allowedRoutesForViewer)) {
            return redirect()->route('asset.list');
        }

        if (Auth::check() && Auth::user()->role->role == 'Manager' && in_array(Route::currentRouteName(),
        $deniedRoutesForManager)) {
            return redirect()->back()->with('error', 'You do not have permission to access this route.');
        }

        return $next($request);
    }
}