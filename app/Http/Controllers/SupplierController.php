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

class SupplierController extends Controller
{
    public function add(Request $request)
    {
        $validatedData = $request->validate([
            'supplier' => 'required|string',
        ]);

        $supplier = new Supplier();
        $supplier->supplier = $validatedData['supplier'];
        $supplier->save();

        $request->session()->put('input', $request->all());

        return response()->json(['reload' => true]);
    }
    
    public function delete(Request $request)
    {
        $id = $request->input('id');
        $supplier = Supplier::find($id);
        if ($supplier) {
            try {
                $supplier->delete();
                return redirect()->back()->with('success', 'Supplier deleted successfully');
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->withErrors(['error' => 'Cannot delete supplier because it is associated with one or more assets.']);
            }
        } else {
            return redirect()->back()->withErrors(['error' => 'Supplier not found']);
        }
    }
}
