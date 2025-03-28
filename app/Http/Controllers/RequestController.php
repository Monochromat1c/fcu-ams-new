<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupplyRequest;
use App\Models\Department;
use App\Models\RequestedItem;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        $brands = Brand::all();
        $units = Unit::all();
        $suppliers = Supplier::all();
        
        $query = SupplyRequest::with('department')
            ->select(
                'request_group_id', 
                'department_id', 
                'requester',
                DB::raw('MIN(created_at) as request_date'), // Use MIN of created_at
                DB::raw('COUNT(*) as total_items'),
                DB::raw('MAX(status) as group_status'),
                DB::raw('CASE 
                    WHEN MAX(status) = "pending" THEN 1
                    WHEN MAX(status) = "partially_approved" THEN 2
                    WHEN MAX(status) = "approved" THEN 3
                    WHEN MAX(status) = "rejected" THEN 4
                    ELSE 5 END as status_priority')
            );

        // Only show cancelled requests to departments
        if (auth()->user()->role->role !== 'Department') {
            $query->where('status', '!=', 'cancelled');
        }

        $requests = $query->groupBy('request_group_id', 'department_id', 'requester') // Remove request_date from groupBy
            ->orderBy('status_priority', 'asc')
            ->orderBy('request_date', 'desc')
            ->paginate(10);

        // Get all departments for the filter
        $allDepartments = Department::all();
        $selectedDepartments = [];

        return view('fcu-ams.request.index', compact(
            'requests', 
            'departments', 
            'brands', 
            'units', 
            'suppliers', 
            'allDepartments',
            'selectedDepartments'
        ));
    }

    public function destroy($request_group_id)
    {
        try {
            DB::beginTransaction();
            
            $requests = SupplyRequest::where('request_group_id', $request_group_id)->get();
            
            if ($requests->isEmpty()) {
                return redirect()->back()->with('error', 'Supply request not found.');
            }

            foreach ($requests as $request) {
                $request->delete(); // This will perform soft delete
            }

            DB::commit();
            return redirect()->back()->with('success', 'Supply request deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to delete supply request. Please try again.');
        }
    }

    public function storeRequestedItem(Request $request)
    {
        $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'items_specs' => 'required|string',
            'unit_id' => 'required|exists:units,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'supplier_id' => 'required|exists:suppliers,id',
        ]);

        $requestedItem = RequestedItem::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Item request submitted successfully',
            'data' => $requestedItem
        ]);
    }

    public function getBrands()
    {
        $brands = Brand::all();
        return response()->json($brands);
    }

    public function getUnits()
    {
        $units = Unit::all();
        return response()->json($units);
    }

    public function getSuppliers()
    {
        $suppliers = Supplier::all();
        return response()->json($suppliers);
    }
} 