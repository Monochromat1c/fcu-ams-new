<?php

namespace App\Exports;

use App\Models\Asset;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class AssetExportReport implements FromCollection, WithHeadings, WithMapping
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
        return Asset::with(['supplier', 'brand', 'site', 'location', 'category', 'department', 'condition', 'status'])
            ->whereBetween('purchase_date', [$this->startDate, $this->endDate])
            ->orderBy('asset_tag_id', 'asc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Asset Tag ID',
            'Brand',
            'Model',
            'Specifications',
            'Serial Number',
            'Cost',
            'Supplier',
            'Site',
            'Location',
            'Category',
            'Department',
            'Purchase Date',
            'Status',
            'Condition',
            'Assigned To',
            'Issue Date'
        ];
    }

    public function map($asset): array
    {
        return [
            $asset->asset_tag_id,
            $asset->brand->brand,
            $asset->model,
            $asset->specs,
            $asset->serial_number,
            number_format($asset->cost, 2),
            $asset->supplier->supplier,
            $asset->site->site,
            $asset->location->location,
            $asset->category->category,
            $asset->department->department,
            Carbon::parse($asset->purchase_date)->format('M d, Y'),
            $asset->status->status ?? 'N/A',
            $asset->condition->condition ?? 'N/A',
            $asset->assigned_to ?? 'N/A',
            $asset->issued_date ? Carbon::parse($asset->issued_date)->format('M d, Y') : 'N/A'
        ];
    }
}