<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\Department;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\Location;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class PurchaseOrderController extends Controller
{
    public function index(){
        $departments = Department::all();
        $suppliers = Supplier::all();
        $units = Unit::all();
        $locations = location::all();
        return view('fcu-ams/inventory/purchaseOrder', compact('departments', 'suppliers', 'units', 'locations'));
    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'department_id' => 'required|integer|exists:departments,id',
        'supplier_id' => 'required|integer|exists:suppliers,id',
        'location_id' => 'required|integer|exists:locations,id',
        'po_date' => 'required|date',
        'po_number' => 'required|integer',
        'mr_number' => 'required|integer',
        'approved_by' => 'required|string',
        'note' => 'nullable|string',
        'items_specs' => 'required|array',
        'items_specs.*' => 'required|string',
        'quantity' => 'required|array',
        'quantity.*' => 'required|integer',
        'unit_id' => 'required|array',
        'unit_id.*' => 'required|integer|exists:units,id',
        'unit_price' => 'required|array',
        'unit_price.*' => 'required|numeric',
    ]);

    $purchaseOrderGroupId = Str::uuid();

    foreach ($validatedData['items_specs'] as $key => $itemSpec) {
        $purchaseOrder = new PurchaseOrder();
        $purchaseOrder->group_id_for_items_purchased_at_the_same_time = $purchaseOrderGroupId;
        $purchaseOrder->department_id = $validatedData['department_id'];
        $purchaseOrder->supplier_id = $validatedData['supplier_id'];
        $purchaseOrder->unit_id = $validatedData['unit_id'][$key];
        $purchaseOrder->location_id = $validatedData['location_id'];
        $purchaseOrder->po_date = $validatedData['po_date'];
        $purchaseOrder->po_number = $validatedData['po_number'];
        $purchaseOrder->mr_number = $validatedData['mr_number'];
        $purchaseOrder->approved_by = $validatedData['approved_by'];
        $purchaseOrder->quantity = $validatedData['quantity'][$key];
        $purchaseOrder->items_specs = $itemSpec;
        $purchaseOrder->unit_price = $validatedData['unit_price'][$key];
        $purchaseOrder->note = $validatedData['note'];

        $purchaseOrder->save();
    }

    return redirect()->route('purchase.order.index')->with('success', 'Purchase order created successfully');
}
}
