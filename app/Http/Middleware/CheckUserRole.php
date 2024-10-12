<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class CheckUserRole
{
    public function handle($request, Closure $next)
    {
        $allowedRoutes = [
            'asset.list',
            'profile.index',
            'profile.update',
            'asset.view',
            'logout'
        ];

        if (Auth::check() && Auth::user()->role->role == 'Viewer' && !in_array(Route::currentRouteName(), $allowedRoutes)) {
            return redirect()->route('asset.list');
        }

        return $next($request);
    }
}