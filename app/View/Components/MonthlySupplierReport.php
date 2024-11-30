<?php

// app/View/Components/MonthlySupplierReport.php
namespace App\View\Components;

use Illuminate\View\Component;
use Carbon\Carbon;

class MonthlySupplierReport extends Component
{
    public $inventories;
    public $selectedMonth;
    public $selectedYear;
    public $totalValue;

    public function __construct($inventories, $selectedMonth, $selectedYear)
    {
        $this->inventories = $inventories;
        $this->selectedMonth = $selectedMonth;
        $this->selectedYear = $selectedYear;
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