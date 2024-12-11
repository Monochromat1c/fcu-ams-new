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
        return Asset::with(['supplier', 'site', 'location', 'category', 'department', 'status','condition'])
            ->get()
            ->map(function ($asset) {
                return [
                    'Asset Tag ID' => $asset->asset_tag_id,
                    'Specification' => $asset->specs,
                    'Brand' => $asset->brand->brand,
                    'Model' => $asset->model,
                    'Serial Number' => $asset->serial_number,
                    'Category' => $asset->category->category,
                    'Site' => $asset->site->site,
                    'Location' => $asset->location->location,
                    'Department' => $asset->department->department,
                    'Cost' => $asset->cost,
                    'Supplier' => $asset->supplier->supplier,
                    'Purchase Date' => $asset->purchase_date,
                    'Status' => $asset->status->status,
                    'Condition' => $asset->condition->condition,
                    'Assigned To' => $asset->assigned_to ?? 'Not Assigned',
                    'Date Issued' => $asset->issued_date ?? 'Not Set',
                    'Notes' => $asset->notes ?? 'No notes available',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Asset Tag ID',
            'Specification',
            'Brand',
            'Model',
            'Serial Number',
            'Category',
            'Site',
            'Location',
            'Department',
            'Cost',
            'Supplier',
            'Purchase Date',
            'Status',
            'Condition',
            'Assigned To',
            'Date Issued',
            'Notes',
        ];
    }
}
