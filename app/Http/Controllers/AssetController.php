<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Asset;
use App\Models\Supplier;
use App\Models\Site;
use App\Models\Location;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Department;
use App\Models\AssetEditHistory;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AssetsExport;
use App\Imports\AssetsImport;
use Illuminate\Validation\Rule;

class AssetController extends Controller
{
    public function index(Request $request) {
        $totalAssets = DB::table('assets')->whereNull('deleted_at')->count();
        $totalCost = DB::table('assets')->whereNull('deleted_at')->sum('cost');
        $lowValueAssets = DB::table('assets')->where('cost', '<', 1000)->whereNull('deleted_at')->count();
        $highValueAssets = DB::table('assets')->where('cost', '>=', 1000)->whereNull('deleted_at')->count();

        $sort = $request->input('sort', 'asset_name');
        $direction = $request->input('direction', 'asc');
        $search = $request->input('search');

        $query = DB::table('assets')
            ->leftJoin('suppliers', 'assets.supplier_id', '=', 'suppliers.id')
            ->leftJoin('sites', 'assets.site_id', '=', 'sites.id')
            ->leftJoin('locations', 'assets.location_id', '=', 'locations.id')
            ->leftJoin('categories', 'assets.category_id', '=', 'categories.id')
            ->leftJoin('departments', 'assets.department_id', '=', 'departments.id')
            ->leftJoin('conditions', 'assets.condition_id', '=', 'conditions.id')
            ->select('assets.*', 'suppliers.supplier as supplier_name', 'sites.site as site_name', 'conditions.condition as condition_name','locations.location as location_name', 'categories.category as category_name', 'departments.department as department_name');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('assets.asset_name', 'like', '%' . $search . '%')
                    ->orWhere('suppliers.supplier', 'like', '%' . $search . '%')
                    ->orWhere('sites.site', 'like', '%' . $search . '%')
                    ->orWhere('locations.location', 'like', '%' . $search . '%')
                    ->orWhere('categories.category', 'like', '%' . $search . '%')
                    ->orWhere('departments.department', 'like', '%' . $search . '%');
            });
        }

        if ($request->input('clear') == 'true') {
            return redirect()->route('asset.list');
        }

        if ($sort && $direction) {
            $query->orderBy($sort, $direction);
        } else {
            $query->orderBy('asset_name', 'asc');
        }

        $assets = $query->whereNull('assets.deleted_at')->paginate(15);

        return view('fcu-ams/asset/assetList', compact('totalAssets', 'totalCost', 'lowValueAssets', 'highValueAssets', 'assets', 'sort', 'direction', 'search'));
    }

    public function create() {
        $suppliers = DB::table('suppliers')->get();
        $sites = DB::table('sites')->get();
        $locations = DB::table('locations')->get();
        $categories = DB::table('categories')->get();
        $departments = DB::table('departments')->get();
        $conditions = DB::table('conditions')->get();
        return view('fcu-ams/asset/addAsset', compact('suppliers', 'sites', 'locations', 'categories', 'departments', 'conditions'));
    }

    public function show($id)
    {
        $asset = Asset::with(['supplier', 'site', 'location', 'category', 'department', 'editHistory', 'condition'])->findOrFail($id);
        return view('fcu-ams/asset/viewAsset', compact('asset'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'asset_name' => [
                'required',
                'string',
                Rule::unique('assets', 'asset_name')->whereNull('deleted_at'),
            ],
            'brand' => 'required|string',
            'model' => 'required|string',
            'serial_number' => 'required|string',
            'cost' => 'required|numeric',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'site_id' => 'required|integer|exists:sites,id',
            'location_id' => 'required|integer|exists:locations,id',
            'category_id' => 'required|integer|exists:categories,id',
            'department_id' => 'required|integer|exists:departments,id',
            'condition_id' => 'required|integer|exists:conditions,id',
            'purchase_date' => 'required|date',
            'asset_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $asset = new Asset();
        $asset->asset_name = $validatedData['asset_name'];
        $asset->brand = $validatedData['brand'];
        $asset->model = $validatedData['model'];
        $asset->serial_number = $validatedData['serial_number'];
        $asset->cost = $validatedData['cost'];
        $asset->supplier_id = $validatedData['supplier_id'];
        $asset->site_id = $validatedData['site_id'];
        $asset->location_id = $validatedData['location_id'];
        $asset->category_id = $validatedData['category_id'];
        $asset->department_id = $validatedData['department_id'];
        $asset->condition_id = $validatedData['condition_id'];
        $asset->purchase_date = $validatedData['purchase_date'];

        if ($request->hasFile('asset_image')) {
            $imageName = time().'.'.$request->asset_image->extension();
            $request->asset_image->move(public_path('profile'), $imageName);
            $asset->asset_image = 'profile/'.$imageName;
        }

        $asset->save();

        return redirect()->route('asset.add')->with('success', 'Asset added successfully.');
    }

    public function edit($id)
    {
        $asset = Asset::findOrFail($id);
        $suppliers = DB::table('suppliers')->get();
        $sites = DB::table('sites')->get();
        $locations = DB::table('locations')->get();
        $categories = DB::table('categories')->get();
        $departments = DB::table('departments')->get();
        $conditions = DB::table('conditions')->get();

        return view('fcu-ams/asset/updateAsset', compact('asset', 'suppliers', 'sites', 'locations', 'categories', 'departments', 'conditions'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'asset_name' => [
                'required',
                'string',
                Rule::unique('assets', 'asset_name')->ignore($id)->whereNull('deleted_at'),
            ],
            'brand' => 'required|string',
            'model' => 'required|string',
            'serial_number' => 'required|string',
            'cost' => 'required|numeric',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'site_id' => 'required|integer|exists:sites,id',
            'location_id' => 'required|integer|exists:locations,id',
            'category_id' => 'required|integer|exists:categories,id',
            'department_id' => 'required|integer|exists:departments,id',
            'condition_id' => 'required|integer|exists:conditions,id',
            'purchase_date' => 'required|date',
            'asset_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $asset = Asset::findOrFail($id);
        $asset->asset_name = $validatedData['asset_name'];
        $asset->brand = $validatedData['brand'];
        $asset->model = $validatedData['model'];
        $asset->serial_number = $validatedData['serial_number'];
        $asset->cost = $validatedData['cost'];
        $asset->supplier_id = $validatedData['supplier_id'];
        $asset->site_id = $validatedData['site_id'];
        $asset->location_id = $validatedData['location_id'];
        $asset->category_id = $validatedData['category_id'];
        $asset->department_id = $validatedData['department_id'];
        $asset->condition_id = $validatedData['condition_id'];
        $asset->purchase_date = $validatedData['purchase_date'];

        if ($request->hasFile('asset_image')) {
            $imageName = time().'.'.$request->asset_image->extension();
            $request->asset_image->move(public_path('profile'), $imageName);
            $asset->asset_image = 'profile/'.$imageName;
        }

        $changes = 'Updated asset name to ' . $request->input('asset_name') . ', updated brand to ' .
        $request->input('brand') . ', etc.';

        $this->storeEditHistory($asset, auth()->user(), $changes);

        $asset->save();

        return redirect()->route('asset.list')->with('success', 'Asset updated successfully.');
    }

    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);
        $asset->delete();

        return redirect()->route('asset.list')->with('success', 'Asset deleted successfully.');
    }

    public function maintenance()
    {
        $assets = Asset::where('condition_id', 2)->get();
        return view('fcu-ams/asset/maintenance', compact('assets'));
    }

    public function storeEditHistory($asset, $user, $changes)
    {
        $editHistory = new AssetEditHistory();
        $editHistory->asset_id = $asset->id;
        $editHistory->user_id = $user->id;
        $editHistory->changes = $changes;
        $editHistory->save();
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new AssetsImport, $request->file('file'));

        return redirect()->route('asset.list')->with('success', 'Assets imported successfully.');
    }

    public function export() { 
        return Excel::download(new AssetsExport, 'assets.xlsx');
    }
}
