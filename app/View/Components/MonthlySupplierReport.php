<?php

// app/View/Components/MonthlySupplierReport.php
namespace App\View\Components;

use Illuminate\View\Component;
use Carbon\Carbon;

class MonthlySupplierReport extends Component
{
    public $inventories;
    public $startDate;
    public $endDate;
    public $totalValue;

    public function __construct($inventories, $startDate, $endDate)
    {
        $this->inventories = $inventories;
        $this->startDate = Carbon::parse($startDate)->format('F j, Y');
        $this->endDate = Carbon::parse($endDate)->format('F j, Y');
        $this->totalValue = $this->calculateTotalValue();
    }

    private function calculateTotalValue()
    {
        return $this->inventories->sum(function ($inventory) {
            return $inventory->quantity * $inventory->unit_price;
        });
    }

    public function render()
    {
        return view('components.monthly-supplier-report');
    }
}