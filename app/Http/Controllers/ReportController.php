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
use App\Models\StockOut;
use App\Models\PurchaseOrder;
use App\Models\AssetEditHistory;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AssetsExport;
use App\Imports\AssetsImport;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;

class ReportController extends Controller
{
    public function index(Request $request) {
        $inventories = Inventory::with('supplier')
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->where('quantity', '>', 0)
            ->orderBy('unique_tag', 'asc')
            ->paginate(10);

        $inventoriesForPrint = Inventory::with('supplier')
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->where('quantity', '>', 0)
            ->orderBy('unique_tag', 'asc')
            ->get();

        $lowStockInventories = Inventory::with('supplier')
            ->where('quantity', '>=', 1)
            ->where('quantity', '<', 20)
            ->whereNull('deleted_at')
            ->orderBy('unique_tag', 'asc')
            ->paginate(10);

        $stockOutRecords = StockOut::with('inventory', 'department')
            ->orderBy('stock_out_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('stock_out_id')
            ->map(function ($records) {
                return $records->first();
            });

            $stockOutRecords = new LengthAwarePaginator(
                $stockOutRecords->forPage($request->page, 10),
                $stockOutRecords->count(),
                10,
                $request->page,
                ['path' => $request->url(), 'query' => $request->query()]
            );

            $assets = Asset::with('supplier', 'brand')
                ->whereDate('purchase_date', '>=', now()->startOfMonth())
                ->whereDate('purchase_date', '<=', now()->endOfMonth())
                ->orderBy('asset_tag_id', 'asc')
                ->paginate(10);

        $purchaseOrders = PurchaseOrder::with('supplier', 'department')
            ->orderBy('po_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('group_id_for_items_purchased_at_the_same_time')
            ->map(function ($records) {
                return $records->first();
            });

        $purchaseOrders = new LengthAwarePaginator(
            $purchaseOrders->forPage($request->page, 10),
            $purchaseOrders->count(),
            5,
            $request->page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('fcu-ams/reports/reports', compact('inventories', 'lowStockInventories', 'stockOutRecords',
        'assets', 'purchaseOrders', 'inventoriesForPrint'));
    }

    public function stockOutDetails($id)
    {
        $record = StockOut::with('inventory', 'department')->findOrFail($id);
        $stockOutDetails = [];
        $totalPrice = 0;

        $stockOutRecords = StockOut::where('stock_out_id', $record->stock_out_id)->get();

        foreach ($stockOutRecords as $stockOutRecord) {
            $inventory = $stockOutRecord->inventory;
            $stockOutDetails[] = [
                'item' => $inventory->brand->brand . ' ' . $inventory->items_specs,
                'quantity' => $stockOutRecord->quantity,
                'price' => $inventory->unit_price,
            ];
            $totalPrice += $stockOutRecord->quantity * $inventory->unit_price;
        }

        return view('fcu-ams/reports/stock-out-details', compact('stockOutDetails', 'totalPrice', 'record'));
    }

    public function purchaseOrderDetails($id)
    {
        $record = PurchaseOrder::with('department', 'supplier')->findOrFail($id);
        $purchaseOrderDetails = [];
        $totalPrice = 0;

        $purchaseOrderRecords = PurchaseOrder::where('group_id_for_items_purchased_at_the_same_time', $record->group_id_for_items_purchased_at_the_same_time)->get();

        foreach ($purchaseOrderRecords as $purchaseOrderRecord) {
            $purchaseOrderDetails[] = [
                'items_specs' => $purchaseOrderRecord->items_specs,
                'quantity' => $purchaseOrderRecord->quantity,
                'unit_price' => $purchaseOrderRecord->unit_price,
            ];
            $totalPrice += $purchaseOrderRecord->quantity * $purchaseOrderRecord->unit_price;
        }

        return view('fcu-ams/reports/purchase-order-details', compact('purchaseOrderDetails', 'totalPrice', 'record'));
    }
}
