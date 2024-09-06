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
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ReaderXlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;

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
            ->leftJoin('suppliers', 'assets.supplier_id', '=', 'suppliers.id')
            ->leftJoin('sites', 'assets.site_id', '=', 'sites.id')
            ->leftJoin('locations', 'assets.location_id', '=', 'locations.id')
            ->leftJoin('categories', 'assets.category_id', '=', 'categories.id')
            ->leftJoin('departments', 'assets.department_id', '=', 'departments.id')
            ->select('assets.*', 'suppliers.supplier as supplier_name', 'sites.site as site_name', 'locations.location as location_name', 'categories.category as category_name', 'departments.department as department_name');

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
        return view('fcu-ams/asset/addAsset', compact('suppliers', 'sites', 'locations', 'categories', 'departments'));
    }

    public function show($id)
    {
        $asset = Asset::with(['supplier', 'site', 'location', 'category', 'department', 'editHistory'])->findOrFail($id);
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

    public function import(Request $request)
    {
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        if (!in_array($extension, ['xlsx', 'xls', 'csv'])) {
            return redirect()->back()->with('error', 'Invalid file type. Only xlsx, xls, and csv are allowed.');
        }

        try {
            if ($extension == 'xlsx' || $extension == 'xls') {
                $reader = new ReaderXlsx();
            } elseif ($extension == 'csv') {
                $reader = new Csv();
            }

            $spreadsheet = $reader->load($file);
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray();

            // Skip header row
            array_shift($data);

            foreach ($data as $row) {
                if (empty($row)) continue; // Skip empty rows

                // Check if row has at least 12 required columns (excluding Created At and Updated At)
                if (count($row) < 12) { 
                    return redirect()->back()->with('error', 'Invalid data structure in the file.');
                }

                // Extract relevant data from row without trimming
                list(
                    $id,
                    $assetName,
                    $brand,
                    $model,
                    $serialNumber,
                    $cost,
                    $supplierName,
                    $siteName,
                    $locationName,
                    $categoryName,
                    $departmentName,
                    $purchaseDate,
                    // Ignore Condition for now; adjust as needed
                    // Add more fields here if necessary
                ) = array_slice($row, 0, 12);

                // Find IDs for related tables without trimming
                $supplierId = Supplier::where('supplier', $supplierName)->value('id');
                if (!$supplierId) {
                    Log::error('Supplier not found: ' . $supplierName);
                    return redirect()->back()->with('error', 'Supplier not found: ' . $supplierName);
                }

                $siteId = Site::where('site', $siteName)->value('id');
                if (!$siteId) {
                    Log::error('Site not found: ' . $siteName);
                    return redirect()->back()->with('error', 'Site not found: ' . $siteName);
                }

                $locationId = Location::where('location', $locationName)->value('id');
                if (!$locationId) {
                    Log::error('Location not found: ' . $locationName);
                    return redirect()->back()->with('error', 'Location not found: ' . $locationName);
                }

                $categoryId = Category::where('category', $categoryName)->value('id');
                if (!$categoryId) {
                    Log::error('Category not found: ' . $categoryName);
                    return redirect()->back()->with('error', 'Category not found: ' . $categoryName);
                }

                $departmentId = Department::where('department', $departmentName)->value('id');
                if (!$departmentId) {
                    Log::error('Department not found: ' . $departmentName);
                    return redirect()->back()->with('error', 'Department not found: ' . $departmentName);
                }

                // Prepare asset data without trimming
                $assetData = [
                    'asset_name' => $assetName,
                    'brand' => $brand,
                    'model' => $model,
                    'serial_number' => $serialNumber,
                    'cost' => floatval($cost),
                    'supplier_id' => $supplierId,
                    'site_id' => $siteId,
                    'location_id' => $locationId,
                    'category_id' => $categoryId,
                    'department_id' => $departmentId,
                    'purchase_date' => date('Y-m-d', strtotime($purchaseDate)),
                    // Add more fields here if necessary
                    // Condition is ignored for now; adjust as needed
                ];

                // Check if asset exists by serial number or name
                $existingAsset = Asset::where('serial_number', $assetData['serial_number'])->orWhere('asset_name', $assetData['asset_name'])->first();

                if ($existingAsset) {
                    try {
                        $existingAsset->update($assetData);
                    } catch (\Exception $e) {
                        Log::error('Error updating asset: ' . $e->getMessage());
                        return redirect()->back()->with('error', 'Error updating asset: ' . $e->getMessage());
                    }
                } else {
                    // Create new asset
                    try {
                        Asset::create($assetData);
                    } catch (\Exception $e) {
                        Log::error('Error creating asset: ' . $e->getMessage());
                        return redirect()->back()->with('error', 'Error creating asset: ' . $e->getMessage());
                    }
                }
            }

            return redirect()->route('asset.list')->with('success', 'Assets imported successfully.');
        } catch (\Exception $e) {
            Log::error('Error importing file: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error importing file: ' . $e->getMessage());
        }
    }

    public function export() { 
        $assets = Asset::with(['supplier', 'site', 'location', 'category', 'department'])->get();
        $spreadsheet = new Spreadsheet(); 
        $sheet = $spreadsheet->getActiveSheet(); 
        $sheet->setCellValue('A1','ID'); 
        $sheet->setCellValue('B1', 'Asset Name'); 
        $sheet->setCellValue('C1', 'Brand'); 
        $sheet->setCellValue('D1','Model'); 
        $sheet->setCellValue('E1', 'Serial Number'); 
        $sheet->setCellValue('F1', 'Cost');    
        $sheet->setCellValue('G1', 'Supplier'); 
        $sheet->setCellValue('H1', 'Site'); 
        $sheet->setCellValue('I1', 'Location');
        $sheet->setCellValue('J1', 'Category'); 
        $sheet->setCellValue('K1', 'Department'); 
        $sheet->setCellValue('L1', 'Purchase Date'); 
        $sheet->setCellValue('M1', 'Condition'); 
        $sheet->setCellValue('N1', 'Created At'); 
        $sheet->setCellValue('O1', 'Updated At'); 
        $row = 2; foreach ($assets as $asset) { 
            $sheet->setCellValue('A' . $row, $asset->id); 
            $sheet->setCellValue('B' . $row, $asset->asset_name); 
            $sheet->setCellValue('C' . $row, $asset->brand); 
            $sheet->setCellValue('D' . $row, $asset->model); 
            $sheet->setCellValue('E' . $row, $asset->serial_number); 
            $sheet->setCellValue('F' . $row, $asset->cost); 
            $sheet->setCellValue('G' . $row, $asset->supplier->supplier);
            $sheet->setCellValue('H' . $row, $asset->site->site);
            $sheet->setCellValue('I' . $row, $asset->location->location);
            $sheet->setCellValue('J' . $row, $asset->category->category);
            $sheet->setCellValue('K' . $row, $asset->department->department);
            $sheet->setCellValue('L' . $row, $asset->purchase_date); 
            $sheet->setCellValue('M' . $row, $asset->condition); 
            $sheet->setCellValue('N' . $row, $asset->created_at); 
            $sheet->setCellValue('O' . $row, $asset->updated_at); $row++; 
        } 
        $writer = new WriterXlsx($spreadsheet); $filename = 'assets_' . date('Y-m-d') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($filename).'"'); 
        $writer->save('php://output'); 
    }
}
