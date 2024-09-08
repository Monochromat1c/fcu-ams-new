<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Asset;
use App\Models\Supplier;
use App\Models\Site;
use App\Models\Location;
use App\Models\Category;
use App\Models\Department;
use App\Models\AssetEditHistory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AssetsExport;
use App\Imports\AssetsImport;

class AssetController extends Controller
{
    public function index(Request $request) {
        $totalAssets = DB::table('assets')->count();
        $totalCost = DB::table('assets')->sum('cost');
        $lowValueAssets = DB::table('assets')->where('cost', '<', 1000)->whereNull('deleted_at')->count();
        $highValueAssets = DB::table('assets')->where('cost', '>=', 1000)->whereNull('deleted_at')->count();

        $sort = $request->input('sort', 'asset_name');
        $direction = $request->input('direction', 'asc');
        $search = $request->input('search');

        $query = DB::table('assets')
            ->select('assets.*');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('assets.asset_name', 'like', '%' . $search . '%')
                    ->orWhere('assets.supplier', 'like', '%' . $search . '%')
                    ->orWhere('assets.site', 'like', '%' . $search . '%')
                    ->orWhere('assets.location', 'like', '%' . $search . '%')
                    ->orWhere('assets.category', 'like', '%' . $search . '%')
                    ->orWhere('assets.department', 'like', '%' . $search . '%');
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

        $assets = $query->whereNull('deleted_at')->paginate(15);

        return view('fcu-ams/asset/assetList', compact('totalAssets', 'totalCost', 'lowValueAssets', 'highValueAssets', 'assets', 'sort', 'direction', 'search'));
    }

    public function create() {
        $suppliers = DB::table('suppliers')->get();
        $sites = DB::table('sites')->get();
        $locations = DB::table('locations')->get();
        $categories = DB::table('categories')->get();
        $departments = DB::table('departments')->get();
        return view('fcu-ams/asset/addAsset', compact('suppliers', 'sites', 'locations', 'categories', 'departments'));
    }

    public function show($id)
    {
        $asset = Asset::findOrFail($id);
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
            'purchase_date' => 'required|date',
            'condition' => 'nullable|string',
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
        $asset->purchase_date = $validatedData['purchase_date'];
        $asset->condition = $validatedData['condition'];

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

        return view('fcu-ams/asset/updateAsset', compact('asset', 'suppliers', 'sites', 'locations', 'categories', 'departments'));
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
            'purchase_date' => 'required|date',
            'condition' => 'nullable|string',
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
        $asset->purchase_date = $validatedData['purchase_date'];
        $asset->condition = $validatedData['condition'];

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
        $assets = Asset::where('condition', 'Maintenance')->orWhere('condition', 'maintenance')->get();
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

    public function export()
    {
        // return Excel::download(new AssetsExport, 'assets.xlsx');
        return Excel::download(new AssetsExport, 'assets.xlsx');
    }

    public function import(Request $request)
    {
        Excel::import(new AssetsImport, 'assets.xlsx');

        return redirect()->route('asset.list')->with('success', 'Assets imported successfully.');
    }
}
