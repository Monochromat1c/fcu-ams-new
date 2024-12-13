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
    // Recent actions for assets
    $assets = Asset::select('id', 'asset_tag_id as name', 'created_at', 
                DB::raw("'Asset' as type"), DB::raw("'added' as action"))
        ->unionAll(
            Asset::select('id', 'asset_tag_id as name', 'updated_at as created_at', 
                DB::raw("'Asset' as type"), DB::raw("'updated' as action"))
                ->whereRaw('updated_at > created_at')
        )
        ->unionAll(
            Asset::withTrashed()
                ->whereNotNull('deleted_at')
                ->select('id', 'asset_tag_id as name', 'deleted_at as created_at', 
                    DB::raw("'Asset' as type"), DB::raw("'removed' as action"))
        );

    // Recent actions for inventory
    $inventory = Inventory::select('id', 'items_specs as name', 'created_at', 
                    DB::raw("'Inventory' as type"), DB::raw("'added' as action"))
        ->unionAll(
            Inventory::select('id', 'items_specs as name', 'updated_at as created_at', 
                DB::raw("'Inventory' as type"), DB::raw("'updated' as action"))
                ->whereRaw('updated_at > created_at')
        )
        ->unionAll(
            Inventory::withTrashed()
                ->whereNotNull('deleted_at')
                ->select('id', 'items_specs as name', 'deleted_at as created_at', 
                    DB::raw("'Inventory' as type"), DB::raw("'removed' as action"))
        );

    // Combine both actions
    $recentActions = $assets->union($inventory)
        ->orderBy('created_at', 'desc')
        ->limit($limit)
        ->get();

    // Get edit history for assets
    $assetEditHistory = AssetEditHistory::select('created_at', 'user_id', 'changes', 'asset_id')
        ->with('user')
        ->orderBy('created_at', 'desc')
        ->limit($limit);

    // Get edit history for inventories
    $inventoryEditHistory = InventoryEditHistory::select('created_at', 'user_id', 'changes', 'inventory_id')
        ->with('user')
        ->orderBy('created_at', 'desc')
        ->limit($limit);

    // Combine edit histories
    $editHistories = $assetEditHistory->union($inventoryEditHistory)
        ->orderBy('created_at', 'desc')
        ->get();

    // Combine recent actions and edit histories
    $combinedActions = collect();

    foreach ($recentActions as $action) {
        $combinedActions->push([
            'type' => $action->type,
            'name' => $action->name,
            'action' => $action->action,
            'date' => $action->created_at->diffForHumans(),
            'user' => 'System', // Default to 'System' for actions without user info
        ]);
    }

    foreach ($editHistories as $history) {
        $combinedActions->push([
            'type' => $history instanceof AssetEditHistory ? 'Asset' : 'Inventory',
            'name' => $history->asset_id 
                ? optional(Asset::find($history->asset_id))->asset_tag_id 
                : optional(Inventory::find($history->inventory_id))->items_specs,
            'action' => 'edited',
            'date' => $history->created_at->diffForHumans(),
            'user' => $history->user ? $history->user->first_name . ' ' . $history->user->last_name : 'System',
        ]);
    }

    // Group by name and action to combine similar edits
    $finalActions = $combinedActions->groupBy(function ($item) {
        return $item['name'] . '|' . $item['action'];
    })->map(function ($group) {
        $first = $group->first();
        return [
            'type' => $first['type'],
            'name' => $first['name'],
            'action' => $first['action'],
            'date' => $first['date'],
            'user' => $first['user'],
            'changes' => $group->pluck(' name')->implode(', '), // Combine changes
        ];
    })->values();

    return $finalActions->take($limit);
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
