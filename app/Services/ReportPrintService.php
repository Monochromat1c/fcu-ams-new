<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;

class ReportPrintService
{
    public function printMonthlySupplierReport($inventories, $month, $year)
    {
        $totalValue = $inventories->sum(function ($inventory) {
            return $inventory->quantity * $inventory->unit_price;
        });

        $pdf = PDF::loadView('reports.monthly-supplier-pdf', [
            'inventories' => $inventories,
            'month' => $month,
            'year' => $year,
            'totalValue' => $totalValue
        ]);

        return $pdf->download("supplier_report_{$month}_{$year}.pdf");
    }
}