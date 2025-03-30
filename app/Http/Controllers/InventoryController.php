<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\SupplyRequest;
use App\Models\StockOut;
use App\Models\Inventory;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InventoryExport;
use App\Models\Asset;
use App\Models\Supplier;
use App\Models\Site;
use App\Models\Location;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Department;
use App\Models\Brand;
use App\Models\Status;
use App\Models\Unit;
use App\Models\AssetEditHistory;
use App\Models\InventoryEditHistory;
// use App\Imports\AssetsImport;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class InventoryController extends Controller
{
    public function index(Request $request) {
        $brands = $request->input('brands', []);
        $selectedBrands = $brands;
        
        $totalItems = DB::table('inventories')
            ->whereNull('deleted_at')
            ->where('quantity', '>', 0)
            ->count();
            
        $totalValue = DB::table('inventories')
            ->whereNull('deleted_at')
            ->where('quantity', '>', 0)
            ->sum(DB::raw('unit_price * quantity'));
            
        $lowStock = DB::table('inventories')
            ->where('quantity', '>=', 1)
            ->where('quantity', '<', 20)
            ->whereNull('deleted_at')
            ->count();
            
        $outOfStock = DB::table('inventories')
            ->where('quantity', '=', 0)
            ->whereNull('deleted_at')
            ->count();
        
        $sort = $request->input('sort', 'items_specs');
        $direction = $request->input('direction', 'asc');
        $search = $request->input('search');

        $query = Inventory::whereNull('deleted_at')
            ->where('quantity', '>', 0)
            ->with('supplier', 'unit', 'brand')
            ->leftJoin('suppliers', 'inventories.supplier_id', '=', 'suppliers.id')
            ->leftJoin('units', 'inventories.unit_id', '=', 'units.id')
            ->leftJoin('brands', 'inventories.brand_id', '=', 'brands.id')
            ->select('inventories.*', 'suppliers.supplier as supplier_name', 'units.unit as unit_name', 'brands.brand as brand_name');

        if (!empty($brands)) {
            $query->whereIn('inventories.brand_id', $brands);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('inventories.unique_tag', 'like', "%{$search}%")
                  ->orWhere('inventories.items_specs', 'like', "%{$search}%")
                  ->orWhere('brands.brand', 'like', "%{$search}%")
                  ->orWhere('units.unit', 'like', "%{$search}%");
            });
        }

        if ($sort && $direction) {
            $query->orderBy($sort, $direction);
        }

        $inventories = $query->paginate(10);
        $allBrands = Brand::all();

        return view('fcu-ams.inventory.inventoryList', [
            'inventories' => $inventories,
            'brands' => $allBrands,
            'selectedBrands' => $selectedBrands,
            'sort' => $sort,
            'direction' => $direction,
            'totalItems' => $totalItems,
            'totalValue' => $totalValue,
            'lowStock' => $lowStock,
            'outOfStock' => $outOfStock
        ]);
    }

    public function search(Request $request)
    {
        $searchQuery = $request->input('search');
        
        $inventories = DB::table('inventories')
            ->leftJoin('suppliers', 'inventories.supplier_id', '=', 'suppliers.id')
            ->leftJoin('brands', 'inventories.brand_id', '=', 'brands.id')
            ->leftJoin('units', 'inventories.unit_id', '=', 'units.id')
            ->select(
                'inventories.*',
                'suppliers.supplier as supplier_name',
                'brands.brand as brand_name',
                'units.unit as unit_name'
            )
            ->where(function($query) use ($searchQuery) {
                $query->where('inventories.unique_tag', 'like', '%' . $searchQuery . '%')
                      ->orWhere('inventories.items_specs', 'like', '%' . $searchQuery . '%');
            })
            ->whereNull('inventories.deleted_at')
            ->get();

        return response()->json([
            'inventories' => $inventories
        ]);
    }

    public function lowStock(Request $request)
    {
        $lowStockItems = Inventory::whereNull('deleted_at')
            ->where('quantity', '>=', 1)
            ->where('quantity', '<', 20)
            ->with(['supplier', 'unit', 'brand'])
            ->orderBy('quantity', 'asc')
            ->paginate(10);

        return view('fcu-ams/inventory/lowStock', compact('lowStockItems'));
    }

    public function outOfStock(Request $request)
    {
        $outOfStockItems = Inventory::whereNull('deleted_at')
            ->where('quantity', '=', 0)
            ->with(['supplier', 'unit', 'brand'])
            ->orderBy('unique_tag', 'asc')
            ->paginate(10);

        return view('fcu-ams/inventory/outOfStock', compact('outOfStockItems'));
    }

    public function show($id)
    {
        $inventory = Inventory::with(['supplier', 'unit', 'brand'])->findOrFail($id);
        
        // Get paginated edit history
        $editHistory = $inventory->editHistory()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('fcu-ams/inventory/viewInventory', compact('inventory', 'editHistory'));
    }

    public function create() {
        $suppliers = DB::table('suppliers')->get();
        $units = DB::table('units')->get();
        $brands = DB::table('brands')->get();
        return view('fcu-ams/inventory/stockIn', compact('suppliers', 'units', 'brands'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'items_specs' => 'required|string',
            'unit_id' => 'required|integer|exists:units,id',
            'brand_id' => 'required|integer|exists:brands,id',
            'quantity' => 'required|numeric',
            'unit_price' => 'required|numeric',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'stock_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'created_by' => 'nullable|integer|exists:users,id'
        ]);

        $existingInventory = Inventory::where('items_specs', $validatedData['items_specs'])
            ->where('brand_id', $validatedData['brand_id'])
            ->where('unit_id', $validatedData['unit_id'])
            ->where('unit_price', $validatedData['unit_price'])
            ->where('supplier_id', $validatedData['supplier_id'])
            ->whereNull('deleted_at')
            ->first();

        if ($existingInventory) {
            $existingInventory->quantity += $validatedData['quantity'];
            $existingInventory->save();
        } else {
            $inventory = new Inventory();
            $inventory->brand_id = $validatedData['brand_id'];
            $inventory->items_specs = $validatedData['items_specs'];
            $inventory->unit_id = $validatedData['unit_id'];
            $inventory->quantity = $validatedData['quantity'];
            $inventory->unit_price = $validatedData['unit_price'];
            $inventory->supplier_id = $validatedData['supplier_id'];
            $inventory->created_by = auth()->user()->id;

            if ($request->hasFile('stock_image')) {
                $imageName = time().'.'.$request->stock_image->extension();
                $request->stock_image->move(public_path('profile'), $imageName);
                $inventory->stock_image = 'profile/'.$imageName;
            }

            $inventory->save();
        }

        $input = $request->except('stock_image');
        $request->session()->put('input', $input);

        return redirect()->route('inventory.stock.in')->with('success', 'Item added to inventory.');
    }

    public function edit($id)
    {
        $inventory = Inventory::findOrFail($id);
        $suppliers = DB::table('suppliers')->get();
        $units = DB::table('units')->get();
        $brands = DB::table('brands')->get();

        return view('fcu-ams/inventory/updateStock', compact('inventory', 'suppliers', 'units', 'brands'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'items_specs' => [
                'required',
                'string',
                Rule::unique('inventories', 'items_specs')->ignore($id)->whereNull('deleted_at'),
            ],
            'unit_id' => 'required|integer|exists:units,id',
            'brand_id' => 'required|integer|exists:brands,id',
            'quantity' => 'required|numeric',
            'unit_price' => 'required|numeric',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'stock_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $inventory = Inventory::findOrFail($id);
        $oldInventory = clone $inventory;

        $inventory->items_specs = $validatedData['items_specs'];
        $inventory->unit_id = $validatedData['unit_id'];
        $inventory->brand_id = $validatedData['brand_id'];
        $inventory->quantity = $validatedData['quantity'];
        $inventory->unit_price = $validatedData['unit_price'];
        $inventory->supplier_id = $validatedData['supplier_id'];

        if ($request->hasFile('stock_image')) {
            $imageName = time().'.'.$request->stock_image->extension();
            $request->stock_image->move(public_path('profile'), $imageName);
            $inventory->stock_image = 'profile/'.$imageName;
        }

        $this->storeEditHistory($inventory, auth()->user(), $oldInventory);

        $inventory->save();

        return redirect()->back()->with('success', 'Inventory updated successfully.');
    }

    private function storeEditHistory($inventory, $user, $oldInventory)
    {
        $changes = [];
        $fields = [
            'items_specs' => 'Items & Specs',
            'brand_id' => 'Brand',
            'unit_id' => 'Unit',
            'quantity' => 'Quantity',
            'unit_price' => 'Unit Price',
            'supplier_id' => 'Supplier',
        ];

        foreach ($fields as $field => $header) {
            if ($inventory->$field != $oldInventory->$field) {
                $oldValue = $oldInventory->$field;
                $newValue = $inventory->$field;

                if (in_array($field, ['supplier_id', 'brand_id', 'unit_id'])) {
                    $relationship = str_replace('_id', '', $field);
                    $oldValue = $oldInventory->$relationship->supplier ?? 
                        $oldInventory->$relationship->brand ?? 
                        $oldInventory->$relationship->unit;
                    $newValue = $inventory->$relationship->supplier ?? 
                        $inventory->$relationship->brand ?? 
                        $inventory->$relationship->unit;
                }

                $changes[] = "Updated $header from '$oldValue' to '$newValue'.";
            }
        }

        if (count($changes) > 0) {
            $editHistory = new InventoryEditHistory();
            $editHistory->inventory_id = $inventory->id;
            $editHistory->user_id = $user->id;
            $editHistory->changes = nl2br(implode("<br>", $changes));
            $editHistory->save();
        }
    }

    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);

        // Explicitly set deleted_by before deleting
        $inventory->deleted_by = auth()->user()->id;
        $inventory->save();

        $inventory->delete();

        return redirect()->back()->with('success', 'Asset deleted successfully!');
    }

    public function createStockOut()
    {
        $inventories = Inventory::whereNull('deleted_at')
            ->where('quantity', '>=', 1)
            ->with(['brand', 'unit']) // Eager load relationships
            ->join('brands', 'inventories.brand_id', '=', 'brands.id')
            ->orderBy('brands.brand', 'asc')
            ->select('inventories.*')
            ->get();
        $departments = Department::all();
        return view('fcu-ams/inventory/stockOut', compact('inventories', 'departments'));
    }

    public function storeStockOut(Request $request)
    {
        $validatedData = $request->validate([
            'item_id' => 'required|array',
            'quantity' => 'required|array',
            'department_id' => 'required|integer|exists:departments,id',
            'stock_out_date' => 'required|date',
            'receiver' => 'required|string',
        ]);

        $stockOutId = Str::uuid();

        foreach ($validatedData['item_id'] as $key => $itemId) {
            $inventory = Inventory::findOrFail($itemId);

            if ($inventory->quantity < $validatedData['quantity'][$key]) {
                return redirect()->back()->withErrors(['error' => 'Insufficient quantity for item ' . $inventory->brand->brand . ' ' . $inventory->items_specs]);
            }

            $inventory->quantity -= $validatedData['quantity'][$key];
            $inventory->department_id = $validatedData['department_id'];
            $inventory->stock_out_date = $validatedData['stock_out_date'];
            $inventory->save();

            // Create a new stock out record
            $stockOut = new StockOut();
            $stockOut->stock_out_id = $stockOutId;
            $stockOut->inventory_id = $inventory->id;
            $stockOut->quantity = $validatedData['quantity'][$key];
            $stockOut->department_id = $validatedData['department_id'];
            $stockOut->stock_out_date = $validatedData['stock_out_date'];
            $stockOut->receiver = $validatedData['receiver'];
            $stockOut->save();
        }

        return redirect()->route('inventory.stock.out')->with('success', 'Items stocked out successfully');
    }

    public function showSupplyRequest()
    {
        $user = auth()->user();
        $inventories = Inventory::whereNull('deleted_at')
            ->where('quantity', '>', 0)
            ->with(['brand', 'unit'])
            ->join('brands', 'inventories.brand_id', '=', 'brands.id')
            ->orderBy('brands.brand', 'asc')
            ->select('inventories.*')
            ->get();
        $departments = Department::all();
        $units = Unit::all();
        $brands = Brand::all();
        $suppliers = Supplier::all();
        $userDepartment = $user->department;
        
        // Debug information
        \Log::info('User Department:', [
            'user_id' => $user->id,
            'department_id' => $user->department_id,
            'department' => $userDepartment
        ]);
        
        return view('fcu-ams.inventory.supplyRequest', compact('inventories', 'departments', 'user', 'userDepartment', 'units', 'brands', 'suppliers'));
    }

    public function storeSupplyRequest(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'selected_items' => 'required|json',
            'notes' => 'nullable|string'
        ]);

        $data = json_decode($request->selected_items, true);
        if (!isset($data['items']) || empty($data['items'])) {
            return redirect()->back()->with('error', 'No items selected');
        }

        $requestGroupId = Str::uuid();

        foreach ($data['items'] as $item) {
            $inventory = null;
            if (empty($item['is_new_item'])) {
                // For existing inventory items
                $inventory = DB::table('inventories')
                    ->join('brands', 'inventories.brand_id', '=', 'brands.id')
                    ->where(DB::raw("CONCAT(brands.brand, ' - ', inventories.items_specs)"), '=', $item['name'])
                    ->select('inventories.*')
                    ->first();
            } else {
                // For non-inventory items
                $inventory = DB::table('inventories')
                    ->join('units', 'inventories.unit_id', '=', 'units.id')
                    ->where('inventories.items_specs', '=', $item['name'])
                    ->where('inventories.unit_id', '=', $item['unit_id'])
                    ->where('inventories.unit_price', '=', $item['unit_price'])
                    ->select('inventories.*')
                    ->first();
            }

            $supplyRequest = new SupplyRequest();
            $supplyRequest->request_id = Str::uuid();
            $supplyRequest->request_group_id = $requestGroupId;
            $supplyRequest->department_id = $request->department_id;
            $supplyRequest->requester = auth()->user()->first_name . ' ' . auth()->user()->last_name;
            $supplyRequest->quantity = $item['quantity'];
            $supplyRequest->item_name = $item['name'];
            
            if ($inventory) {
                // For existing inventory items
                $supplyRequest->inventory_id = $inventory->id;
            } else {
                // For non-inventory items
                $supplyRequest->brand_id = $item['brand_id'];
                $supplyRequest->unit_id = $item['unit_id'];
                $supplyRequest->supplier_id = $item['supplier_id'];
                $supplyRequest->estimated_unit_price = $item['unit_price'];
            }

            $supplyRequest->notes = $request->notes;
            $supplyRequest->save();
        }

        return redirect()->route('inventory.supply.request')->with('success', 'Supply request submitted successfully.');
    }

    public function showSupplyRequestDetails($request_group_id)
    {
        $requests = SupplyRequest::with(['department', 'unit', 'inventory'])
            ->where('request_group_id', $request_group_id)
            ->get();

        if ($requests->isEmpty()) {
            abort(404);
        }

        $totalItems = $requests->count();
        $totalPrice = 0;
        
        // Check if all items in the request are approved
        $allApproved = $requests->every(function($request) {
            return $request->status === 'approved';
        });

        // Check if any item is rejected
        $anyRejected = $requests->contains(function($request) {
            return $request->status === 'rejected';
        });

        // Check if any item is approved or partially approved
        $anyApproved = $requests->contains(function($request) {
            return $request->status === 'approved' || $request->status === 'partially_approved';
        });

        // Check if any item is cancelled
        $anyCancelled = $requests->contains(function($request) {
            return $request->status === 'cancelled';
        });

        // Update the overall status
        if ($anyCancelled) {
            $overallStatus = 'cancelled';
        } elseif ($allApproved) {
            $overallStatus = 'approved';
        } elseif ($anyRejected) {
            $overallStatus = 'rejected';
        } elseif ($anyApproved) {
            $overallStatus = 'partially_approved';
        } else {
            $overallStatus = 'pending';
        }
        
        foreach ($requests as $request) {
            if ($request->inventory_id) {
                // For inventory items
                $inventory = \DB::table('inventories')
                    ->join('brands', 'inventories.brand_id', '=', 'brands.id')
                    ->join('units', 'inventories.unit_id', '=', 'units.id')
                    ->where('inventories.id', '=', $request->inventory_id)
                    ->select('inventories.unit_price', 'units.unit')
                    ->first();

                if ($inventory) {
                    // Use estimated_unit_price if it exists (for previously non-inventory items)
                    $request->unit_price = $request->estimated_unit_price ?? $inventory->unit_price;
                    $request->total_price = $request->unit_price * $request->quantity;
                    $request->unit_name = $request->unit ? $request->unit->unit : $inventory->unit;
                }
            } else {
                // For non-inventory items
                $request->unit_price = $request->estimated_unit_price;
                $request->total_price = $request->estimated_unit_price * $request->quantity;
                $request->unit_name = $request->unit ? $request->unit->unit : '';
            }
            
            $totalPrice += $request->total_price;
        }

        // Store the URL that brought us to this page
        session(['supply_request_return_url' => url()->previous()]);

        return view('fcu-ams.inventory.supplyRequestDetails', [
            'requests' => $requests,
            'totalItems' => $totalItems,
            'totalPrice' => $totalPrice,
            'overallStatus' => $overallStatus
        ]);
    }

    public function approveSupplyRequest(Request $request, $request_group_id)
    {
        try {
            DB::beginTransaction();

            $requests = SupplyRequest::where('request_group_id', $request_group_id)
                ->with(['inventory' => function($query) {
                    $query->withoutTrashed();
                }])
                ->get();

            if ($requests->isEmpty()) {
                return redirect()->back()->with('error', 'Supply request not found.');
            }

            foreach ($requests as $supplyRequest) {
                // Skip if already approved
                if ($supplyRequest->status === 'approved') {
                    continue;
                }

                // Simply mark the request as approved
                $supplyRequest->status = 'approved';
                $supplyRequest->save();
            }

            DB::commit();
            return redirect()->back()->with('success', 'Supply request approved successfully.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'An error occurred while processing the request.');
        }
    }

    public function rejectSupplyRequest($request_group_id)
    {
        $requests = SupplyRequest::where('request_group_id', $request_group_id)->get();
        
        if ($requests->isEmpty()) {
            return redirect()->back()->withErrors(['Supply request not found.']);
        }

        DB::beginTransaction();
        try {
            foreach ($requests as $request) {
                $request->status = 'rejected';
                $request->save();
            }
            
            DB::commit();
            $returnUrl = session('supply_request_return_url');
            session()->forget('supply_request_return_url'); // Clear the session after use
            return redirect($returnUrl ?? url()->previous())->with('success', 'Supply request rejected successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['Failed to reject supply request.']);
        }
    }

    public function cancelSupplyRequest($request_group_id)
    {
        $requests = SupplyRequest::where('request_group_id', $request_group_id)->get();
        
        if ($requests->isEmpty()) {
            return redirect()->back()->with('error', 'Supply request not found.');
        }

        DB::beginTransaction();
        try {
            foreach ($requests as $request) {
                // If the request was approved, return the quantity back to inventory
                if ($request->status === 'approved' && $request->inventory_id) {
                    $inventory = Inventory::find($request->inventory_id);
                    if ($inventory) {
                        $inventory->quantity += $request->quantity;
                        $inventory->save();
                    }
                }
                
                $request->status = 'cancelled';
                $request->save();
            }
            
            DB::commit();
            return redirect()->back()->with('success', 'Supply request cancelled successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to cancel supply request. Please try again.');
        }
    }

    public function printSupplyRequest($request_group_id)
    {
        $user = auth()->user();
        if ($user->role === 'Department') {
            abort(403, 'Unauthorized action.');
        }

        $requests = SupplyRequest::with(['department', 'inventory'])
            ->where('request_group_id', $request_group_id)
            ->get();

        if ($requests->isEmpty()) {
            abort(404);
        }

        $totalItems = $requests->count();
        $totalPrice = 0;
        
        foreach ($requests as $request) {
            if ($request->inventory_id) {
                // For inventory items
                $request->unit_price = $request->inventory->unit_price;
                $request->total_price = $request->inventory->unit_price * $request->quantity;
            } else {
                // For non-inventory items
                $request->unit_price = $request->estimated_unit_price;
                $request->total_price = $request->estimated_unit_price * $request->quantity;
            }
            $totalPrice += $request->total_price;
        }

        return view('fcu-ams.inventory.printSupplyRequest', compact('requests', 'totalItems', 'totalPrice'));
    }

    public function export() { 
        return Excel::download(new InventoryExport, 'inventories.csv');
    }

    public function myRequests()
    {
        $user = auth()->user();
        
        $requests = SupplyRequest::select(
                'request_group_id', 
                'requester', 
                'department_id',
                DB::raw('MIN(created_at) as request_date'),
                DB::raw('COUNT(*) as items_count'),
                DB::raw('MAX(status) as group_status'),
                DB::raw('CASE 
                    WHEN MAX(status) = "pending" THEN 1
                    WHEN MAX(status) = "partially_approved" THEN 2
                    WHEN MAX(status) = "approved" THEN 3
                    WHEN MAX(status) = "rejected" THEN 4
                    ELSE 5 END as status_priority')
            )
            ->where('requester', $user->first_name . ' ' . $user->last_name)
            ->groupBy('request_group_id', 'requester', 'department_id')
            ->with('department')
            ->orderBy('status_priority', 'asc')
            ->orderBy('request_date', 'desc')
            ->get();
            
        return view('fcu-ams.inventory.myRequests', compact('requests'));
    }

    public function notifications()
    {
        $user = auth()->user();
        
        // Update last_checked_notifications timestamp
        $user->update(['last_checked_notifications' => now()]);
        
        $notifications = SupplyRequest::select(
                'request_group_id', 
                'requester', 
                'department_id',
                DB::raw('GREATEST(MAX(updated_at), MAX(created_at)) as request_date'),
                DB::raw('COUNT(*) as items_count'),
                DB::raw('MAX(status) as group_status'),
                DB::raw('CASE 
                    WHEN MAX(status) = "pending" THEN 1
                    WHEN MAX(status) = "partially_approved" THEN 2
                    WHEN MAX(status) = "approved" THEN 3
                    WHEN MAX(status) = "rejected" THEN 4
                    ELSE 5 END as status_priority')
            )
            ->where('requester', $user->first_name . ' ' . $user->last_name)
            ->groupBy('request_group_id', 'requester', 'department_id')
            ->with('department')
            ->orderBy('status_priority', 'asc')
            ->orderBy('request_date', 'desc')
            ->get();
            
        return view('fcu-ams.request.notifications', compact('notifications'));
    }
    
    private function determinePrimaryStatus($statuses)
    {
        $statusPriority = [
            'pending' => 1,
            'partially_approved' => 2,
            'approved' => 3,
            'rejected' => 4,
            'cancelled' => 5
        ];
    
        return collect($statuses)->sort(function ($a, $b) use ($statusPriority) {
            return ($statusPriority[$a] ?? 6) - ($statusPriority[$b] ?? 6);
        })->first();
    }

    public function searchItems(Request $request)
    {
        try {
            \Log::info('Search request received', ['query' => $request->input('query')]);
            
            $search = $request->input('query');
            
            if (empty($search)) {
                return response()->json([]);
            }

            $items = DB::table('inventories')
                ->select(
                    'inventories.id',
                    'inventories.items_specs',
                    'inventories.unit_price as price',
                    'inventories.quantity',
                    'brands.brand',
                    'units.unit'
                )
                ->join('brands', 'inventories.brand_id', '=', 'brands.id')
                ->join('units', 'inventories.unit_id', '=', 'units.id')
                ->whereNull('inventories.deleted_at')
                ->where('inventories.quantity', '>=', 0)
                ->where(function($q) use ($search) {
                    $q->where('inventories.items_specs', 'like', "%{$search}%")
                        ->orWhere('brands.brand', 'like', "%{$search}%");
                })
                ->limit(10)
                ->get();

            \Log::info('Search results', ['count' => $items->count(), 'items' => $items]);

            return response()->json($items)
                ->header('Content-Type', 'application/json');
            
        } catch (\Exception $e) {
            \Log::error('Error in searchItems', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json(['error' => $e->getMessage()], 500)
                ->header('Content-Type', 'application/json');
        }
    }

    public function updateSupplyRequest(Request $request, $request_group_id)
    {
        try {
            DB::beginTransaction();

            // Validate request
            $request->validate([
                'items' => 'required|json',
                'new_items' => 'nullable|json'
            ]);

            $items = json_decode($request->items, true);
            $newItems = $request->has('new_items') ? json_decode($request->new_items, true) : [];
            $user = auth()->user();

            // Get all existing requests in this group
            $existingRequests = SupplyRequest::where('request_group_id', $request_group_id)->get();
            
            // Log existing requests
            \Log::info('Existing requests', [
                'count' => $existingRequests->count(),
                'request_group_id' => $request_group_id,
                'requests' => $existingRequests->toArray()
            ]);

            // Only allow editing if user is the requester and request is not approved/rejected
            $canEdit = $existingRequests->first()->requester === $user->first_name . ' ' . $user->last_name
                && !$existingRequests->contains('status', 'approved')
                && !$existingRequests->contains('status', 'rejected')
                && !$existingRequests->contains('status', 'cancelled');

            if (!$canEdit) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot edit this request.'
                ], 403);
            }

            // Get all request IDs from the submitted form
            $submittedRequestIds = collect($items)->pluck('request_id')->filter()->all();

            // Delete items that were removed (not present in the submitted form)
            foreach ($existingRequests as $existingRequest) {
                if (!in_array($existingRequest->id, $submittedRequestIds)) {
                    \Log::info('Deleting request', [
                        'request_id' => $existingRequest->id,
                        'request_group_id' => $existingRequest->request_group_id
                    ]);
                    $existingRequest->delete();
                }
            }

            // Update quantities for existing items
            foreach ($items as $item) {
                if (isset($item['request_id'])) {
                    $supplyRequest = $existingRequests->find($item['request_id']);
                    if ($supplyRequest) {
                        $supplyRequest->quantity = $item['quantity'];
                        $supplyRequest->save();
                        \Log::info('Updated existing item', [
                            'request_id' => $supplyRequest->id,
                            'request_group_id' => $supplyRequest->request_group_id,
                            'quantity' => $item['quantity']
                        ]);
                    }
                }
            }

            // Handle new items
            if (!empty($newItems)) {
                foreach ($newItems as $newItem) {
                    $supplyRequest = new SupplyRequest();
                    $supplyRequest->request_id = Str::uuid();
                    $supplyRequest->request_group_id = $request_group_id;
                    $supplyRequest->department_id = $existingRequests->first()->department_id;
                    $supplyRequest->requester = $user->first_name . ' ' . $user->last_name;
                    $supplyRequest->item_name = $newItem['name'];
                    $supplyRequest->quantity = $newItem['quantity'];
                    $supplyRequest->status = 'pending';
                    
                    // Try to find matching inventory
                    $inventory = DB::table('inventories')
                        ->join('brands', 'inventories.brand_id', '=', 'brands.id')
                        ->where(DB::raw("CONCAT(brands.brand, ' - ', inventories.items_specs)"), '=', $newItem['name'])
                        ->select('inventories.*')
                        ->first();

                    if ($inventory) {
                        $supplyRequest->inventory_id = $inventory->id;
                    } else {
                        // For non-inventory items
                        $supplyRequest->estimated_unit_price = $newItem['unit_price'];
                    }
                    
                    $supplyRequest->save();

                    \Log::info('Added new item', [
                        'request_id' => $supplyRequest->request_id,
                        'request_group_id' => $supplyRequest->request_group_id,
                        'item_name' => $newItem['name'],
                        'quantity' => $newItem['quantity']
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Supply request updated successfully.'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error updating supply request', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error updating supply request: ' . $e->getMessage()
            ], 500);
        }
    }

    public function import(Request $request)
    {
        try {
            if (!auth()->check()) {
                return redirect()->back()->with('error', 'You must be logged in to import data.');
            }

            $userId = auth()->id();

            if (!$request->hasFile('file')) {
                return redirect()->back()->with('error', 'No file uploaded.');
            }

            $file = $request->file('file');
            $successCount = 0;
            $errorCount = 0;
            $skippedRows = []; // Keep track of skipped rows

            DB::beginTransaction();

            $data = Excel::toArray([], $file)[0];
            
            if (empty($data)) {
                DB::rollback();
                return redirect()->back()->with('error', 'The uploaded file is empty.');
            }

            // Get the headers from the first row and convert to lowercase
            $headers = array_map('strtolower', $data[0]);
            
            // Remove the header row
            array_shift($data);

            foreach ($data as $rowNumber => $row) {
                $currentRowNumber = $rowNumber + 2; // Excel row number
                $rowData = null;
                try {
                    // Pad the row with nulls if it has fewer columns than headers
                    $row = array_pad($row, count($headers), null);
                    $rowData = array_combine($headers, $row);

                    // Trim whitespace from all values
                    $rowData = array_map(function($value) {
                        return is_string($value) ? trim($value) : $value;
                    }, $rowData);

                    // Skip empty rows
                    if (empty(array_filter($rowData, function($value) { return !is_null($value) && $value !== ''; }))) {
                        continue;
                    }

                    // Validate required fields
                    $requiredImportHeaders = ['items_specs', 'quantity', 'unit', 'brand', 'unit_price', 'supplier'];
                    $missingImportFields = [];
                    foreach ($requiredImportHeaders as $reqHeader) {
                        if (!isset($rowData[$reqHeader]) || $rowData[$reqHeader] === '' || is_null($rowData[$reqHeader])) {
                             $missingImportFields[] = $reqHeader;
                        }
                    }
                    if (!empty($missingImportFields)) {
                        throw new \Exception('Missing required fields: ' . implode(', ', $missingImportFields));
                    }

                    // Find or create unit
                    $unit = Unit::firstOrCreate(['unit' => $rowData['unit']]);

                    // Find or create brand
                    $brand = Brand::firstOrCreate(['brand' => $rowData['brand']]);

                    // Find or create supplier using the correct column name 'supplier'
                    $supplier = Supplier::firstOrCreate(['supplier' => $rowData['supplier']]);

                    // Clean up the unit price (remove currency symbol and commas)
                    $unitPrice = str_replace(['₱', ',', '$'], '', $rowData['unit_price']);
                    if (!is_numeric($unitPrice)) {
                        throw new \Exception('Invalid format for unit_price field.');
                    }
                    if (!is_numeric($rowData['quantity'])) {
                        throw new \Exception('Invalid format for quantity field.');
                    }

                    // Check if supplier was found/created successfully
                    if (!$supplier || !$supplier->id) {
                        throw new \Exception('Failed to create or find supplier');
                    }

                    // --- Check for existing inventory ---
                    $existingInventory = Inventory::where('items_specs', $rowData['items_specs'])
                        ->where('brand_id', $brand->id)
                        ->where('unit_id', $unit->id)
                        ->where('unit_price', $unitPrice)
                        ->where('supplier_id', $supplier->id)
                        ->whereNull('deleted_at')
                        ->first();

                    if ($existingInventory) {
                        // --- Update existing inventory quantity ---
                        $existingInventory->quantity += $rowData['quantity'];
                        $existingInventory->save();
                        \Log::info('Updated existing inventory quantity:', [
                            'row_number' => $currentRowNumber,
                            'inventory_id' => $existingInventory->id,
                            'added_quantity' => $rowData['quantity']
                        ]);
                    } else {
                        // --- Create new inventory item ---
                        $inventory = new Inventory([
                            'items_specs' => $rowData['items_specs'],
                            'quantity' => $rowData['quantity'],
                            'unit_id' => $unit->id,
                            'brand_id' => $brand->id,
                            'unit_price' => $unitPrice,
                            'supplier_id' => $supplier->id,  // Explicitly set supplier_id
                            'created_by' => $userId, // Use the fetched user ID
                        ]);
                        $inventory->save();
                    }

                    $successCount++;

                } catch (\Exception $e) {
                    $errorCount++;
                    $skippedRows[] = $currentRowNumber; // Add row number to skipped list
                    \Log::error('Error processing inventory import row:', [
                        'row_number' => $currentRowNumber,
                        'error' => $e->getMessage(),
                        'data' => $rowData ?? $row // Log raw row if array_combine failed
                    ]);
                    // Optional: Continue to next row instead of rolling back immediately
                }
            }

            DB::commit();

            $message = "Inventory import completed. Successfully processed/updated {$successCount} items.";
            if ($errorCount > 0) {
                // Ensure skipped rows are unique in the message
                $uniqueSkippedRows = array_unique($skippedRows);
                sort($uniqueSkippedRows); // Optional: sort row numbers
                $message .= " {$errorCount} rows were skipped due to errors (Rows: " . implode(', ', $uniqueSkippedRows) . "). Check logs for details.";
            }

            return redirect()->route('inventory.list')->with('success', $message); // Redirect to inventory list

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Inventory import failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
             // Provide more specific error if possible
            if (isset($currentRowNumber)) {
                return redirect()->back()->with('error', "Error importing data near row {$currentRowNumber}: " . $e->getMessage());
            } else {
                return redirect()->back()->with('error', 'Error importing data: ' . $e->getMessage());
            }
        }
    }

    public function importAsset(Request $request)
    {
        try {
            if (!auth()->check()) {
                return redirect()->back()->with('error', 'You must be logged in to import data.');
            }

            $userId = auth()->user()->id;

            if (!$request->hasFile('file')) {
                return redirect()->back()->with('error', 'No file uploaded.');
            }

            $file = $request->file('file');
            $successCount = 0;
            $errorCount = 0;
            $skippedRows = []; // Keep track of skipped rows for detailed feedback

            DB::beginTransaction();

            $data = Excel::toArray([], $file)[0];

            if (empty($data) || count($data) < 2) { // Check if data exists and has at least one data row besides header
                DB::rollback();
                return redirect()->back()->with('error', 'The uploaded file is empty or missing headers.');
            }

            // Get the headers from the first row and convert to lowercase, trim whitespace
            $headers = array_map(function($header) {
                return trim(strtolower($header));
            }, $data[0]);

            // Define required headers based on the assets table structure
            $requiredHeaders = [
                'asset_tag_id', 'brand', 'model', 'serial_number', 'cost',
                'supplier', 'site', 'location', 'category', 'department', 'purchase_date'
            ];
            // Optional but commonly used headers
            $optionalHeaders = ['specs', 'status', 'condition', 'notes', 'assigned_to', 'issued_date'];

            // Check if all required headers are present
            $missingHeaders = array_diff($requiredHeaders, $headers);
            if (!empty($missingHeaders)) {
                DB::rollback();
                return redirect()->back()->with('error', 'Missing required columns in the file: ' . implode(', ', $missingHeaders));
            }

            // Remove the header row
            array_shift($data);

            foreach ($data as $rowNumber => $row) {
                $currentRowNumber = $rowNumber + 2; // Excel row number (1-based index + header)
                $rowData = null; // Initialize rowData for logging in case of early failure
                try {
                    // Pad the row with nulls if it has fewer columns than headers
                    $row = array_pad($row, count($headers), null);
                    $rowData = array_combine($headers, $row);

                    // Trim whitespace from all values
                    $rowData = array_map(function($value) {
                        return is_string($value) ? trim($value) : $value;
                    }, $rowData);

                    // Skip empty rows (all values are null or empty strings)
                    if (empty(array_filter($rowData, function($value) { return !is_null($value) && $value !== ''; }))) {
                        continue;
                    }

                    // --- Basic Validation ---
                    $missingFields = [];
                    foreach ($requiredHeaders as $reqHeader) {
                        if (!isset($rowData[$reqHeader]) || $rowData[$reqHeader] === '' || is_null($rowData[$reqHeader])) {
                            $missingFields[] = $reqHeader;
                        }
                    }
                    if (!empty($missingFields)) {
                        throw new \Exception('Missing required fields: ' . implode(', ', $missingFields));
                    }

                    // --- Check if Asset Tag ID already exists ---
                    $assetTagId = $rowData['asset_tag_id'];
                    if (Asset::where('asset_tag_id', $assetTagId)->exists()) {
                        $errorCount++;
                        $skippedRows[] = $currentRowNumber;
                        \Log::warning('Skipping asset import row due to existing asset_tag_id:', [
                            'row_number' => $currentRowNumber,
                            'asset_tag_id' => $assetTagId,
                            'data' => $rowData
                        ]);
                        continue; // Skip to the next row
                    }

                    // --- Look up or Create Related Models ---
                    $brand = Brand::firstOrCreate(['brand' => $rowData['brand']]);
                    $supplier = Supplier::firstOrCreate(['supplier' => $rowData['supplier']]);
                    $site = Site::firstOrCreate(['site' => $rowData['site']]);
                    $location = Location::firstOrCreate(['location' => $rowData['location']]);
                    $category = Category::firstOrCreate(['category' => $rowData['category']]);
                    $department = Department::firstOrCreate(['department' => $rowData['department']]);

                    // Optional: Status and Condition
                    $status = isset($rowData['status']) && !empty($rowData['status']) ? Status::firstOrCreate(['status' => $rowData['status']]) : null;
                    $condition = isset($rowData['condition']) && !empty($rowData['condition']) ? Condition::firstOrCreate(['condition' => $rowData['condition']]) : null;

                    // --- Data Cleaning and Formatting ---
                    // Clean up the cost (remove currency symbols and commas)
                    $cost = str_replace([',', '₱', '$'], '', $rowData['cost']);
                    if (!is_numeric($cost)) {
                        throw new \Exception('Invalid format for cost field.');
                    }

                    // --- Parse Purchase Date ---
                    $purchaseDateInput = $rowData['purchase_date'];
                    $purchaseDate = null; // Initialize variable
                    try {
                        if (is_numeric($purchaseDateInput)) {
                            $purchaseDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($purchaseDateInput)->format('Y-m-d');
                        } elseif (is_string($purchaseDateInput) && !empty($purchaseDateInput)) {
                            try {
                                $purchaseDate = Carbon::createFromFormat('d/m/Y', $purchaseDateInput)->format('Y-m-d');
                            } catch (\InvalidArgumentException $e1) {
                                try {
                                    $purchaseDate = Carbon::parse($purchaseDateInput)->format('Y-m-d');
                                } catch (\Exception $e2) {
                                    throw new \Exception("Could not parse date '{$purchaseDateInput}'. Expected formats like DD/MM/YYYY, YYYY-MM-DD, or Excel numeric date.");
                                }
                            }
                        }
                        if (is_null($purchaseDate) && in_array('purchase_date', $requiredHeaders)) {
                             throw new \Exception("Purchase date '{$purchaseDateInput}' is empty or could not be parsed, and it is required.");
                        }
                    } catch (\Exception $dateError) {
                        throw new \Exception('Error parsing purchase_date field: ' . $dateError->getMessage());
                    }

                    // --- Parse Issued Date (Optional) ---
                    $issuedDateInput = $rowData['issued_date'] ?? null; // Get value if header exists
                    $issuedDate = null; // Initialize variable
                    if (!empty($issuedDateInput)) { // Only parse if there's a value
                        try {
                            if (is_numeric($issuedDateInput)) {
                                // Handle Excel numeric date format
                                $issuedDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($issuedDateInput)->format('Y-m-d');
                            } elseif (is_string($issuedDateInput)) {
                                // Attempt to parse specific formats, prioritizing d/m/Y
                                try {
                                    // Try d/m/Y format first
                                    $issuedDate = Carbon::createFromFormat('d/m/Y', $issuedDateInput)->format('Y-m-d');
                                } catch (\InvalidArgumentException $e1) {
                                    try {
                                        // Fallback to general parse
                                        $issuedDate = Carbon::parse($issuedDateInput)->format('Y-m-d');
                                    } catch (\Exception $e2) {
                                        // Log warning instead of throwing error for optional field
                                        \Log::warning('Could not parse optional issued_date field:', [
                                            'row_number' => $currentRowNumber,
                                            'value' => $issuedDateInput,
                                            'error' => $e2->getMessage()
                                        ]);
                                        // Keep $issuedDate as null if parsing fails
                                    }
                                }
                            }
                        } catch (\Exception $dateError) {
                             \Log::warning('Error parsing optional issued_date field:', [
                                'row_number' => $currentRowNumber,
                                'value' => $issuedDateInput,
                                'error' => $dateError->getMessage()
                             ]);
                             // Keep $issuedDate as null if parsing fails
                        }
                    }

                    // --- Create Asset ---
                    $asset = new Asset([
                        'asset_tag_id' => $assetTagId, // Use the validated asset tag ID
                        'brand_id' => $brand->id,
                        'model' => $rowData['model'],
                        'specs' => $rowData['specs'] ?? null,
                        'serial_number' => $rowData['serial_number'],
                        'cost' => $cost,
                        'supplier_id' => $supplier->id,
                        'site_id' => $site->id,
                        'location_id' => $location->id,
                        'category_id' => $category->id,
                        'department_id' => $department->id,
                        'purchase_date' => $purchaseDate, // Use the parsed date
                        'status_id' => $status ? $status->id : 1,
                        'condition_id' => $condition ? $condition->id : 1,
                        'notes' => $rowData['notes'] ?? null,
                        'created_by' => $userId, // Use the fetched user ID
                        'assigned_to' => $rowData['assigned_to'] ?? null,
                        'issued_date' => $issuedDate,
                    ]);

                    $asset->save();
                    $successCount++;

                } catch (\Exception $e) {
                    $errorCount++;
                    $skippedRows[] = $currentRowNumber; // Add row number to skipped list
                    \Log::error('Error processing asset import row:', [
                        'row_number' => $currentRowNumber,
                        'error' => $e->getMessage(),
                        'data' => $rowData ?? $row // Log raw row if array_combine failed or other early error
                    ]);
                    // Optional: Continue to next row instead of rolling back immediately
                    // DB::rollback(); // Uncomment if you want to stop the entire import on first error
                    // return redirect()->back()->with('error', "Error processing row {$currentRowNumber}: " . $e->getMessage()); // Uncomment for immediate feedback
                }
            }

            // If we processed all rows without critical failure (or chose to continue on errors)
            DB::commit();

            $message = "Asset import completed. Successfully processed {$successCount} assets.";
            if ($errorCount > 0) {
                // Ensure skipped rows are unique in the message
                $uniqueSkippedRows = array_unique($skippedRows);
                sort($uniqueSkippedRows); // Optional: sort row numbers
                $message .= " {$errorCount} rows were skipped due to errors or existing data (Rows: " . implode(', ', $uniqueSkippedRows) . "). Check logs for details.";
            }

            return redirect()->route('asset.list')->with('success', $message); // Redirect to asset list

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Asset import failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            // Provide more specific error if possible
            if (isset($currentRowNumber)) {
                return redirect()->back()->with('error', "Error importing data near row {$currentRowNumber}: " . $e->getMessage());
            } else {
                return redirect()->back()->with('error', 'Error importing data: ' . $e->getMessage());
            }
        }
    }
}
