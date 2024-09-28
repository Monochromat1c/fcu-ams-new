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
}
