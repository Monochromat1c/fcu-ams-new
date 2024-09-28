<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Inventory;
use Illuminate\Validation\Rule;

class InventoryController extends Controller
{
    public function index(Request $request) {
        $totalItems = DB::table('inventories')->count();
        $totalValue = DB::table('inventories')->sum(DB::raw('unit_price * quantity'));
        $lowStock = DB::table('inventories')
            ->where('quantity', '>=', 1)
            ->where('quantity', '<', 20)
            ->whereNull('deleted_at')
            ->count();
        $outOfStock = DB::table('inventories')
            ->where('quantity', '=', '0')
            ->whereNull('deleted_at')
            ->count();
        $sort = $request->input('sort', 'items_specs');
        $direction = $request->input('direction', 'asc');
        $search = $request->input('search');

        $query = DB::table('inventories')
            ->leftJoin('suppliers', 'inventories.supplier_id', '=', 'suppliers.id')
            ->leftJoin('units', 'inventories.unit_id', '=', 'units.id')
            ->select('inventories.*', 'suppliers.supplier as supplier_name', 'units.unit as unit_name');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('inventories.items_specs', 'like', '%' . $search . '%')
                    ->orWhere('suppliers.supplier', 'like', '%' . $search . '%')
                    ->orWhere('inventories.unit', 'like', '%' . $search . '%');
            });
        }

        if ($request->input('clear') == 'true') {
            return redirect()->route('inventory.list');
        }

        if ($sort && $direction) {
            if ($sort == 'total_item_price') {
                $query->orderBy(DB::raw('unit_price * quantity'), $direction);
            } else {
                $query->orderBy($sort, $direction);
            }
        } else {
            $query->orderBy('items_specs', 'asc');
        }

        $query->where('inventories.quantity', '>', 0);
        $inventories = $query->whereNull('inventories.deleted_at')->paginate(15);

        return view('fcu-ams/inventory/inventoryList', compact('totalItems', 'totalValue', 'lowStock', 'outOfStock', 'inventories', 'sort', 'direction', 'search'));
    }

    public function show($id)
    {
        $inventory = Inventory::with('supplier', 'unit')->findOrFail($id);
        return view('fcu-ams/inventory/viewInventory', compact('inventory'));
    }

    public function create() {
        $suppliers = DB::table('suppliers')->get();
        $units = DB::table('units')->get();
        return view('fcu-ams/inventory/stockIn', compact('suppliers', 'units'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'brand' => 'required|string',
            'items_specs' => [
                'required',
                'string',
                Rule::unique('inventories', 'items_specs')->whereNull('deleted_at'),
            ],
            'unit_id' => 'required|integer|exists:units,id',
            'quantity' => 'required|numeric',
            'unit_price' => 'required|numeric',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'stock_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $inventory = new Inventory();
        $inventory->brand = $validatedData['brand'];
        $inventory->items_specs = $validatedData['items_specs'];
        $inventory->unit_id = $validatedData['unit_id'];
        $inventory->quantity = $validatedData['quantity'];
        $inventory->unit_price = $validatedData['unit_price'];
        $inventory->supplier_id = $validatedData['supplier_id'];

        if ($request->hasFile('stock_image')) {
            $imageName = time().'.'.$request->stock_image->extension();
            $request->stock_image->move(public_path('profile'), $imageName);
            $inventory->stock_image = 'profile/'.$imageName;
        }

        $inventory->save();

        $request->session()->put('input', $request->all());

        return redirect()->route('inventory.stock.in')->with('success', 'Item added to inventory.');
    }

    public function edit($id)
    {
        $inventory = Inventory::findOrFail($id);
        $suppliers = DB::table('suppliers')->get();
        $units = DB::table('units')->get();

        return view('fcu-ams/inventory/updateStock', compact('inventory', 'suppliers', 'units'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'brand' => 'required|string',
            'items_specs' => [
                'required',
                'string',
                Rule::unique('inventories', 'items_specs')->ignore($id)->whereNull('deleted_at'),
            ],
            'unit_id' => 'required|integer|exists:units,id',
            'quantity' => 'required|numeric',
            'unit_price' => 'required|numeric',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'stock_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $inventory = Inventory::findOrFail($id);
        $inventory->brand = $validatedData['brand'];
        $inventory->items_specs = $validatedData['items_specs'];
        $inventory->unit_id = $validatedData['unit_id'];
        $inventory->quantity = $validatedData['quantity'];
        $inventory->unit_price = $validatedData['unit_price'];
        $inventory->supplier_id = $validatedData['supplier_id'];

        if ($request->hasFile('stock_image')) {
            $imageName = time() . '.' . $request->stock_image->extension();
            $request->stock_image->move(public_path('profile'), $imageName);
            $inventory->stock_image = 'profile/' . $imageName;
        }

        $inventory->save();

        return redirect()->route('inventory.list')->with('success', 'Item updated successfully.');
    }

    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();

        return redirect()->route('inventory.list')->with('success', 'Inventory item deleted successfully.');
    }

    public function createStockOut()
    {
        $inventories = Inventory::whereNull('deleted_at')->get();
        return view('fcu-ams/inventory/stockOut', compact('inventories'));
    }

    public function storeStockOut(Request $request)
    {
        $validatedData = $request->validate([
            'item_id' => 'required|integer|exists:inventories,id',
            'quantity' => 'required|numeric|min:1',
        ]);

        $inventory = Inventory::findOrFail($validatedData['item_id']);

        if ($inventory->quantity < $validatedData['quantity']) {
            return redirect()->back()->with('error', 'Insufficient quantity');
        }

        $inventory->quantity -= $validatedData['quantity'];
        $inventory->save();

        return redirect()->route('inventory.stock.out')->with('success', 'Item stocked out successfully');
    }
}
