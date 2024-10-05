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
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        $asset = Asset::with(['supplier', 'site', 'location', 'category', 'department', 'editHistory' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }, 'condition'])->findOrFail($id);
        
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
            'specs' => 'nullable|string',
            'serial_number' => 'required|string',
            'cost' => 'required|numeric',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'site_id' => 'required|integer|exists:sites,id',
            'location_id' => 'required|integer|exists:locations,id',
            'category_id' => 'required|integer|exists:categories,id',
            'department_id' => 'required|integer|exists:departments,id',
            'purchase_date' => 'required|date',
            'asset_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $asset = new Asset();
        $asset->asset_name = $validatedData['asset_name'];
        $asset->brand = $validatedData['brand'];
        $asset->model = $validatedData['model'];
        $asset->specs = $validatedData['specs'] ?? '';
        $asset->serial_number = $validatedData['serial_number'];
        $asset->cost = $validatedData['cost'];
        $asset->supplier_id = $validatedData['supplier_id'];
        $asset->site_id = $validatedData['site_id'];
        $asset->location_id = $validatedData['location_id'];
        $asset->category_id = $validatedData['category_id'];
        $asset->department_id = $validatedData['department_id'];
        $asset->condition_id = Condition::where('condition', 'New')->first()->id;
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
            'specs' => 'nullable|string',
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
        $asset->specs = $validatedData['specs'] ?? '';
        $asset->serial_number = $validatedData['serial_number'];
        $asset->cost = $validatedData['cost'];
        $asset->supplier_id = $validatedData['supplier_id'];
        $asset->site_id = $validatedData['site_id'];
        $asset->location_id = $validatedData['location_id'];
        $asset->category_id = $validatedData['category_id'];
        $asset->department_id = $validatedData['department_id'];
        $asset->condition_id = $validatedData['condition_id'];
        $asset->purchase_date = $validatedData['purchase_date'];

        $condition = Condition::find($validatedData['condition_id']);
        if ($condition && $condition->condition === 'Maintenance') {
            $asset->maintenance_start_date = now();
            $asset->maintenance_end_date = $request->input('maintenance_end_date') ?? null;
        } else {
            $asset->maintenance_start_date = null;
            $asset->maintenance_end_date = null;
        }

        if ($request->hasFile('asset_image')) {
            $imageName = time().'.'.$request->asset_image->extension();
            $request->asset_image->move(public_path('profile'), $imageName);
            $asset->asset_image = 'profile/'.$imageName;
        }

        $oldAsset = Asset::findOrFail($id);
        $this->storeEditHistory($asset, auth()->user(), $oldAsset);

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

    public function finishMaintenance(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);

        $repairedCondition = Condition::where('condition', 'Repaired')->first();

        if ($repairedCondition) {
            $oldAsset = $asset->replicate();
            $asset->condition_id = $repairedCondition->id;
            $asset->maintenance_end_date = now();
            $asset->save();

            $this->storeEditHistory($asset, auth()->user(), $oldAsset);
        }

        return redirect()->route('maintenance')->with('success', 'Maintenance completed successfully.');
    }

    public function storeEditHistory($asset, $user, $oldAsset)
    {
        $changes = [];
        $fields = [
            'asset_name' => 'Asset Name',
            'brand' => 'Brand',
            'model' => 'Model',
            'specs' => 'Specification',
            'serial_number' => 'Serial Number',
            'cost' => 'Cost',
            'supplier_id' => 'Supplier',
            'site_id' => 'Site',
            'location_id' => 'Location',
            'category_id' => 'Category',
            'department_id' => 'Department',
            'purchase_date' => 'Purchase Date',
            'condition_id' => 'Condition',
        ];

        foreach ($fields as $field => $header) {
            if ($asset->$field != $oldAsset->$field) {
                $oldValue = $oldAsset->$field;
                $newValue = $asset->$field;

                if (in_array($field, ['supplier_id', 'site_id', 'location_id', 'category_id', 'department_id', 'condition_id'])) {
                    $relationship = str_replace('_id', '', $field);
                    $oldValue = $oldAsset->$relationship->name ?? $oldAsset->$relationship->supplier ?? $oldAsset->$relationship->site ?? $oldAsset->$relationship->location ?? $oldAsset->$relationship->category ?? $oldAsset->$relationship->department ?? $oldAsset->$relationship->condition;
                    $newValue = $asset->$relationship->name ?? $asset->$relationship->supplier ?? $asset->$relationship->site ?? $asset->$relationship->location ?? $asset->$relationship->category ?? $asset->$relationship->department ?? $asset->$relationship->condition;
                }

                $changes[] = "Updated $header from '$oldValue' to '$newValue'.";
            }
        }

        if (count($changes) > 0) {
            $editHistory = new AssetEditHistory();
            $editHistory->asset_id = $asset->id;
            $editHistory->user_id = $user->id;
            $editHistory->changes = nl2br(implode("<br>", $changes));
            $editHistory->save();
        }
    }

    public function import(Request $request)
    {
        $file = $request->file('file');

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new AssetsImport, $file);

        return redirect()->route('asset.list')->with('success', 'Assets imported successfully.');
    }

    public function export() { 
        return Excel::download(new AssetsExport, 'assets.xlsx');
    }

    public function generateQrCode($id)
    {
        $asset = Asset::findOrFail($id);
        $assetDetails = [
            'Asset Name: ' . $asset->asset_name,
            'Brand: ' . $asset->brand,
            'Model: ' . $asset->model,
            'Serial Number: ' . $asset->serial_number,
            'Cost: ' . $asset->cost,
            'Supplier: ' . $asset->supplier->supplier,
            'Site: ' . $asset->site->site,
            'Location: ' . $asset->location->location,
            'Category: ' . $asset->category->category,
            'Department: ' . $asset->department->department,
            'Purchase Date: ' . $asset->purchase_date,
            'Condition: ' . $asset->condition->condition,
        ];

        $qrCode = QrCode::generate(implode("\n", $assetDetails));
        return view('fcu-ams/asset/qrCode', compact('qrCode', 'id'));
    }
}
