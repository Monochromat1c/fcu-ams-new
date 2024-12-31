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
        ], [
            'unit.unique' => 'Unit already exists.',
        ]);

        $unit = new Unit();
        $unit->unit = $validatedData['unit'];
        $unit->save();

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Unit added successfully!');
    }

    public function list()
    {
        return response()->json(Unit::orderBy('unit', 'asc')->get());
    }
}
