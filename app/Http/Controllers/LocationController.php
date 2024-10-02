<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;

class LocationController extends Controller
{
    public function add(Request $request)
    {
        $validatedData = $request->validate([
            'location' => 'required|string',
        ]);

        $location = new Location();
        $location->location = $validatedData['location'];
        $location->save();

        $request->session()->put('input', $request->all());

        return response()->json(['reload' => true]);
    }
}
