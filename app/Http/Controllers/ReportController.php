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
use App\Models\Inventory;
use App\Models\Department;
use App\Models\AssetEditHistory;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AssetsExport;
use App\Imports\AssetsImport;
use Illuminate\Validation\Rule;

class ReportController extends Controller
{
    public function index(Request $request) {
        $inventories = Inventory::with('supplier')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->where('quantity', '>', 0)
            ->orderBy('unique_tag', 'asc')
            ->paginate(5);

        $lowStockInventories = Inventory::with('supplier')
            ->where('quantity', '>=', 1)
            ->where('quantity', '<', 20)
            ->whereNull('deleted_at')
            ->orderBy('unique_tag', 'asc')
            ->paginate(5);

        return view('fcu-ams/reports/reports', compact('inventories', 'lowStockInventories'));
    }
}
