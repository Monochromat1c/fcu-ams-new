<?php

namespace App\Exports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class InventoryExportReport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = Carbon::parse($startDate)->startOfDay();
        $this->endDate = Carbon::parse($endDate)->endOfDay();
    }

    public function collection()
    {
        return Inventory::with(['supplier', 'brand', 'unit'])
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->where('quantity', '>', 0)
            ->orderBy('unique_tag', 'asc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Tag ID',
            'Item Specifications',
            'Brand',
            'Quantity',
            'Unit',
            'Unit Price',
            'Total Price',
            'Supplier',
            'Date Added'
        ];
    }

    public function map($inventory): array
    {
        return [
            $inventory->unique_tag,
            $inventory->items_specs,
            $inventory->brand->brand,
            $inventory->quantity,
            $inventory->unit->unit,
            number_format($inventory->unit_price, 2),
            number_format($inventory->unit_price * $inventory->quantity, 2),
            $inventory->supplier->supplier,
            $inventory->created_at->format('M d, Y')
        ];
    }
}