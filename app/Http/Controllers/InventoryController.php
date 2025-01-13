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
use App\Models\Unit;
use App\Models\AssetEditHistory;
use App\Models\InventoryEditHistory;
use App\Imports\AssetsImport;
use Illuminate\Validation\Rule;

class InventoryController extends Controller
{
    public function index(Request $request) {
        $brands = $request->input('brands', []);
        $selectedBrands = $brands;
        
        $totalItems = DB::table('inventories')
            ->whereNull('deleted_at')
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
        $lowStock = Inventory::with(['unit', 'supplier'])
            ->where('quantity', '>=', 1)
            ->where('quantity', '<', 20)
            ->whereNull('deleted_at')
            ->orderBy('unique_tag', 'asc')
            ->get();

        return view('fcu-ams/inventory/lowStock', compact('lowStock'));
    }

    public function outOfStock(Request $request)
    {
        $outOfStock = Inventory::with(['unit', 'supplier'])
            ->where('quantity', '=', 0)
            ->whereNull('deleted_at')
            ->orderBy('unique_tag', 'asc')
            ->get();

        return view('fcu-ams/inventory/outOfStock', compact('outOfStock'));
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
            'request_date' => 'required|date',
            'selected_items' => 'required|json'
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
            $supplyRequest->request_date = $request->request_date;
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

        // Update the overall status
        if ($allApproved) {
            $overallStatus = 'approved';
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

            $hasPartialApproval = false;
            $allFullyProcessed = true;

            foreach ($requests as $supplyRequest) {
                // Skip if already approved
                if ($supplyRequest->status === 'approved') {
                    continue;
                }

                $inventory = null;
                
                if ($supplyRequest->inventory_id) {
                    $inventory = Inventory::find($supplyRequest->inventory_id);
                } else {
                    // For non-inventory items, try to find matching inventory
                    $matchingInventory = DB::table('inventories')
                        ->join('units', 'inventories.unit_id', '=', 'units.id')
                        ->where('inventories.items_specs', '=', $supplyRequest->item_name)
                        ->where('inventories.unit_id', '=', $supplyRequest->unit_id)
                        ->where('inventories.unit_price', '=', $supplyRequest->estimated_unit_price)
                        ->select('inventories.id')
                        ->first();
                        
                    if ($matchingInventory) {
                        $inventory = Inventory::find($matchingInventory->id);
                    } else {
                        $hasPartialApproval = true;
                        continue;
                    }
                }
                
                if (!$inventory) {
                    continue;
                }

                if ($inventory->quantity >= $supplyRequest->quantity) {
                    // Full approval
                    $inventory->quantity -= $supplyRequest->quantity;
                    $inventory->save();
                    
                    $supplyRequest->status = 'approved';
                    $supplyRequest->inventory_id = $inventory->id;
                    // Preserve original unit and price for non-inventory items
                    if (!$supplyRequest->getOriginal('inventory_id')) {
                        $supplyRequest->estimated_unit_price = $supplyRequest->estimated_unit_price;
                    }
                    $supplyRequest->save();
                } else if ($inventory->quantity > 0) {
                    // Partial approval
                    $availableQuantity = $inventory->quantity;
                    $requestedQuantity = $supplyRequest->quantity;
                    
                    // Update inventory
                    $inventory->quantity = 0;
                    $inventory->save();
                    
                    // Create a new request for the approved quantity
                    $approvedRequest = new SupplyRequest();
                    $approvedRequest->request_id = Str::uuid();
                    $approvedRequest->request_group_id = $request_group_id;
                    $approvedRequest->department_id = $supplyRequest->department_id;
                    $approvedRequest->requester = $supplyRequest->requester;
                    $approvedRequest->item_name = $supplyRequest->item_name;
                    $approvedRequest->quantity = $availableQuantity;
                    $approvedRequest->request_date = $supplyRequest->request_date;
                    $approvedRequest->status = 'approved';
                    $approvedRequest->inventory_id = $inventory->id;
                    // Preserve original unit and price
                    $approvedRequest->estimated_unit_price = $supplyRequest->estimated_unit_price;
                    $approvedRequest->unit_id = $supplyRequest->unit_id;
                    $approvedRequest->save();
                    
                    // Update original request with remaining quantity
                    $supplyRequest->quantity = $requestedQuantity - $availableQuantity;
                    $supplyRequest->notes = "Partially approved: {$availableQuantity} units approved, {$supplyRequest->quantity} units pending";
                    $supplyRequest->save();
                    
                    $hasPartialApproval = true;
                    $allFullyProcessed = false;
                } else {
                    $allFullyProcessed = false;
                }
            }

            DB::commit();

            $message = $hasPartialApproval 
                ? 'Request partially approved. Some items were approved with available stock.' 
                : ($allFullyProcessed ? 'Supply request approved successfully.' : 'Some items could not be approved due to insufficient stock.');

            return redirect()->back()->with('success', $message);

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

    public function printSupplyRequest($request_group_id)
    {
        $user = auth()->user();
        if ($user->role === 'Viewer') {
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
        
        $requests = SupplyRequest::select('request_group_id', 'requester', 'status', 'request_date', 'department_id', 
                     DB::raw('COUNT(*) as items_count'))
            ->where('requester', $user->first_name . ' ' . $user->last_name)
            ->groupBy('request_group_id', 'requester', 'status', 'request_date', 'department_id')
            ->with('department')
            ->orderBy('request_date', 'desc')
            ->get();
            
        return view('fcu-ams.inventory.myRequests', compact('requests'));
    }

    public function notifications()
    {
        $user = auth()->user();
        $notifications = SupplyRequest::with('inventory')
            ->select('request_group_id', 'requester', 'status', 'request_date', 'notes')
            ->selectRaw('COUNT(*) as items_count')
            ->where('requester', $user->first_name . ' ' . $user->last_name)
            ->groupBy('request_group_id', 'requester', 'status', 'request_date', 'notes')
            ->orderBy('request_date', 'desc')
            ->get();

        return view('fcu-ams.request.notifications', compact('notifications'));
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
}
