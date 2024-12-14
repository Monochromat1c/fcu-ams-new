<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Models\Asset;
use App\Models\Inventory;
use App\Models\Supplier;
use App\Models\Category;
use App\Models\AssetEditHistory;
use App\Models\InventoryEditHistory;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $totalAssets = Asset::count();
        $totalAssetValue = Asset::sum('cost');
        $totalInventoryStocks = Inventory::count();
        $totalInventoryValue = Inventory::sum(DB::raw('unit_price * quantity'));

        $mostAcquiredCategory = Asset::select('category_id', DB::raw('COUNT(*) as count'))
            ->groupBy('category_id')
            ->orderBy('count', 'desc')
            ->first();

        if ($mostAcquiredCategory) {
            $mostAcquiredCategoryName = Category::find($mostAcquiredCategory->category_id)->category ?? 'No Data Available';
        } else {
            $mostAcquiredCategoryName = 'No Data Available';
        }

        $mostValuedCategory = Asset::select('category_id', DB::raw('SUM(cost) as cost_sum'))
            ->groupBy('category_id')
            ->orderBy('cost_sum', 'desc')
            ->first();

        if ($mostValuedCategory) {
            $mostValuedCategoryName = Category::find($mostValuedCategory->category_id)->category ?? 'No Data Available';
        } else {
            $mostValuedCategoryName = 'No Data Available';
        }

        $mostAcquiredSupplier = Asset::select('supplier_id', DB::raw('COUNT(*) as count'))
            ->groupBy('supplier_id')
            ->orderBy('count', 'desc')
            ->first();

        if ($mostAcquiredSupplier) {
            $mostAcquiredSupplierName = Supplier::find($mostAcquiredSupplier->supplier_id)->supplier ?? 'No Data Available';
        } else {
            $mostAcquiredSupplierName = 'No Data Available';
        }

        $mostValuedSupplier = Asset::select('supplier_id', DB::raw('SUM(cost) as cost_sum'))
            ->groupBy('supplier_id')
            ->orderBy('cost_sum', 'desc')
            ->first();

        if ($mostValuedSupplier) {
            $mostValuedSupplierName = Supplier::find($mostValuedSupplier->supplier_id)->supplier ?? 'No Data Available';
        } else {
            $mostValuedSupplierName = 'No Data Available';
        }

        $assetDistribution = Category::withCount('assets')->get()->map(function ($category) {
            return [
                'label' => $category->category,
                'value' => $category->assets_count,
            ];
        });

        $selectedYear = $request->input('year', now()->year);

        $assetAcquisition = Asset::select(DB::raw('MONTH(purchase_date) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('purchase_date', $selectedYear)  // Filter by selected year
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $assetAcquisition->transform(function ($item) {
            $item->month = date('F', mktime(0, 0, 0, $item->month, 1));
            $item->asset_tags = Asset::whereMonth('purchase_date', $item->month)
                ->whereYear('purchase_date', $item->year)  // Add year filter to asset tags
                ->pluck('asset_tag_id')
                ->implode(', ');
            return $item;
        });

        $availableYears = Asset::select(DB::raw('DISTINCT YEAR(purchase_date) as year'))
            ->orderBy('year', 'desc')
            ->pluck('year');

            $mostAcquiredInventorySupplier = Inventory::select('supplier_id', DB::raw('COUNT(*) as count'))
                ->groupBy('supplier_id')
                ->orderBy('count', 'desc')
                ->first();

            if ($mostAcquiredInventorySupplier) {
                $mostAcquiredInventorySupplierName = Supplier::find($mostAcquiredInventorySupplier->supplier_id)->supplier ?? 'No Data Available';
            } else {
                $mostAcquiredInventorySupplierName = 'No Data Available';
            }

            $mostValuedInventorySupplier = Inventory::select('supplier_id', DB::raw('SUM(unit_price * quantity) as value_sum'))
                ->groupBy('supplier_id')
                ->orderBy('value_sum', 'desc')
                ->first();

            if ($mostValuedInventorySupplier) {
                $mostValuedInventorySupplierName = Supplier::find($mostValuedInventorySupplier->supplier_id)->supplier ?? 'No Data Available';
            } else {
                $mostValuedInventorySupplierName = 'No Data Available';
            }

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
                'label' => 'Most Acquired Inventory Supplier',
                'value' => $mostAcquiredInventorySupplierName,
            ],
            [
                'label' => 'Most Valued Inventory Supplier',
                'value' => $mostValuedInventorySupplierName,
            ],
        ];

        $depreciationTrends = $this->getDepreciationTrends();
        $assetValueDistribution = $this->getAssetValueDistribution();
        $inventoryValueDistribution = $this->getInventoryValueDistribution();

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
            'mostAcquiredInventorySupplierName',
            'mostValuedInventorySupplierName',
            'analyticsData',
            'distributionData',
            'depreciationTrends',
            'assetValueDistribution',
            'inventoryValueDistribution',
            'assetAcquisition', 'availableYears', 'selectedYear',
        ));
    }

    private function getRecentActions($limit = 10)
    {
        // Recent actions for asset additions
        $assetAdditions = Asset::withTrashed()->select(
            'assets.id', 
            'assets.asset_tag_id as name', 
            'assets.created_at', 
            DB::raw("'Asset' as type"), 
            DB::raw("'added' as action"),
            'createdByUser.id as user_id',
            DB::raw("COALESCE(CONCAT(createdByUser.first_name, ' ', createdByUser.last_name), 'System') as user_name")
        )
        ->leftJoin('users as createdByUser', 'assets.created_by', '=', 'createdByUser.id');

        // Recent actions for asset deletions
        $assetDeletions = Asset::withTrashed()
            ->select(
                'assets.id', 
                'assets.asset_tag_id as name', 
                'assets.deleted_at as created_at', 
                DB::raw("'Asset' as type"), 
                DB::raw("'removed' as action"),
                'deletedByUser.id as user_id',
                DB::raw("COALESCE(CONCAT(deletedByUser.first_name, ' ', deletedByUser.last_name), 'System') as user_name")
            )
            ->leftJoin('users as deletedByUser', 'assets.deleted_by', '=', 'deletedByUser.id')
            ->whereNotNull('deleted_at');

        // Recent actions for inventory additions
        $inventoryAdditions = Inventory::withTrashed()->select(
            'inventories.id', 
            'inventories.items_specs as name', 
            'inventories.created_at', 
            DB::raw("'Inventory' as type"), 
            DB::raw("'added' as action"),
            'createdByUser.id as user_id',
            DB::raw("COALESCE(CONCAT(createdByUser.first_name, ' ', createdByUser.last_name), 'System') as user_name")
        )
        ->leftJoin('users as createdByUser', 'inventories.created_by', '=', 'createdByUser.id');

        // Recent actions for inventory deletions
        $inventoryDeletions = Inventory::withTrashed()
            ->select(
                'inventories.id', 
                'inventories.items_specs as name', 
                'inventories.deleted_at as created_at', 
                DB::raw("'Inventory' as type"), 
                DB::raw("'removed' as action"),
                'deletedByUser.id as user_id',
                DB::raw("COALESCE(CONCAT(deletedByUser.first_name, ' ', deletedByUser.last_name), 'System') as user_name")
            )
            ->leftJoin('users as deletedByUser', 'inventories.deleted_by', '=', 'deletedByUser.id')
            ->whereNotNull('deleted_at');

        // Get edit history for assets
        $assetEditHistory = AssetEditHistory::select(
            'asset_edit_histories.asset_id as id', 
            DB::raw("(SELECT asset_tag_id FROM assets WHERE id = asset_edit_histories.asset_id) as name"),
            'asset_edit_histories.created_at', 
            DB::raw("'Asset' as type"), 
            DB::raw("'edited' as action"),
            'editUser.id as user_id',
            DB::raw("CONCAT(editUser.first_name, ' ', editUser.last_name) as user_name")
        )
        ->join('users as editUser', 'asset_edit_histories.user_id', '=', 'editUser.id');

        // Get edit history for inventories
        $inventoryEditHistory = InventoryEditHistory::select(
            'inventory_edit_histories.inventory_id as id', 
            DB::raw("(SELECT items_specs FROM inventories WHERE id = inventory_edit_histories.inventory_id) as name"),
            'inventory_edit_histories.created_at', 
            DB::raw("'Inventory' as type"), 
            DB::raw("'edited' as action"),
            'editUser.id as user_id',
            DB::raw("CONCAT(editUser.first_name, ' ', editUser.last_name) as user_name")
        )
        ->join('users as editUser', 'inventory_edit_histories.user_id', '=', 'editUser.id');

        // Combine and sort actions
        $recentActions = $assetAdditions
            ->union($assetDeletions)
            ->union($inventoryAdditions)
            ->union($inventoryDeletions)
            ->union($assetEditHistory)
            ->union($inventoryEditHistory)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($action) {
                return [
                    'type' => $action->type,
                    'name' => $action->name,
                    'action' => $action->action,
                    'date' => $action->created_at->diffForHumans(),
                    'user' => $action->user_name,
                ];
            });

        return $recentActions;
    }

    private function getDepreciationTrends()
    {
        $depreciationRate = 0.2;

        $depreciationTrends = Asset::select(
            DB::raw('YEAR(purchase_date) as year'),
            DB::raw('SUM(cost) as total_cost')
        )
        ->groupBy('year')
        ->orderBy('year')
        ->get()
        ->map(function ($item) use ($depreciationRate) {
            $yearsSincePurchase = now()->diffInYears($item->year . '-01-01');
            
            $currentValue = $item->total_cost * pow((1 - $depreciationRate), $yearsSincePurchase);
            
            return [
                'year' => $item->year,
                'total_cost' => round($item->total_cost, 2),
                'current_value' => round(max(0, $currentValue), 2),
                'depreciation' => round($item->total_cost - max(0, $currentValue), 2)
            ];
        });

        return $depreciationTrends;
    }

    private function getAssetValueDistribution()
    {
        $assetValueDistribution = Asset::join('categories', 'assets.category_id', '=', 'categories.id')
            ->select(
                'categories.category',
                DB::raw('SUM(assets.cost) as total_value'),
                DB::raw('COUNT(*) as asset_count')
            )
            ->groupBy('categories.category')
            ->orderBy('total_value', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'category' => $item->category,
                    'total_value' => round($item->total_value, 2),
                    'asset_count' => $item->asset_count,
                    'percentage' => round(($item->total_value / Asset::sum('cost')) * 100, 2)
                ];
            });

        return $assetValueDistribution;
    }

    private function getInventoryValueDistribution()
    {
        $inventoryValueDistribution = Inventory::join('brands', 'inventories.brand_id', '=', 'brands.id')
            ->select(
                'brands.brand',
                DB::raw('SUM(inventories.unit_price * inventories.quantity) as total_value'),
                DB::raw('COUNT(*) as inventory_count')
            )
            ->groupBy('brands.brand')
            ->orderBy('total_value', 'desc')
            ->get()
            ->map(function ($item) {
                $totalInventoryValue = Inventory::sum(DB::raw('unit_price * quantity'));
                return [
                    'brand' => $item->brand,
                    'total_value' => round($item->total_value, 2),
                    'inventory_count' => $item->inventory_count,
                    'percentage' => round(($item->total_value / $totalInventoryValue) * 100, 2)
                ];
            });

        return $inventoryValueDistribution;
    }
}
