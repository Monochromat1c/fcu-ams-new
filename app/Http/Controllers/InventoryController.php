<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Inventory;
use App\Models\Asset;
use App\Models\Supplier;
use App\Models\Site;
use App\Models\Location;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Department;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\StockOut;
use App\Models\AssetEditHistory;
use App\Models\InventoryEditHistory;
use App\Models\SupplyRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AssetsExport;
use App\Exports\InventoryExport;
use App\Imports\AssetsImport;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

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
        $userDepartment = $user->department;
        
        // Debug information
        \Log::info('User Department:', [
            'user_id' => $user->id,
            'department_id' => $user->department_id,
            'department' => $userDepartment
        ]);
        
        return view('fcu-ams.inventory.supplyRequest', compact('inventories', 'departments', 'user', 'userDepartment'));
    }

    public function storeSupplyRequest(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'items' => 'required|array',
            'items.*.id' => 'required|exists:inventories,id',
            'items.*.quantity' => 'required|integer|min:1'
        ]);

        try {
            DB::beginTransaction();
            
            $requestGroupId = (string) Str::uuid();
            
            foreach ($request->items as $item) {
                $supplyRequest = new SupplyRequest();
                $supplyRequest->request_id = (string) Str::uuid();
                $supplyRequest->request_group_id = $requestGroupId;
                $supplyRequest->department_id = $request->department_id;
                $supplyRequest->notes = $request->notes;
                $supplyRequest->inventory_id = $item['id'];
                $supplyRequest->requester = auth()->user()->first_name . ' ' . auth()->user()->last_name;
                $supplyRequest->quantity = $item['quantity'];
                $supplyRequest->request_date = now();
                $supplyRequest->save();
            }
            
            DB::commit();
            return redirect()->back()->with('success', 'Supply request submitted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to submit supply request. Please try again.');
        }
    }

    public function showSupplyRequestDetails($request_group_id)
    {
        $requests = SupplyRequest::with(['inventory.brand', 'department'])
            ->where('request_group_id', $request_group_id)
            ->get();

        if ($requests->isEmpty()) {
            abort(404);
        }

        $totalItems = $requests->count();
        $totalValue = $requests->sum(function ($request) {
            return $request->quantity * $request->inventory->unit_price;
        });

        return view('fcu-ams.inventory.supplyRequestDetails', [
            'requests' => $requests,
            'totalItems' => $totalItems,
            'totalValue' => $totalValue
        ]);
    }

    public function approveSupplyRequest($request_group_id)
    {
        $requests = SupplyRequest::where('request_group_id', $request_group_id)->get();
        
        if ($requests->isEmpty()) {
            return redirect()->back()->with('error', 'Supply request not found.');
        }

        DB::beginTransaction();
        try {
            foreach ($requests as $request) {
                $inventory = $request->inventory;
                
                if ($inventory->quantity < $request->quantity) {
                    throw new \Exception("Insufficient stock for {$inventory->items_specs}");
                }
                
                $inventory->quantity -= $request->quantity;
                $inventory->save();
                
                $request->status = 'approved';
                $request->save();
            }
            
            DB::commit();
            return redirect()->back()->with('success', 'Supply request approved successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function rejectSupplyRequest($request_group_id)
    {
        $requests = SupplyRequest::where('request_group_id', $request_group_id)->get();
        
        if ($requests->isEmpty()) {
            return redirect()->back()->with('error', 'Supply request not found.');
        }

        foreach ($requests as $request) {
            $request->status = 'rejected';
            $request->save();
        }

        return redirect()->back()->with('success', 'Supply request rejected successfully.');
    }

    public function export() { 
        return Excel::download(new InventoryExport, 'inventories.csv');
    }
}
