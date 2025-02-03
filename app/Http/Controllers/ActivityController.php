<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Inventory;
use App\Models\AssetEditHistory;
use App\Models\InventoryEditHistory;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('query');
        $type = $request->get('type');
        $action = $request->get('action');
        $dateRange = $request->get('date_range');

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

        // Apply filters
        if ($query) {
            $assetAdditions->where('assets.asset_tag_id', 'LIKE', "%{$query}%");
            $assetDeletions->where('assets.asset_tag_id', 'LIKE', "%{$query}%");
            $inventoryAdditions->where('inventories.items_specs', 'LIKE', "%{$query}%");
            $inventoryDeletions->where('inventories.items_specs', 'LIKE', "%{$query}%");
        }

        if ($type) {
            $assetAdditions->where(DB::raw("'Asset'"), $type);
            $assetDeletions->where(DB::raw("'Asset'"), $type);
            $inventoryAdditions->where(DB::raw("'Inventory'"), $type);
            $inventoryDeletions->where(DB::raw("'Inventory'"), $type);
            $assetEditHistory->where(DB::raw("'Asset'"), $type);
            $inventoryEditHistory->where(DB::raw("'Inventory'"), $type);
        }

        if ($action) {
            $assetAdditions->where(DB::raw("'added'"), $action);
            $assetDeletions->where(DB::raw("'removed'"), $action);
            $inventoryAdditions->where(DB::raw("'added'"), $action);
            $inventoryDeletions->where(DB::raw("'removed'"), $action);
            $assetEditHistory->where(DB::raw("'edited'"), $action);
            $inventoryEditHistory->where(DB::raw("'edited'"), $action);
        }

        if ($dateRange) {
            $dates = explode(' - ', $dateRange);
            if (count($dates) == 2) {
                $startDate = $dates[0];
                $endDate = $dates[1];
                
                $assetAdditions->whereBetween('assets.created_at', [$startDate, $endDate]);
                $assetDeletions->whereBetween('assets.deleted_at', [$startDate, $endDate]);
                $inventoryAdditions->whereBetween('inventories.created_at', [$startDate, $endDate]);
                $inventoryDeletions->whereBetween('inventories.deleted_at', [$startDate, $endDate]);
                $assetEditHistory->whereBetween('asset_edit_histories.created_at', [$startDate, $endDate]);
                $inventoryEditHistory->whereBetween('inventory_edit_histories.created_at', [$startDate, $endDate]);
            }
        }

        // Combine and sort actions
        $recentActions = $assetAdditions
            ->union($assetDeletions)
            ->union($inventoryAdditions)
            ->union($inventoryDeletions)
            ->union($assetEditHistory)
            ->union($inventoryEditHistory)
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        $recentActions->getCollection()->transform(function ($action) {
            return [
                'id' => $action->id,
                'type' => $action->type,
                'name' => $action->name,
                'action' => $action->action,
                'date' => $action->created_at->diffForHumans(),
                'created_at' => $action->created_at,
                'user' => $action->user_name,
            ];
        });

        return view('fcu-ams.activities.index', compact('recentActions'));
    }
} 