<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function add(Request $request)
    {
        $validatedData = $request->validate([
            'department' => 'required|string|unique:departments,department',
        ], [
            'department.unique' => 'Department already exists.',
        ]);

        $department = new Department();
        $department->department = $validatedData['department'];
        $department->save();

        return redirect()->route('department.index')->with('success', 'Department added successfully!');
    }

    public function index() {
        $departments = Department::orderBy('department', 'asc')->paginate(10);

        return view('fcu-ams/departments/departmentsList', compact('departments'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'department' => 'required|string',
        ]);

        $department = Department::findOrFail($id);
        $department->department = $validatedData['department'];
        $department->save();

        return redirect()->route('department.index')->with('success', 'Department updated successfully!');
    }

    public function destroy($id)
    {
        $department = Department::findOrFail($id);

        $department = Department::find($id);
        if ($department) {
            try {
                $department->delete();
                return redirect()->route('department.index')->with('success', 'Department deleted successfully!');
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->route('department.index')->withErrors(['error' => 'Cannot delete department because it is
                associated with other data.']);
            }
        } else {
            return redirect()->back()->withErrors(['error' => 'Department not found']);
        }
    }
}
