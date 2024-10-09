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
            'unit_id' => 'required|integer|exists:units,id',
            'location_id' => 'required|integer|exists:locations,id',
            'po_date' => 'required|date',
            'po_number' => 'required|integer',
            'mr_number' => 'required|integer',
            'quantity' => 'required|integer',
            'items_specs' => 'required|string',
            'unit_price' => 'required|numeric',
            'note' => 'nullable|string',
        ]);

        $purchaseOrderId = Str::uuid();

        $purchaseOrder = new PurchaseOrder();
        $purchaseOrder->purchase_order_id = $purchaseOrderId;
        $purchaseOrder->department_id = $validatedData['department_id'];
        $purchaseOrder->supplier_id = $validatedData['supplier_id'];
        $purchaseOrder->unit_id = $validatedData['unit_id'];
        $purchaseOrder->location_id = $validatedData['location_id'];
        $purchaseOrder->po_date = $validatedData['po_date'];
        $purchaseOrder->po_number = $validatedData['po_number'];
        $purchaseOrder->mr_number = $validatedData['mr_number'];
        $purchaseOrder->quantity = $validatedData['quantity'];
        $purchaseOrder->items_specs = $validatedData['items_specs'];
        $purchaseOrder->unit_price = $validatedData['unit_price'];
        $purchaseOrder->note = $validatedData['note'];

        $purchaseOrder->save();

        return redirect()->route('purchase.order.index')->with('success', 'Purchase order created successfully');
    }
}
