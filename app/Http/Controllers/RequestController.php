<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupplyRequest;
use App\Models\Department;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    public function index(Request $request)
    {
        $allDepartments = Department::all();
        $selectedDepartments = $request->input('departments', []);

        $requests = SupplyRequest::select(
            'request_group_id',
            'requester',
            'status',
            'request_date',
            'department_id',
            DB::raw('COUNT(*) as items_count')
        )
        ->when(!empty($selectedDepartments), function ($query) use ($selectedDepartments) {
            return $query->whereIn('department_id', $selectedDepartments);
        })
        ->groupBy('request_group_id', 'requester', 'status', 'request_date', 'department_id')
        ->with('department')
        ->orderBy('request_date', 'desc')
        ->paginate(15);

        return view('fcu-ams.request.index', compact('requests', 'allDepartments', 'selectedDepartments'));
    }
} 