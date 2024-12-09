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

        $fileName = "supplier_report_" . $startDate->format('Y-m-d') . "_to_" . $endDate->format('Y-m-d') . ".pdf";
        return $pdf->download($fileName);
    }
}