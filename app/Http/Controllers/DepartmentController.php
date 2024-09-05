<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index(Request $request) {
        $sort = $request->input('sort', 'department');
        $direction = $request->input('direction', 'asc');
        $search = $request->input('search');

        $query = Department::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('department', 'like', '%' . $search . '%');
            });
        }

        if ($sort && $direction) {
            $query->orderBy($sort, $direction);
        } else {
            $query->orderBy('department', 'asc');
        }

        $departments = $query->paginate(15);

        return view('fcu-ams/departments/departmentsList', compact('departments', 'sort', 'direction', 'search'));
    }

    public function create()
    {
        return view('fcu-ams/departments/addDepartment');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'department' => 'required|string|unique:departments,department',
        ]);

        Department::create($validatedData);

        return redirect()->route('departments.add')->with('success', 'Department added successfully.');
    }
}
