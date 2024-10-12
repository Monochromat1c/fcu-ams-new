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
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AssetsExport;
use App\Imports\AssetsImport;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    public function add(Request $request)
    {
        $validatedData = $request->validate([
            'supplier' => 'required|string|unique:suppliers,supplier',
        ], [
            'supplier.unique' => 'Supplier already exists.',
        ]);

        $supplier = new Supplier();
        $supplier->supplier = $validatedData['supplier'];
        $supplier->save();

        return redirect()->back()->with('success', 'Supplier added successfully!');
    }

    public function index() {
        $suppliers = Supplier::orderBy('supplier', 'asc')->paginate(10);

        return view('fcu-ams/suppliers/suppliersList', compact('suppliers'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'supplier' => 'required|string',
        ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->supplier = $validatedData['supplier'];
        $supplier->save();

        return redirect()->route('supplier.index')->with('success', 'Supplier updated successfully!');
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);

        $supplier = Supplier::find($id);
        if ($supplier) {
            try {
                $supplier->delete();
                return redirect()->back()->with('success', 'Supplier deleted successfully!');
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->withErrors(['error' => 'Cannot delete supplier because it is
                associated with other data.']);
            }
        } else {
            return redirect()->back()->withErrors(['error' => 'Supplier not found']);
        }
    }
}
