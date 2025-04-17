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
use Illuminate\Validation\Rule;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use App\Models\DisposedStatus;
use Illuminate\Support\Str;
use App\Models\SupplyRequest;
use App\Models\StockOut;
use App\Models\Inventory;
use App\Exports\InventoryExport;
use App\Models\Unit;
use App\Models\InventoryEditHistory;
use App\Imports\AssetsImport;
use Carbon\Carbon;
use App\Models\AssetTurnoverHistory;
use App\Models\AssetReturnHistory;

class AssetController extends Controller
{
    public function index(Request $request) {
        $categories = $request->input('categories', []);
        $departments = $request->input('departments', []);
        $locations = $request->input('locations', []);
        $sites = $request->input('sites', []);
        $suppliers = $request->input('suppliers', []);
        $brands = $request->input('brands', []);
        $conditions = $request->input('conditions', []);
        $statuses = $request->input('statuses', []);

        $category = $request->input('category');
        $department = $request->input('department');
        $location = $request->input('location');
        $site = $request->input('site');
        $supplier = $request->input('supplier');
        $brand = $request->input('brand');

        $totalAssets = DB::table('assets')
            ->leftJoin('conditions', 'assets.condition_id', '=', 'conditions.id')
            ->whereNull('assets.deleted_at')
            ->whereNotIn('conditions.condition', ['Disposed'])
            ->count();
            
        $totalCost = DB::table('assets')
            ->leftJoin('conditions', 'assets.condition_id', '=', 'conditions.id')
            ->whereNull('assets.deleted_at')
            ->whereNotIn('conditions.condition', ['Disposed'])
            ->sum('cost');
        
        $lowValueAssets = DB::table('assets')
            ->leftJoin('conditions', 'assets.condition_id', '=', 'conditions.id')
            ->where('cost', '<', 1000)
            ->whereNull('assets.deleted_at')
            ->whereNotIn('conditions.condition', ['Disposed'])
            ->count();
            
        $highValueAssets = DB::table('assets')
            ->leftJoin('conditions', 'assets.condition_id', '=', 'conditions.id')
            ->where('cost', '>=', 1000)
            ->whereNull('assets.deleted_at')
            ->whereNotIn('conditions.condition', ['Disposed'])
            ->count();

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
            )
            ->whereNotIn('conditions.condition', ['Disposed']);

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
        if (!empty($conditions)) {
            $query->whereIn('assets.condition_id', $conditions);
        }
        if (!empty($statuses)) {
            $query->whereIn('assets.status_id', $statuses);
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
                'allConditions' => DB::table('conditions')->get(),
                'allStatuses' => DB::table('statuses')->get(),
                'selectedConditions' => $conditions,
                'selectedStatuses' => $statuses,
            ]
        ));
    }

    public function search(Request $request)
    {
        $searchQuery = $request->input('search');
        $query = DB::table('assets')
            ->leftJoin('suppliers', 'assets.supplier_id', '=', 'suppliers.id')
            ->leftJoin('categories', 'assets.category_id', '=', 'categories.id')
            ->leftJoin('conditions', 'assets.condition_id', '=', 'conditions.id')
            ->leftJoin('statuses', 'assets.status_id', '=', 'statuses.id')
            ->select(
                'assets.*',
                'suppliers.supplier as supplier_name',
                'categories.category as category_name',
                'conditions.condition as condition_name',
                'statuses.status as status_name'
            )
            ->where(function($q) use ($searchQuery) {
                $q->where('assets.asset_tag_id', 'like', '%' . $searchQuery . '%')
                  ->orWhere('assets.assigned_to', 'like', '%' . $searchQuery . '%')
                  ->orWhere('suppliers.supplier', 'like', '%' . $searchQuery . '%')
                  ->orWhere('categories.category', 'like', '%' . $searchQuery . '%')    
                  ->orWhere('conditions.condition', 'like', '%' . $searchQuery . '%');
            })
            ->whereNull('assets.deleted_at');

        // Apply filters if they exist
        if ($request->has('conditions')) {
            $conditions = $request->input('conditions');
            if (is_array($conditions)) {
                $query->whereIn('assets.condition_id', $conditions);
            }
        }
        if ($request->has('categories')) {
            $categories = $request->input('categories');
            if (is_array($categories)) {
                $query->whereIn('assets.category_id', $categories);
            }
        }
        if ($request->has('statuses')) {
            $statuses = $request->input('statuses');
            if (is_array($statuses)) {
                $query->whereIn('assets.status_id', $statuses);
            }
        }
        if ($request->has('departments')) {
            $departments = $request->input('departments');
            if (is_array($departments)) {
                $query->whereIn('assets.department_id', $departments);
            }
        }
        if ($request->has('brands')) {
            $brands = $request->input('brands');
            if (is_array($brands)) {
                $query->whereIn('assets.brand_id', $brands);
            }
        }

        $assets = $query->get();

        // Log the query for debugging
        \Log::info('Search Query:', [
            'sql' => $query->toSql(),
            'bindings' => $query->getBindings(),
            'results_count' => $assets->count()
        ]);

        return response()->json([
            'assets' => $assets
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
        $asset = Asset::with(['brand', 'supplier', 'site', 'location', 'category', 'department', 'status', 'condition'])->findOrFail($id);
        $editHistory = AssetEditHistory::where('asset_id', $id)->with('user')->orderBy('created_at', 'desc')->paginate(5);
        $turnoverHistory = $this->getAssetTurnoverHistory($id);
        
        return view('fcu-ams.asset.viewAsset', compact('asset', 'editHistory', 'turnoverHistory'));
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
            'specs' => 'nullable',
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
            'issued_date' => 'nullable|date',
            'notes' => 'nullable|string|max:1000',
            'created_by' => 'nullable|integer|exists:users,id'
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
        $asset->issued_date = $validatedData['issued_date'];
        $asset->notes = $validatedData['notes'];
        $asset->created_by = auth()->user()->id;

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
        
        $disposedStatuses = DisposedStatus::all();
        
        return view('fcu-ams/asset/updateAsset', compact('asset', 'suppliers', 'sites', 'locations', 'categories',
        'departments', 'conditions', 'statuses', 'brands', 'disposedStatuses'));
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
            'specs' => 'nullable',
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
            'disposed_amount' => 'nullable|numeric|min:0',
            'disposed_status_id' => 'nullable|exists:disposed_statuses,id',
            'assigned_to' => 'nullable|string|max:255',
            'issued_date' => 'nullable|date',
            'notes' => 'nullable|string|max:1000'
        ]);

        $asset = Asset::findOrFail($id);
        $oldAsset = clone $asset;

        // Check if asset is being newly assigned (has return date but now getting new assignment)
        if ($asset->return_date && $validatedData['assigned_to']) {
            $asset->return_date = null;
            $asset->returned_at = null;
        }

        // Set issued_date when asset is newly assigned
        if ($validatedData['assigned_to'] && !$asset->assigned_to) {
            $validatedData['issued_date'] = now()->toDateString();
        }

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
        $asset->issued_date = $validatedData['issued_date'];
        $asset->notes = $validatedData['notes'];

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
        } elseif ($request->input('condition_id') == Condition::where('condition', 'Disposed')->first()->id) {
            // Set status to Unavailable when condition is Disposed
            $unavailableStatus = Status::where('status', 'Unavailable')->first();
            if ($unavailableStatus) {
                $asset->status_id = $unavailableStatus->id;
            }
            // Set disposed amount and status when condition is Disposed
            if ($request->filled('disposed_amount')) {
                $asset->disposed_amount = $request->input('disposed_amount');
            }
            if ($request->filled('disposed_status_id')) {
                $asset->disposed_status_id = $request->input('disposed_status_id');
            }
        } else {
            // Clear maintenance dates if condition is not maintenance
            $asset->maintenance_start_date = null;
            $asset->maintenance_end_date = null;
            // Clear disposed amount and status if condition is not disposed
            if ($oldAsset->condition_id == Condition::where('condition', 'Disposed')->first()->id) {
                $asset->disposed_amount = null;
                $asset->disposed_status_id = null;
            }
            // Set status back to Available if it was previously in maintenance or Disposed
            if ($oldAsset->condition_id == Condition::where('condition', 'Maintenance')->first()->id || 
                $oldAsset->condition_id == Condition::where('condition', 'Disposed')->first()->id) {
                $availableStatus = Status::where('status', 'Available')->first();
                if ($availableStatus) {
                    $asset->status_id = $availableStatus->id;
                }
            }
        }

        if ($request->hasFile('asset_image')) {
            $imageName = time().'.'.$request->asset_image->extension();
            $request->asset_image->move(public_path('profile'), $imageName);
            $asset->asset_image = 'profile/'.$imageName;
        }

        $this->storeEditHistory($asset, auth()->user(), $oldAsset);

        $asset->save();

        return redirect()->route('asset.list')->with('success', 'Asset updated successfully.');
    }

    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);

        // Explicitly set deleted_by before deleting
        $asset->deleted_by = auth()->user()->id;
        $asset->save();

        $asset->delete();

        return redirect()->back()->with('success', 'Asset deleted successfully!');
    }

    public function maintenance()
    {
        $assets = Asset::with(['brand', 'supplier', 'site', 'location', 'category', 'department', 'condition'])
            ->where('condition_id', 2)
            ->orderBy('maintenance_start_date', 'desc')
            ->paginate(15);
        $conditions = Condition::all();
        $disposedStatuses = DisposedStatus::all(); // Add this line
        return view('fcu-ams/asset/maintenance', compact('assets', 'conditions', 'disposedStatuses')); // Add to compact
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
            'issued_date' => 'Date Issued',
            'notes' => 'Notes',
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

    public function export() { 
        return Excel::download(new AssetsExport, 'assets.csv');
    }

    public function generateQrCode($id)
    {
        $asset = Asset::findOrFail($id);

        $assetData = [
            'tag_id' => $asset->asset_tag_id,
            'assigned_to' => $asset->assigned_to ?? 'Not Assigned',
            'specs' => $asset->specs,
            'brand' => $asset->brand->brand,
            'model' => $asset->model,
            'serial' => $asset->serial_number,
            'category' => $asset->category->category,
            'site' => $asset->site->site,
            'location' => $asset->location->location,
            'department' => $asset->department->department,
            'cost' => $asset->cost,
            'supplier' => $asset->supplier->supplier,
            'purchase_date' => $asset->purchase_date,
        ];

        // Create GitHub Pages URL with base64 encoded data
        $encodedData = base64_encode(json_encode($assetData));
        $githubUrl = "https://monochromat1c.github.io/forViewingAssetThroughQRCode/?data=" . $encodedData;

        $qrCode = QrCode::size(192)
            ->margin(1)
            ->backgroundColor(255, 255, 255)
            ->color(0, 0, 0)
            ->format('svg')
            ->errorCorrection('H')
            ->generate($githubUrl);
            
        return view('fcu-ams/asset/qrCode', compact('qrCode', 'id', 'asset'));
    }

    public function updateCondition(Request $request, $id)
    {
        $validatedData = $request->validate([
            'condition_id' => 'required|integer|exists:conditions,id',
            'maintenance_start_date' => 'nullable|date',
            'maintenance_end_date' => 'nullable|date|after_or_equal:maintenance_start_date',
            'disposed_amount' => 'nullable|numeric|min:0',
            'disposed_status_id' => 'nullable|exists:disposed_statuses,id'
        ]);

        $asset = Asset::findOrFail($id);
        $oldAsset = clone $asset;

        $asset->condition_id = $validatedData['condition_id'];

        $maintenanceCondition = Condition::where('condition', 'Maintenance')->first();
        $disposedCondition = Condition::where('condition', 'Disposed')->first();

        if ($validatedData['condition_id'] == $maintenanceCondition->id) {
            $asset->maintenance_start_date = $validatedData['maintenance_start_date'];
            $asset->maintenance_end_date = $validatedData['maintenance_end_date'];
            $unavailableStatus = Status::where('status', 'Unavailable')->first();
            if ($unavailableStatus) {
                $asset->status_id = $unavailableStatus->id;
            }
        } elseif ($validatedData['condition_id'] == $disposedCondition->id) {
            $unavailableStatus = Status::where('status', 'Unavailable')->first();
            if ($unavailableStatus) {
                $asset->status_id = $unavailableStatus->id;
            }
            // Add disposal fields with null coalescing
            $asset->disposed_amount = $validatedData['disposed_amount'] ?? null;
            $asset->disposed_status_id = $validatedData['disposed_status_id'] ?? null;
        } else {
            $asset->maintenance_start_date = null;
            $asset->maintenance_end_date = null;
            if ($oldAsset->condition_id == $maintenanceCondition->id || 
                $oldAsset->condition_id == $disposedCondition->id) {
                $availableStatus = Status::where('status', 'Available')->first();
                if ($availableStatus) {
                    $asset->status_id = $availableStatus->id;
                }
            }
        }

        $this->storeEditHistory($asset, auth()->user(), $oldAsset);
        $asset->save();

        return redirect()->back()->with('success', 'Asset condition updated successfully.');
    }

    public function updateConditionToUsed()
    {
        $this->condition_id = Condition::where('condition', 'Used')->first()->id;
        $this->save();
    }

    public function return($id, Request $request)
    {
        $asset = Asset::findOrFail($id);
        $oldAsset = clone $asset;

        // Validate input
        $validated = $request->validate([
            'return_date'   => 'required|date_format:Y-m-d\TH:i',
            'returned_by'   => 'required|string|max:255',
            'condition_id'  => 'required|exists:conditions,id',
            'received_by'   => 'required|string|max:255',
            'return_notes'  => 'nullable|string',
        ]);

        // Store return history
        AssetReturnHistory::create([
            'asset_id'     => $asset->id,
            'returned_by'  => $validated['returned_by'],
            'received_by'  => $validated['received_by'], // string
            'condition_id' => $validated['condition_id'],
            'return_date'  => Carbon::createFromFormat('Y-m-d\TH:i', $validated['return_date']),
            'remarks'      => $validated['return_notes'],
        ]);

        // Update asset
        $asset->assigned_to = null;
        $asset->issued_date = null;
        $asset->return_date = Carbon::createFromFormat('Y-m-d\TH:i', $validated['return_date'])->toDateString();
        $asset->returned_at = Carbon::createFromFormat('Y-m-d\TH:i', $validated['return_date']);
        $asset->condition_id = $validated['condition_id'];

        // Status to Available
        $availableStatus = Status::where('status', 'Available')->first();
        if ($availableStatus) {
            $asset->status_id = $availableStatus->id;
        }

        $this->storeEditHistory($asset, auth()->user(), $oldAsset);
        $asset->save();

        return redirect()->route('asset.list')->with('success', 'Asset has been returned successfully.');
    }

    public function returnFromAssigned($id, Request $request)
    {
        $asset = Asset::findOrFail($id);
        $oldAsset = clone $asset;

        $validated = $request->validate([
            'return_date'   => 'required|date_format:Y-m-d\TH:i',
            'returned_by'   => 'required|string|max:255',
            'condition_id'  => 'required|exists:conditions,id',
            'received_by'   => 'required|string|max:255',
            'return_notes'  => 'nullable|string',
        ]);

        AssetReturnHistory::create([
            'asset_id'     => $asset->id,
            'returned_by'  => $validated['returned_by'],
            'received_by'  => $validated['received_by'],
            'condition_id' => $validated['condition_id'],
            'return_date'  => Carbon::createFromFormat('Y-m-d\TH:i', $validated['return_date']),
            'remarks'      => $validated['return_notes'],
        ]);

        $asset->assigned_to = null;
        $asset->issued_date = null;
        $asset->return_date = Carbon::createFromFormat('Y-m-d\TH:i', $validated['return_date'])->toDateString();
        $asset->returned_at = Carbon::createFromFormat('Y-m-d\TH:i', $validated['return_date']);
        $asset->condition_id = $validated['condition_id'];

        $availableStatus = Status::where('status', 'Available')->first();
        if ($availableStatus) {
            $asset->status_id = $availableStatus->id;
        }

        $this->storeEditHistory($asset, auth()->user(), $oldAsset);
        $asset->save();

        // Redirect back to the specific assignee's detail page
        if ($validated['returned_by']) {
            return redirect()->route('asset.assigned.show', ['assigneeName' => urlencode($validated['returned_by'])])
                             ->with('success', 'Asset has been returned successfully.');
        } else {
             // Fallback if assignee name was somehow lost (shouldn't happen)
            return redirect()->route('asset.assigned')->with('success', 'Asset has been returned successfully.');
        }
    }

    public function disposed(Request $request)
    {
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
            ->leftJoin('disposed_statuses', 'assets.disposed_status_id', '=', 'disposed_statuses.id')
            ->select('assets.*', 
                'suppliers.supplier as supplier_name', 
                'sites.site as site_name', 
                'statuses.status as status_name',
                'conditions.condition as condition_name',
                'locations.location as location_name', 
                'categories.category as category_name', 
                'departments.department as department_name',
                'brands.brand as brand_name',
                'disposed_statuses.status as disposed_status_name'
            )
            ->whereIn('conditions.condition', ['Disposed'])
            ->whereNull('assets.deleted_at');

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

        $query->orderBy($sort, $direction);

        $disposedAssets = $query->paginate(15)
            ->appends($request->all());

        return view('fcu-ams/asset/disposedAssets', compact(
            'disposedAssets',
            'sort',
            'direction',
            'search'
        ));
    }

    /**
     * Display a listing of unique assignees with their assigned asset count, total cost, and last issued date.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function assignedAssets(Request $request)
    {
        $search = $request->input('search');
        // Add filter parameters
        $categories = $request->input('categories', []);
        $departments = $request->input('departments', []);
        $conditions = $request->input('conditions', []);
        $sites = $request->input('sites', []);
        $locations = $request->input('locations', []);
        $sort = $request->input('sort', 'assigned_to');
        $direction = $request->input('direction', 'asc');

        $query = Asset::query()
            ->whereNotNull('assigned_to')
            ->where('assigned_to', '!=', '')
            ->whereHas('condition', function ($q) {
                $q->where('condition', '!=', 'Disposed');
            })
            ->selectRaw('assigned_to, COUNT(*) as asset_count, SUM(cost) as total_cost, MAX(issued_date) as last_issued_date')
            ->groupBy('assigned_to');

        if ($search) {
            $query->where('assigned_to', 'like', '%' . $search . '%');
        }
        if (!empty($categories)) {
            $query->whereHas('category', function ($q) use ($categories) {
                $q->whereIn('id', $categories);
            });
        }
        if (!empty($departments)) {
            $query->whereHas('department', function ($q) use ($departments) {
                $q->whereIn('id', $departments);
            });
        }
        if (!empty($conditions)) {
            $query->whereHas('condition', function ($q) use ($conditions) {
                $q->whereIn('id', $conditions);
            });
        }
        if (!empty($sites)) {
            $query->whereHas('site', function ($q) use ($sites) {
                $q->whereIn('id', $sites);
            });
        }
        if (!empty($locations)) {
            $query->whereHas('location', function ($q) use ($locations) {
                $q->whereIn('id', $locations);
            });
        }

        // Sorting
        $sortable = ['assigned_to', 'asset_count', 'total_cost', 'last_issued_date'];
        if (in_array($sort, $sortable)) {
            $query->orderBy($sort, $direction);
        } else {
            $query->orderBy('assigned_to', 'asc');
        }

        $assignees = $query->paginate(20)->appends($request->all());

        // For filter modal options
        $allCategories = \App\Models\Category::orderBy('category')->get();
        $allDepartments = \App\Models\Department::orderBy('department')->get();
        $allConditions = \App\Models\Condition::orderBy('condition')->get();
        $allSites = \App\Models\Site::orderBy('site')->get();
        $allLocations = \App\Models\Location::orderBy('location')->get();

        return view('fcu-ams.asset.assignedAssets', compact(
            'assignees', 'search', 'allCategories', 'allDepartments', 'allConditions', 'allSites', 'allLocations'
        ));
    }

    /**
     * Display a listing of assets assigned to a specific person.
     *
     * @param  string  $assigneeName The URL-encoded name of the assignee.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function showAssetsByAssignee(Request $request, $assigneeName)
    {
        $decodedAssigneeName = urldecode($assigneeName); // Decode the name from the URL
        $search = $request->input('search');
        $sort = $request->input('sort', 'asset_tag_id'); // Default sort by asset tag
        $direction = $request->input('direction', 'asc');

        $query = Asset::with(['brand', 'category', 'status', 'condition', 'department'])
            ->where('assigned_to', $decodedAssigneeName)
            ->whereHas('condition', function ($q) {
                $q->where('condition', '!=', 'Disposed');
            });

        // Add filter constraints
        if ($request->filled('brands')) {
            $query->whereIn('brand_id', $request->input('brands'));
        }

        if ($request->filled('categories')) {
            $query->whereIn('category_id', $request->input('categories'));
        }

        if ($request->filled('departments')) {
            $query->whereIn('department_id', $request->input('departments'));
        }

        if ($request->filled('statuses')) {
            $query->whereIn('status_id', $request->input('statuses'));
        }

        // Apply search within this assignee's assets
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('asset_tag_id', 'like', '%' . $search . '%')
                  ->orWhere('model', 'like', '%' . $search . '%')
                  ->orWhere('serial_number', 'like', '%' . $search . '%')
                  ->orWhereHas('brand', function ($subQ) use ($search) {
                      $subQ->where('brand', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('category', function ($subQ) use ($search) {
                      $subQ->where('category', 'like', '%' . $search . '%');
                  });
            });
        }

        // Apply sorting
        $query->orderBy($sort, $direction);
       
        $assets = $query->paginate(15)->appends($request->except('page')); // Paginate the results for this assignee

        // Add these lines to get filter data
        $allBrands = Brand::orderBy('brand')->get();
        $allCategories = Category::orderBy('category')->get();
        $allDepartments = Department::orderBy('department')->get();
        $allStatuses = Status::orderBy('status')->get();
        $allConditions = Condition::orderBy('condition')->get();

        // Add to return statement
        return view('fcu-ams.asset.showAssetsByAssignee', array_merge(
            compact(
                'assets',
                'decodedAssigneeName', // Pass the assignee name to the view
                'search',
                'sort',
                'direction'
            ),
            [
                'allBrands' => $allBrands,
                'allCategories' => $allCategories,
                'allDepartments' => $allDepartments,
                'allStatuses' => $allStatuses,
                'allConditions' => $allConditions,
                'hasActiveFilters' => count(array_filter($request->except(['page', 'search', 'sort', 'direction']))) > 0,
                'activeFilterCount' => count(array_filter($request->except(['page', 'search', 'sort', 'direction'])))
            ]
        ));
    }

    /**
     * Return all assets assigned to a specific person.
     *
     * @param  string  $assigneeName The URL-encoded name of the assignee.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function returnAllAssetsForAssignee($assigneeName, Request $request)
    {
        $decodedAssigneeName = urldecode($assigneeName); // CAUSE RESOLUTION
        $assets = Asset::where('assigned_to', $decodedAssigneeName)->get();

        foreach ($assets as $asset) {
            // 1. Create return history
            AssetReturnHistory::create([
                'asset_id'     => $asset->id,
                'returned_by'  => $request->input('returned_by'),
                'received_by'  => $request->input('received_by'),
                'condition_id' => $request->input('condition_id'),
                'return_date'  => \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->input('return_date')),
                'remarks'      => $request->input('return_notes'),
            ]);

            // 2. Update asset fields
            $asset->condition_id = $request->input('condition_id');
            $asset->assigned_to = null;
            $asset->issued_date = null;
            $asset->return_date = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->input('return_date'))->toDateString();
            $asset->returned_at = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->input('return_date'));
            $asset->save();
        }

        return redirect()->back()->with('success', 'All assets returned and recorded in history.');
    }

    /**
     * Turn over all assets from one assignee to another
     * 
     * @param Request $request
     * @param string $assigneeName
     * @return \Illuminate\Http\RedirectResponse
     */
    public function turnoverAssetsForAssignee(Request $request, $assigneeName)
    {
        try {
            // Validate request data first
            $validated = $request->validate([
                'new_assignee' => 'required|string|max:255',
                'department_id' => 'required|exists:departments,id',
                'turnover_date' => 'required|date',
                'notes' => 'nullable|string'
            ]);

            DB::beginTransaction();
            
            $decodedAssigneeName = urldecode($assigneeName);
            $assets = Asset::where('assigned_to', $decodedAssigneeName)->get();
            
            if ($assets->isEmpty()) {
                throw new \Exception('No assets found for turnover');
            }

            $turnoverCount = 0;
            $turnoverDateTime = Carbon::now();

            foreach ($assets as $asset) {
                AssetTurnoverHistory::create([
                    'asset_id' => $asset->id,
                    'previous_assignee' => $decodedAssigneeName,
                    'new_assignee' => $validated['new_assignee'],
                    'turnover_date' => $turnoverDateTime,
                    'assignment_start_date' => $asset->issued_date,
                    'notes' => $validated['notes'],
                    'user_id' => auth()->user()->id
                ]);

                $asset->update([
                    'assigned_to' => $validated['new_assignee'],
                    'department_id' => $validated['department_id'],
                    'issued_date' => $validated['turnover_date'],
                    'notes' => $validated['notes'] ?? null
                ]);
                
                $turnoverCount++;
            }
            
            DB::commit();
            
            $message = "{$turnoverCount} asset(s) successfully turned over from {$decodedAssigneeName} to {$validated['new_assignee']}.";
            
            return redirect()->route('asset.assigned')->with('success', $message);
            
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error("Turnover error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to process turnover: ' . $e->getMessage());
        }
    }

    /**
     * Turn over a single asset to a new assignee
     * 
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function turnoverSingleAsset(Request $request, $id)
    {
        try {
            // Validate request data
            $validated = $request->validate([
                'new_assignee' => 'required|string|max:255',
                'department_id' => 'required|exists:departments,id',
                'turnover_date' => 'required|date',
                'notes' => 'nullable|string'
            ]);

            DB::beginTransaction();
            
            $asset = Asset::findOrFail($id);
            $previousAssignee = $asset->assigned_to;
            
            if (!$previousAssignee) {
                throw new \Exception('Asset is not currently assigned to anyone');
            }

            // Create turnover history record
            AssetTurnoverHistory::create([
                'asset_id' => $asset->id,
                'previous_assignee' => $previousAssignee,
                'new_assignee' => $validated['new_assignee'],
                'turnover_date' => Carbon::now(),
                'assignment_start_date' => $asset->issued_date,
                'notes' => $validated['notes'],
                'user_id' => auth()->user()->id
            ]);

            // Update asset assignment
            $asset->update([
                'assigned_to' => $validated['new_assignee'],
                'department_id' => $validated['department_id'],
                'issued_date' => $validated['turnover_date'],
                'notes' => $validated['notes'] ?? null
            ]);
            
            DB::commit();
            
            return redirect()->back()->with('success', 
                "Asset {$asset->asset_tag_id} successfully turned over from {$previousAssignee} to {$validated['new_assignee']}.");
            
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error("Single asset turnover error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to process turnover: ' . $e->getMessage());
        }
    }

    // Add this method to get turnover history for the view
    private function getAssetTurnoverHistory($assetId)
    {
        return AssetTurnoverHistory::where('asset_id', $assetId)
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->paginate(5);
    }
}
