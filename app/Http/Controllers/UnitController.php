<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;

class UnitController extends Controller
{
    public function add(Request $request)
    {
        $validatedData = $request->validate([
            'unit' => 'required|string|unique:units,unit',
        ]);

        $unit = new Unit();
        $unit->unit = $validatedData['unit'];
        $unit->save();

        return response()->json(['reload' => true]);
    }
}
