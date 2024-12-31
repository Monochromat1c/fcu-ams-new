<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\ViewedAlert;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AlertController extends Controller
{
    public function index()
    {
        $totalPastDueAssets = Asset::whereHas('condition', function ($query) {
            $query->where('condition', 'Maintenance');
        })
        ->whereDate('maintenance_end_date', '<', now())
        ->get(); 

        $pastDueCount = $totalPastDueAssets->count();
        $pastDueAssets = $totalPastDueAssets->take(5);

        // Get pending supply requests
        $pendingRequests = \App\Models\SupplyRequest::select('request_group_id', 'requester', 'status', 'request_date', 'department_id', 
                     \DB::raw('COUNT(*) as items_count'))
            ->where('status', 'pending')
            ->groupBy('request_group_id', 'requester', 'status', 'request_date', 'department_id')
            ->with('department')
            ->orderBy('request_date', 'desc')
            ->take(5)
            ->get();

        $totalPendingRequests = \App\Models\SupplyRequest::where('status', 'pending')
            ->distinct('request_group_id')
            ->count('request_group_id');

        // Get expiring leases (within 7 days)
        $expiringLeases = \App\Models\Lease::where('lease_expiration', '>', now())
            ->where('lease_expiration', '<=', now()->addDays(7))
            ->orderBy('lease_expiration', 'asc')
            ->take(5)
            ->get();

        $totalExpiringLeases = \App\Models\Lease::where('lease_expiration', '>', now())
            ->where('lease_expiration', '<=', now()->addDays(7))
            ->count();

        // Get current user's ID from username
        $user = User::where('username', Auth::user()->username)->first();
        
        // Mark all overdue assets as viewed for current user
        if ($user) {
            foreach ($totalPastDueAssets as $asset) {
                ViewedAlert::firstOrCreate([
                    'user_id' => $user->id,
                    'asset_id' => $asset->id
                ]);
            }

            // Update last checked alerts timestamp
            $user->last_checked_alerts = now();
            $user->save();
        }

        return view('fcu-ams.alert.alerts', compact('pastDueAssets', 'pastDueCount', 'pendingRequests', 'totalPendingRequests', 'expiringLeases', 'totalExpiringLeases'));
    }

    public function show(Asset $asset)
    {
        return view('fcu-ams.alert.show', compact('asset'));
    }

    public function maintenance()
    {
        $pastDueAssets = Asset::with(['brand', 'site', 'location', 'category', 'department'])
            ->where('maintenance_end_date', '<', now())
            ->orderBy('maintenance_end_date', 'asc')
            ->get();

        // Get current user's ID from username and mark all viewed
        $user = User::where('username', Auth::user()->username)->first();
        if ($user) {
            foreach ($pastDueAssets as $asset) {
                ViewedAlert::firstOrCreate([
                    'user_id' => $user->id,
                    'asset_id' => $asset->id
                ]);
            }
        }

        return view('fcu-ams.alert.maintenance', compact('pastDueAssets'));
    }

    public function pendingRequests()
    {
        $pendingRequests = \App\Models\SupplyRequest::select(
            'request_group_id', 
            'requester', 
            'status', 
            'request_date', 
            'department_id',
            \DB::raw('COUNT(*) as items_count')
        )
        ->where('status', 'pending')
        ->groupBy('request_group_id', 'requester', 'status', 'request_date', 'department_id')
        ->with('department')
        ->orderBy('request_date', 'desc')
        ->paginate(15);

        return view('fcu-ams.alert.pending-requests', compact('pendingRequests'));
    }

    public function expiringLeases()
    {
        $expiringLeases = \App\Models\Lease::where('lease_expiration', '>', now())
            ->where('lease_expiration', '<=', now()->addDays(7))
            ->with('assets')
            ->orderBy('lease_expiration', 'asc')
            ->paginate(15);

        // Update last checked alerts timestamp
        if ($user = Auth::user()) {
            $user->last_checked_alerts = now();
            $user->save();
        }

        return view('fcu-ams.alert.expiring-leases', compact('expiringLeases'));
    }
}
