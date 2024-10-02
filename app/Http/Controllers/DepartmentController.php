<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function add(Request $request)
    {
        $validatedData = $request->validate([
            'department' => 'required|string',
        ]);

        $department = new Department();
        $department->department = $validatedData['department'];
        $department->save();

        $request->session()->put('input', $request->all());

        return response()->json(['reload' => true]);
    }
}
