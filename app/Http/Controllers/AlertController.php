<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;

class AlertController extends Controller
{
    public function index()
    {
        $pastDueAssets = Asset::where('condition_id', 2)
            ->whereDate('maintenance_end_date', '<', now())
            ->get();

        return view('fcu-ams.alert.alerts', compact('pastDueAssets'));
    }
}
