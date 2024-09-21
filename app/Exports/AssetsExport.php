<?php

namespace App\Exports;

use App\Models\Asset;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AssetsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Asset::with(['supplier', 'site', 'location', 'category', 'department', 'condition'])
            ->get()
            ->map(function ($asset) {
                return [
                    'Asset Name' => $asset->asset_name,
                    'Brand' => $asset->brand,
                    'Model' => $asset->model,
                    'Serial Number' => $asset->serial_number,
                    'Cost' => $asset->cost,
                    'Supplier' => $asset->supplier->supplier,
                    'Site' => $asset->site->site,
                    'Location' => $asset->location->location,
                    'Category' => $asset->category->category,
                    'Department' => $asset->department->department,
                    'Purchase Date' => $asset->purchase_date,
                    'Condition' => $asset->condition->condition,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Asset Name',
            'Brand',
            'Model',
            'Serial Number',
            'Cost',
            'Supplier',
            'Site',
            'Location',
            'Category',
            'Department',
            'Purchase Date',
            'Condition',
        ];
    }
}
