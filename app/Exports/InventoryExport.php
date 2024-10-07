<?php

namespace App\Exports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InventoryExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Inventory::with(['unit', 'supplier', 'department'])
            ->get()
            ->map(function ($inventory) {
                return [
                    'Unique Tag' => $inventory->unique_tag,
                    'Quantity' => $inventory->quantity,
                    'Unit' => $inventory->unit->unit,
                    'Items Specs' => $inventory->items_specs,
                    'Brand' => $inventory->brand,
                    'Unit Price' => $inventory->unit_price,
                    'Supplier' => $inventory->supplier->supplier,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Unique Tag',
            'Quantity',
            'Unit',
            'Items Specs',
            'Brand',
            'Unit Price',
            'Supplier',
        ];
    }
}