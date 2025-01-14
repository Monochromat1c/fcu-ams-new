<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportPrintService
{
    public function printMonthlySupplierReport($inventories, $startDate, $endDate)
    {
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);

        $totalValue = $inventories->sum(function ($inventory) {
            return $inventory->quantity * $inventory->unit_price;
        });

        $pdf = PDF::loadView('reports.monthly-supplier-pdf', [
            'inventories' => $inventories,
            'startDate' => $startDate->format('F j, Y'),
            'endDate' => $endDate->format('F j, Y'),
            'totalValue' => $totalValue
        ]);

        $fileName = "inventory_report_" . $startDate->format('Y-m-d') . "_to_" . $endDate->format('Y-m-d') . ".pdf";
        return $pdf->download($fileName);
    }

    public function printMonthlyAssetsReport($assets, $startDate, $endDate)
    {
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);

        $totalValue = $assets->sum('cost');

        $pdf = PDF::loadView('reports.monthly-assets-pdf', [
            'assets' => $assets,
            'startDate' => $startDate->format('F j, Y'),
            'endDate' => $endDate->format('F j, Y'),
            'totalValue' => $totalValue
        ]);

        $fileName = "assets_report_" . $startDate->format('Y-m-d') . "_to_" . $endDate->format('Y-m-d') . ".pdf";
        return $pdf->download($fileName);
    }

    public function printAssignedAssetsReport($assets, $assignee)
    {
        $totalValue = $assets->sum('cost');
        $currentDate = Carbon::now()->format('F j, Y');

        $pdf = PDF::loadView('reports.assigned-assets-pdf', [
            'assets' => $assets,
            'assignee' => $assignee,
            'currentDate' => $currentDate,
            'totalValue' => $totalValue
        ]);

        $fileName = "assigned_assets_" . str_replace(' ', '_', strtolower($assignee)) . "_" . Carbon::now()->format('Y-m-d') . ".pdf";
        return $pdf->download($fileName);
    }
}