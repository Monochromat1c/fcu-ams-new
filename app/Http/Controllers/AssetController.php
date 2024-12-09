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
use App\Models\Status;
use App\Models\Brand;
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
        $categories = $request->input('categories', []);
        $departments = $request->input('departments', []);
        $locations = $request->input('locations', []);
        $sites = $request->input('sites', []);
        $suppliers = $request->input('suppliers', []);
        $brands = $request->input('brands', []);

        $category = $request->input('category');
        $department = $request->input('department');
        $location = $request->input('location');
        $site = $request->input('site');
        $supplier = $request->input('supplier');
        $brand = $request->input('brand');

        $totalAssets = DB::table('assets')->whereNull('deleted_at')->count();
        $totalCost = DB::table('assets')->whereNull('deleted_at')->sum('cost');
        
        $lowValueAssets = DB::table('assets')->where('cost', '<', 1000)->whereNull('deleted_at')->count();
        $highValueAssets = DB::table('assets')->where('cost', '>=', 1000)->whereNull('deleted_at')->count();

        $sort = $request->input('sort', 'asset_tag_id');
        $direction = $request->input('direction', 'asc');
        $search = $request->input('search');

        $query = DB::table('assets')
            ->leftJoin('suppliers', 'assets.supplier_id', '=', 'suppliers.id')
            ->leftJoin('sites', 'assets.site_id', '=', 'sites.id')
            ->leftJoin('locations', 'assets.location_id', '=', 'locations.id')
            ->leftJoin('categories', 'assets.category_id', '=', 'categories.id')
            ->leftJoin('departments', 'assets.department_id', '=', 'departments.id')
            ->leftJoin('conditions', 'assets.condition_id', '=', 'conditions.id')
            ->leftJoin('statuses', 'assets.status_id', '=', 'statuses.id')
            ->leftJoin('brands', 'assets.brand_id', '=', 'brands.id')
            ->select('assets.*', 
                'suppliers.supplier as supplier_name', 
                'sites.site as site_name', 
                'statuses.status as status_name',
                'conditions.condition as condition_name',
                'locations.location as location_name', 
                'categories.category as category_name', 
                'departments.department as department_name',
                'brands.brand as brand_name'
            );

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('assets.asset_tag_id', 'like', '%' . $search . '%')
                    ->orWhere('suppliers.supplier', 'like', '%' . $search . '%')
                    ->orWhere('sites.site', 'like', '%' . $search . '%')
                    ->orWhere('locations.location', 'like', '%' . $search . '%')
                    ->orWhere('categories.category', 'like', '%' . $search . '%')
                    ->orWhere('departments.department', 'like', '%' . $search . '%')
                    ->orWhere('brands.brand', 'like', '%' . $search . '%');
            });
        }

        if (!empty($categories)) {
            $query->whereIn('assets.category_id', $categories);
        }
        if (!empty($departments)) {
            $query->whereIn('assets.department_id', $departments);
        }
        if (!empty($locations)) {
            $query->whereIn('assets.location_id', $locations);
        }
        if (!empty($sites)) {
            $query->whereIn('assets.site_id', $sites);
        }
        if (!empty($suppliers)) {
            $query->whereIn('assets.supplier_id', $suppliers);
        }
        if (!empty($brands)) {
            $query->whereIn('assets.brand_id', $brands);
        }

        if ($request->input('clear') == 'true') {
            return redirect()->route('asset.list');
        }

        $query->orderBy($sort, $direction);

        $assets = $query->whereNull('assets.deleted_at')
            ->paginate(15)
            ->appends($request->all());

        $allCategories = DB::table('categories')->get();
        $allDepartments = DB::table('departments')->get();
        $allLocations = DB::table('locations')->get();
        $allSites = DB::table('sites')->get();
        $allSuppliers = DB::table('suppliers')->get();
        $allBrands = DB::table('brands')->get();
        
        return view('fcu-ams/asset/assetList', array_merge(
            compact(
                'totalAssets',
                'totalCost',
                'lowValueAssets',
                'highValueAssets',
                'assets',
                'sort',
                'direction',
                'search'
            ),
            [
                'allCategories' => $allCategories,
                'allDepartments' => $allDepartments,
                'allLocations' => $allLocations,
                'allSites' => $allSites,
                'allSuppliers' => $allSuppliers,
                'allBrands' => $allBrands,
                'selectedCategories' => $categories,
                'selectedDepartments' => $departments,
                'selectedLocations' => $locations,
                'selectedSites' => $sites,
                'selectedSuppliers' => $suppliers,
                'selectedBrands' => $brands,
            ]
        ));
    }

    public function search(Request $request)
    {
        $searchQuery = $request->input('search');
        $assets = Asset::where('asset_tag_id', 'like', '%' . $searchQuery . '%')->get();
        return response()->json([
            'assets' => $assets->map(function ($asset) {
                return [
                    'asset_tag_id' => $asset->asset_tag_id,
                    'cost' => $asset->cost,
                    'supplier_name' => $asset->supplier->supplier,
                    'site_name' => $asset->site->site,
                    'category_name' => $asset->category->category,
                    'status_name' => $asset->status->status,
                    'condition_name' => $asset->condition->condition,
                ];
            }),
        ]);
    }

    public function create() {
        $suppliers = DB::table('suppliers')->get();
        $sites = DB::table('sites')->get();
        $locations = DB::table('locations')->get();
        $categories = DB::table('categories')->get();
        $departments = DB::table('departments')->get();
        $conditions = DB::table('conditions')->get();
        $statuses = DB::table('statuses')->get();
        $brands = DB::table('brands')->get();
        return view('fcu-ams/asset/addAsset', compact('suppliers', 'sites', 'locations', 'categories',
        'departments', 'conditions', 'statuses', 'brands'));
    }

    public function show($id)
    {
        $asset = Asset::with(['supplier', 'site', 'location', 'category', 'department', 'condition'])->findOrFail($id);
        
        // Get paginated edit history
        $editHistory = $asset->editHistory()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $suppliers = DB::table('suppliers')->get();
        $sites = DB::table('sites')->get();
        $locations = DB::table('locations')->get();
        $categories = DB::table('categories')->get();
        $departments = DB::table('departments')->get();
        $conditions = DB::table('conditions')->get();
        $brands = DB::table('brands')->get();
        $statuses = DB::table('statuses')->get();
        
        return view('fcu-ams/asset/viewAsset', compact('asset', 'editHistory', 'suppliers', 'sites', 'locations', 'categories',
        'departments', 'conditions', 'statuses', 'brands'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'asset_tag_id' => [
                'required',
                'string',
                Rule::unique('assets', 'asset_tag_id')->whereNull('deleted_at'),
            ],
            'brand_id' => 'required|integer|exists:brands,id',
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
            'assigned_to' => 'nullable|string|max:255',
        ]);

        $asset = new Asset();
        $asset->asset_tag_id = $validatedData['asset_tag_id'];
        $asset->model = $validatedData['model'];
        $asset->specs = $validatedData['specs'] ?? '';
        $asset->serial_number = $validatedData['serial_number'];
        $asset->cost = $validatedData['cost'];
        $asset->supplier_id = $validatedData['supplier_id'];
        $asset->brand_id = $validatedData['brand_id'];
        $asset->site_id = $validatedData['site_id'];
        $asset->location_id = $validatedData['location_id'];
        $asset->category_id = $validatedData['category_id'];
        $asset->department_id = $validatedData['department_id'];
        $asset->condition_id = Condition::where('condition', 'New')->first()->id;
        $asset->status_id = Status::where('status', 'Available')->first()->id;
        $asset->purchase_date = $validatedData['purchase_date'];
        $asset->assigned_to = $validatedData['assigned_to'];

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
        $brands = DB::table('brands')->get();
        $statuses = DB::table('statuses')->get();

        return view('fcu-ams/asset/updateAsset', compact('asset', 'suppliers', 'sites', 'locations', 'categories',
        'departments', 'conditions', 'statuses', 'brands'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'asset_tag_id' => [
                'required',
                'string',
                Rule::unique('assets', 'asset_tag_id')->whereNull('deleted_at')->ignore($id),
            ],
            'brand_id' => 'required|integer|exists:brands,id',
            'model' => 'required|string',
            'specs' => 'nullable|string',
            'serial_number' => 'required|string',
            'cost' => 'required|numeric',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'site_id' => 'required|integer|exists:sites,id',
            'location_id' => 'required|integer|exists:locations,id',
            'category_id' => 'required|integer|exists:categories,id',
            'department_id' => 'required|integer|exists:departments,id',
            'status_id' => 'required|integer|exists:statuses,id',
            'condition_id' => 'required|integer|exists:conditions,id',
            'purchase_date' => 'required|date',
            'asset_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'assigned_to' => 'nullable|string|max:255',
        ]);

        $asset = Asset::findOrFail($id);
        $oldAsset = clone $asset;

        $asset->asset_tag_id = $validatedData['asset_tag_id'];
        $asset->model = $validatedData['model'];
        $asset->specs = $validatedData['specs'] ?? '';
        $asset->serial_number = $validatedData['serial_number'];
        $asset->cost = $validatedData['cost'];
        $asset->supplier_id = $validatedData['supplier_id'];
        $asset->brand_id = $validatedData['brand_id'];
        $asset->site_id = $validatedData['site_id'];
        $asset->location_id = $validatedData['location_id'];
        $asset->category_id = $validatedData['category_id'];
        $asset->department_id = $validatedData['department_id'];
        $asset->status_id = $validatedData['status_id'];
        $asset->condition_id = $validatedData['condition_id'];
        $asset->purchase_date = $validatedData['purchase_date'];
        $asset->assigned_to = $validatedData['assigned_to'];

        if ($request->input('condition_id') == Condition::where('condition', 'Maintenance')->first()->id) {
            if ($request->input('maintenance_start_date') !== '') {
                $asset->maintenance_start_date = $request->input('maintenance_start_date');
            }
            if ($request->input('maintenance_end_date') !== '') {
                $asset->maintenance_end_date = $request->input('maintenance_end_date');
            }
            // Set status to Unavailable when condition is maintenance
            $unavailableStatus = Status::where('status', 'Unavailable')->first();
            if ($unavailableStatus) {
                $asset->status_id = $unavailableStatus->id;
            }
        }

        if ($request->hasFile('asset_image')) {
            $imageName = time().'.'.$request->asset_image->extension();
            $request->asset_image->move(public_path('profile'), $imageName);
            $asset->asset_image = 'profile/'.$imageName;
        }

        $this->storeEditHistory($asset, auth()->user(), $oldAsset);

        $asset->save();

        return redirect()->back()->with('success', 'Asset updated successfully.');
    }

    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);

        $asset = Asset::find($id);
        if ($asset) {
            try {
                $asset->delete();
                return redirect()->back()->with('success', 'Asset deleted successfully!');
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->withErrors(['error' => 'Cannot delete asset because it is
                associated with other data.']);
            }
        } else {
            return redirect()->back()->withErrors(['error' => 'Asset not found']);
        }
    }

    public function maintenance()
    {
        $assets = Asset::with(['brand', 'supplier', 'site', 'location', 'category', 'department', 'condition'])
            ->where('condition_id', 2)
            ->orderBy('maintenance_start_date', 'desc')
            ->paginate(15);
        return view('fcu-ams/asset/maintenance', compact('assets'));
    }

    public function storeEditHistory($asset, $user, $oldAsset)
    {
        $changes = [];
        $fields = [
            'asset_tag_id' => 'Asset Tag ID',
            'brand_id' => 'Brand',
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
            'status_id' => 'Status',
            'assigned_to' => 'Assigned To',
        ];

        foreach ($fields as $field => $header) {
            if ($asset->$field != $oldAsset->$field) {
                $oldValue = $oldAsset->$field;
                $newValue = $asset->$field;

                if (in_array($field, ['supplier_id', 'site_id', 'location_id', 'category_id', 'department_id',
                'condition_id', 'status_id', 'brand_id'])) {
                    $relationship = str_replace('_id', '', $field);
                    $oldValue = $oldAsset->$relationship->name ?? $oldAsset->$relationship->supplier ??
                        $oldAsset->$relationship->site ?? $oldAsset->$relationship->location ??
                        $oldAsset->$relationship->category ?? $oldAsset->$relationship->department ??
                        $oldAsset->$relationship->condition ?? $oldAsset->$relationship->status ??
                        $oldAsset->$relationship->brand;
                    $newValue = $asset->$relationship->name ?? $asset->$relationship->supplier ??
                        $asset->$relationship->site ?? $asset->$relationship->location ?? $asset->$relationship->category ??
                        $asset->$relationship->department ?? $asset->$relationship->condition ??
                        $asset->$relationship->status ??
                        $asset->$relationship->brand;
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
        return Excel::download(new AssetsExport, 'assets.csv');
    }

    public function generateQrCode($id)
    {
        $asset = Asset::findOrFail($id);
        $assetDetails = [
            'Asset Tag ID: ' . $asset->asset_tag_id,
            'Specification: ' . $asset->specs,
            'Brand: ' . $asset->brand,
            'Model: ' . $asset->model,
            'Serial Number: ' . $asset->serial_number,
            'Category: ' . $asset->category->category,
            'Site: ' . $asset->site->site,
            'Location: ' . $asset->location->location,
            'Department: ' . $asset->department->department,
            'Cost: ' . $asset->cost,
            'Supplier: ' . $asset->supplier->supplier,
            'Purchase Date: ' . $asset->purchase_date,
            'Status: ' . $asset->status->status,
            'Condition: ' . $asset->condition->condition,
        ];

        $qrCode = QrCode::generate(implode("\n", $assetDetails));
        return view('fcu-ams/asset/qrCode', compact('qrCode', 'id', 'asset'));
    }
}
