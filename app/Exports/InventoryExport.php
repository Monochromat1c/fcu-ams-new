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
                    'Items Specs' => $inventory->items_specs,
                    'Brand' => $inventory->brand->brand,
                    'Quantity' => $inventory->quantity,
                    'Unit' => $inventory->unit->unit,
                    'Unit Price' => $inventory->unit_price,
                    'Supplier' => $inventory->supplier->supplier,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Unique Tag',
            'Items Specs',
            'Brand',
            'Quantity',
            'Unit',
            'Unit Price',
            'Supplier',
        ];
    }
}