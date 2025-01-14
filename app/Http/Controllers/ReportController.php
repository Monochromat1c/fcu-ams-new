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
use App\Models\Brand;
use App\Models\Unit;
use Carbon\Carbon;
use App\Models\SupplyRequest;
use App\Exports\InventoryExportReport;
use App\Exports\AssetExportReport;
use App\Services\ReportPrintService;

class ReportController extends Controller
{
    public function index(Request $request) {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();

        // Get chart data
        $inventoryBySupplier = Inventory::select('suppliers.supplier', DB::raw('COUNT(*) as count'))
            ->join('suppliers', 'inventories.supplier_id', '=', 'suppliers.id')
            ->where('inventories.quantity', '>', 0)
            ->groupBy('suppliers.supplier')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        $chartLabels = $inventoryBySupplier->pluck('supplier');
        $chartData = $inventoryBySupplier->pluck('count');

        // Get asset distribution by department data
        $assetsByDepartment = Asset::select('departments.department', DB::raw('COUNT(*) as count'))
            ->join('departments', 'assets.department_id', '=', 'departments.id')
            ->groupBy('departments.department')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        $departmentChartLabels = $assetsByDepartment->pluck('department');
        $departmentChartData = $assetsByDepartment->pluck('count');

        // Get stock-out trends data for the last 6 months
        $stockOutTrends = StockOut::select(
            DB::raw('DATE_FORMAT(stock_out_date, "%Y-%m") as month'),
            DB::raw('COUNT(DISTINCT stock_out_id) as count')
        )
            ->where('stock_out_date', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $trendLabels = $stockOutTrends->pluck('month')->map(function($month) {
            return Carbon::createFromFormat('Y-m', $month)->format('F Y');
        });
        $trendData = $stockOutTrends->pluck('count');

        // Assets date filter
        $assetsStartDate = $request->input('assets_start_date', now()->startOfMonth()->toDateString());
        $assetsEndDate = $request->input('assets_end_date', now()->endOfMonth()->toDateString());
        $assetsStartDate = Carbon::parse($assetsStartDate)->startOfDay();
        $assetsEndDate = Carbon::parse($assetsEndDate)->endOfDay();

        // Assigned assets query
        $assigneeQuery = $request->input('assignee');
        $assignedAssets = null;
        if ($assigneeQuery) {
            $assignedAssets = Asset::with(['supplier', 'brand', 'site', 'location', 'category', 'department', 'condition', 'status'])
                ->where('assigned_to', 'like', '%' . $assigneeQuery . '%')
                ->orderBy('asset_tag_id', 'asc')
                ->paginate(10, ['*'], 'assigned_page')
                ->appends(request()->except('assigned_page'));
        }

        // Date range display method
        $dateRangeDisplay = $this->formatDateRange($startDate, $endDate);
        $assetsDateRangeDisplay = $this->formatDateRange($assetsStartDate, $assetsEndDate, 'assets');

        $inventories = Inventory::with('supplier', 'brand', 'unit')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('quantity', '>', 0)
            ->orderBy('unique_tag', 'asc')
            ->paginate(10, ['*'], 'inventory_page')
            ->appends(request()->except('inventory_page'));

        $inventoriesForPrint = Inventory::with('supplier')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('quantity', '>', 0)
            ->orderBy('unique_tag', 'asc')
            ->get();

        $stockOutRecords = StockOut::with('inventory', 'department')
            ->orderBy('stock_out_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('stock_out_id')
            ->map(function ($records) {
                return $records->first();
            });

            // Stock Out date filter
            $stockOutStartDate = $request->input('stock_out_start_date', now()->startOfMonth()->toDateString());
            $stockOutEndDate = $request->input('stock_out_end_date', now()->endOfMonth()->toDateString());
            $stockOutStartDate = Carbon::parse($stockOutStartDate)->startOfDay();
            $stockOutEndDate = Carbon::parse($stockOutEndDate)->endOfDay();
           
            // Stock Out date range display
            $stockOutDateRangeDisplay = $this->formatDateRange($stockOutStartDate, $stockOutEndDate, 'stock out');
            $stockOutRecords = StockOut::with('inventory', 'department')
                ->whereBetween('stock_out_date', [$stockOutStartDate, $stockOutEndDate])
                ->orderBy('stock_out_date', 'desc')
                ->orderBy('created_at', 'desc')
                ->get()
                ->groupBy('stock_out_id')
                ->map(function ($records) {
                    return $records->first();
                });
 
        $stockOutRecords = new LengthAwarePaginator(
            $stockOutRecords->forPage($request->input('stock_out_page', 1), 10),
            $stockOutRecords->count(),
            10,
            $request->input('stock_out_page', 1),
            ['path' => $request->url(), 'query' => array_merge($request->query(), ['stock_out_page' => $request->input('stock_out_page', 1)])]
        );

        $assets = Asset::with('supplier', 'brand')
            ->whereBetween('purchase_date', [$assetsStartDate, $assetsEndDate])
            ->orderBy('asset_tag_id', 'asc')
            ->paginate(10, ['*'], 'assets_page')
            ->appends(request()->except('assets_page'));


        // Purchase Order date filter
        $poStartDate = $request->input('po_start_date', now()->startOfMonth()->toDateString());
        $poEndDate = $request->input('po_end_date', now()->endOfMonth()->toDateString());
        $poStartDate = Carbon::parse($poStartDate)->startOfDay();
        $poEndDate = Carbon::parse($poEndDate)->endOfDay();

        // Purchase Order date range display
        $poDateRangeDisplay = $this->formatDateRange($poStartDate, $poEndDate, 'purchase order');
        $purchaseOrders = PurchaseOrder::with('supplier', 'department')
            ->whereBetween('po_date', [$poStartDate, $poEndDate])
            ->orderBy('po_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('group_id_for_items_purchased_at_the_same_time')
            ->map(function ($records) {
                return $records->first();
            });


        $purchaseOrders = new LengthAwarePaginator(
            $purchaseOrders->forPage($request->input('po_page', 1), 10),
            $purchaseOrders->count(),
            10,
            $request->input('po_page', 1),
            ['path' => $request->url(), 'query' => array_merge($request->query(), ['po_page' => $request->input('po_page', 1)])]
        );

        // For supply requests
        $supplyRequestStartDate = $request->input('supply_request_start_date', now()->startOfMonth()->toDateString());
        $supplyRequestEndDate = $request->input('supply_request_end_date', now()->endOfMonth()->toDateString());

        $supplyRequestStartDate = Carbon::parse($supplyRequestStartDate)->startOfDay();
        $supplyRequestEndDate = Carbon::parse($supplyRequestEndDate)->endOfDay();

        // First, get all request groups where ALL items are approved
        $fullyApprovedGroups = SupplyRequest::select('request_group_id')
            ->groupBy('request_group_id')
            ->havingRaw('COUNT(*) = SUM(CASE WHEN status = "approved" THEN 1 ELSE 0 END)')
            ->pluck('request_group_id');
        
        // Then use these groups to get the request details
        $approvedRequests = SupplyRequest::with('department')
            ->select(
                'request_group_id',
                'department_id',
                'request_date',
                'requester',
                DB::raw('COUNT(*) as total_items')
            )
            ->whereIn('request_group_id', $fullyApprovedGroups)
            ->whereBetween('request_date', [$supplyRequestStartDate, $supplyRequestEndDate])
            ->groupBy('request_group_id', 'department_id', 'request_date', 'requester')
            ->orderBy('request_date', 'desc')
            ->paginate(10, ['*'], 'supply_request_page');

        $supplyRequestDateRangeDisplay = $supplyRequestStartDate->format('M d, Y') . ' - ' . $supplyRequestEndDate->format('M d, Y');

        return view('fcu-ams/reports/reports', array_merge(
            compact('stockOutRecords', 'assets', 'purchaseOrders', 'inventoriesForPrint',
                'assetsDateRangeDisplay', 'poDateRangeDisplay', 'stockOutDateRangeDisplay',
                'assignedAssets', 'assigneeQuery', 'chartLabels', 'chartData',
                'departmentChartLabels', 'departmentChartData', 'trendLabels', 'trendData', 'approvedRequests', 'supplyRequestDateRangeDisplay'),
            [
                'inventories' => $inventories,
                'startDate' => $startDate->toDateString(),
                'endDate' => $endDate->toDateString(),
                'dateRangeDisplay' => $dateRangeDisplay,
                'purchaseOrders' => $purchaseOrders,
                'poStartDate' => $poStartDate->toDateString(),
                'poEndDate' => $poEndDate->toDateString(),
                'poDateRangeDisplay' => $poDateRangeDisplay,
                'stockOutStartDate' => $stockOutStartDate->toDateString(),
                'stockOutEndDate' => $stockOutEndDate->toDateString(),
                'stockOutDateRangeDisplay' => $stockOutDateRangeDisplay,
                'supplyRequestStartDate' => $supplyRequestStartDate->toDateString(),
                'supplyRequestEndDate' => $supplyRequestEndDate->toDateString(),
                'supplyRequestDateRangeDisplay' => $supplyRequestDateRangeDisplay
            ]
        ));
    }

    private function formatDateRange(Carbon $startDate, Carbon $endDate, $type = 'supplies'): string {
        // Same month scenario
        if ($startDate->month == $endDate->month && $startDate->year == $endDate->year) {
            return sprintf(
                "%s from %s %d %d to %s %d %d",
                ucfirst($type),
                $startDate->translatedFormat('F'),
                $startDate->day,
                $startDate->year,
                $endDate->translatedFormat('F'),
                $endDate->day,
                $endDate->year
            );
        }


        // Different months scenario
        return sprintf(
            "%s from %s %d %d to %s %d %d",
            ucfirst($type),
            $startDate->translatedFormat('F'), 
            $startDate->day, 
            $startDate->year,
            $endDate->translatedFormat('F'), 
            $endDate->day, 
            $endDate->year
        );
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

    public function printReport(Request $request, ReportPrintService $printService)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());
        
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();

        $inventories = Inventory::with('supplier')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('unique_tag', 'asc')
            ->get();
        
        return $printService->printMonthlySupplierReport($inventories, $startDate, $endDate);
    }

    public function printAssetsReport(Request $request, ReportPrintService $printService)
    {
        $startDate = $request->input('assets_start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('assets_end_date', now()->endOfMonth()->toDateString());
        
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();

        $assets = Asset::with('supplier', 'brand')
            ->whereBetween('purchase_date', [$startDate, $endDate])
            ->orderBy('asset_tag_id', 'asc')
            ->get();
        
        return $printService->printMonthlyAssetsReport($assets, $startDate, $endDate);
    }

    public function printAssignedAssets(Request $request, ReportPrintService $printService)
    {
        $assignee = $request->input('assignee');
        if (!$assignee) {
            return redirect()->back()->with('error', 'No assignee specified for printing.');
        }

        $assets = Asset::with(['supplier', 'brand', 'site', 'location', 'category', 'department', 'condition', 'status'])
            ->where('assigned_to', 'like', '%' . $assignee . '%')
            ->orderBy('asset_tag_id', 'asc')
            ->get();

        if ($assets->isEmpty()) {
            return redirect()->back()->with('error', 'No assets found for the specified assignee.');
        }

        return $printService->printAssignedAssetsReport($assets, $assignee);
    }

    private function getMonthlyInventories($month, $year)
    {
        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        return Inventory::with(['supplier', 'brand', 'unit'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('quantity', '>', 0)
            ->orderBy('unique_tag')
            ->paginate(10);
    }

    public function printApprovedRequest($request_group_id)
    {
        $requests = SupplyRequest::with(['department', 'inventory'])
            ->where('request_group_id', $request_group_id)
            ->where('status', 'approved')
            ->get();
    
        if ($requests->isEmpty()) {
            return redirect()->back()->with('error', 'No approved requests found.');
        }
    
        $totalPrice = $requests->sum(function ($request) {
            return ($request->inventory_id ? 
                ($request->inventory->unit_price ?? 0) : 
                ($request->estimated_unit_price ?? 0)) * $request->quantity;
        });
    
        return view('fcu-ams.reports.print-approved-request', compact('requests', 'totalPrice'));
    }

    public function exportInventory(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());
    
        return Excel::download(
            new InventoryExportReport($startDate, $endDate),
            'inventory_report_' . Carbon::now()->format('Y-m-d_His') . '.csv'
        );
    }

    public function exportAssets(Request $request)
    {
        $startDate = $request->input('assets_start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('assets_end_date', now()->endOfMonth()->toDateString());
    
        return Excel::download(
            new AssetExportReport($startDate, $endDate),
            'assets_report_' . Carbon::now()->format('Y-m-d_His') . '.csv'
        );
    }
}
