<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Models\Asset;
use App\Models\Inventory;
use App\Models\Supplier;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $totalAssets = Asset::count();
        $totalAssetValue = Asset::sum('cost');
        $totalInventoryStocks = Inventory::count();
        $totalInventoryValue = Inventory::sum(DB::raw('unit_price * stocks'));

        $mostAcquiredCategory = Asset::select('category_id', DB::raw('COUNT(*) as count'))
        ->groupBy('category_id')
        ->orderBy('count', 'desc')
        ->first()->category_id;

        $mostAcquiredCategoryName = Category::find($mostAcquiredCategory)->category;

        $mostValuedCategory = Asset::select('category_id', DB::raw('SUM(cost) as cost_sum'))
        ->groupBy('category_id')
        ->orderBy('cost_sum', 'desc')
        ->first()->category_id;

        $mostValuedCategoryName = Category::find($mostValuedCategory)->category;

        $mostAcquiredSupplier = Asset::select('supplier_id', DB::raw('COUNT(*) as count'))
        ->groupBy('supplier_id')
        ->orderBy('count', 'desc')
        ->first()->supplier_id;

        $mostAcquiredSupplierName = Supplier::find($mostAcquiredSupplier)->supplier;

        $mostValuedSupplier = Asset::select('supplier_id', DB::raw('SUM(cost) as cost_sum'))
        ->groupBy('supplier_id')
        ->orderBy('cost_sum', 'desc')
        ->first()->supplier_id;

        $mostValuedSupplierName = Supplier::find($mostValuedSupplier)->supplier;

        // Get asset distribution data
        $assetDistribution = Category::withCount('assets')->get()->map(function ($category) {
            return [
                'label' => $category->category,
                'value' => $category->assets_count,
            ];
        });

        // Get monthly asset acquisition data
        $assetAcquisition = Asset::select(DB::raw('MONTH(purchase_date) as month'), DB::raw('COUNT(*) as count'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($asset) {
                return [
                    'label' => date('F', mktime(0, 0, 0, $asset->month, 1)),
                    'value' => $asset->count,
                ];
            });

        // Get recent actions
        $recentActions = $this->getRecentActions();

        $analyticsData = [
        [
            'label' => 'Total Assets',
            'value' => $totalAssets,
        ],
        [
            'label' => 'Total Asset Value',
            'value' => $totalAssetValue,
        ],
        [
            'label' => 'Total Inventory Stocks',
            'value' => $totalInventoryStocks,
        ],
        [
            'label' => 'Total Inventory Value',
            'value' => $totalInventoryValue,
        ],
    ];

    $distributionData = [
        [
            'label' => 'Most Acquired Asset Category',
            'value' => $mostAcquiredCategoryName,
        ],
        [
            'label' => 'Most Valued Asset Category',
            'value' => $mostValuedCategoryName,
        ],
        [
            'label' => 'Most Acquired Asset Supplier',
            'value' => $mostAcquiredSupplierName,
        ],
        [
            'label' => 'Most Valued Asset Supplier',
            'value' => $mostValuedSupplierName,
        ],
    ];

        return view('fcu-ams/dashboard', compact(
            'totalAssets',
            'totalAssetValue',
            'totalInventoryStocks',
            'totalInventoryValue',
            'assetDistribution',
            'assetAcquisition',
            'recentActions',
            'mostAcquiredCategoryName',
            'mostValuedCategoryName',
            'mostAcquiredSupplierName',
            'mostValuedSupplierName',
            'analyticsData',
            'distributionData',
        ));
    }

    private function getRecentActions($limit = 5)
    {
        $assets = Asset::select('id', 'asset_name as name', 'created_at', DB::raw("'Asset' as type"), DB::raw("'added' as action"))
            ->unionAll(
                Asset::select('id', 'asset_name as name', 'updated_at as created_at', DB::raw("'Asset' as type"), DB::raw("'updated' as action"))
                    ->whereRaw('updated_at > created_at')
            )
            ->unionAll(
                Asset::withTrashed()
                    ->whereNotNull('deleted_at')
                    ->select('id', 'asset_name as name', 'deleted_at as created_at', DB::raw("'Asset' as type"),
                    DB::raw("'removed' as action"))
            );

        $inventory = Inventory::select('id', 'items_specs as name', 'created_at', DB::raw("'Inventory' as type"), DB::raw("'added' as action"))
            ->unionAll(
                Inventory::select('id', 'items_specs as name', 'updated_at as created_at', DB::raw("'Inventory' as type"), DB::raw("'updated' as action"))
                    ->whereRaw('updated_at > created_at')
            )
            ->unionAll(
                Inventory::withTrashed()
                    ->whereNotNull('deleted_at')
                    ->select('id', 'items_specs as name', 'deleted_at as created_at', DB::raw("'Inventory' as type"), DB::raw("'removed' as action"))
            );

        $recentActions = $assets->union($inventory)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return $recentActions->map(function ($item) {
            return [
                'type' => $item->type,
                'name' => $item->name,
                'action' => $item->action,
                'date' => $item->created_at->diffForHumans(),
            ];
        });
    }
}
