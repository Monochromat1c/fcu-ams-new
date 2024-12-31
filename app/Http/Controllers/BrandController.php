<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use DB;
use App\Models\Asset;
use App\Models\Brand;
use App\Models\Site;
use App\Models\Location;
use App\Models\Department;
use App\Models\AssetEditHistory;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AssetsExport;
use App\Imports\AssetsImport;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{
    public function add(Request $request)
    {
        $validatedData = $request->validate([
            'brand' => 'required|string|unique:brands,brand',
        ], [
            'brand.unique' => 'Brand already exists.',
        ]);

        $brand = new Brand();
        $brand->brand = $validatedData['brand'];
        $brand->save();

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Brand added successfully!');
    }

    public function index() {
        $brands = Brand::orderBy('brand', 'asc')->paginate(10);

        return view('fcu-ams/brands/brandsList', compact('brands'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'brand' => 'required|string',
        ]);

        $brand = Brand::findOrFail($id);
        $brand->brand = $validatedData['brand'];
        $brand->save();

        return redirect()->route('brand.index')->with('success', 'Brand updated successfully!');
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        $brand = Brand::find($id);
        if ($brand) {
            try {
                $brand->delete();
                return redirect()->back()->with('success', 'Brand deleted successfully!');
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->withErrors(['error' => 'Cannot delete brand because it is
                associated with other data.']);
            }
        } else {
            return redirect()->back()->withErrors(['error' => 'Brand not found']);
        }
    }

    public function list()
    {
        return response()->json(Brand::orderBy('brand', 'asc')->get());
    }
}
