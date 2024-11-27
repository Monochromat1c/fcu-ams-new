<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;

class AlertController extends Controller
{
    public function index()
    {
        $totalPastDueAssets = Asset::whereHas('condition', function ($query) {
            $query->where('condition', 'Maintenance');
        })
        ->whereDate('maintenance_end_date', '<', now())
        ->get(); 

        $pastDueAssets = $totalPastDueAssets->take(5);

        return view('fcu-ams.alert.alerts', compact('pastDueAssets', 'totalPastDueAssets'));
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

        return view('fcu-ams.alert.maintenance', compact('pastDueAssets'));
    }
}
