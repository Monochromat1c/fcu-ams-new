<?php

namespace App\Exports;

use App\Models\Asset;
use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\WithHeadings;

// class AssetsExport implements FromCollection, WithHeadings
class AssetsExport implements FromCollection
{
    public function collection()
    {
        return Asset::all();
    }
    // public function collection()
    // {
    //     return Asset::select([
    //         'id',
    //         'asset_name',
    //         'brand',
    //         'model',
    //         'serial_number',
    //         'cost',
    //         'supplier',
    //         'site',
    //         'location',
    //         'category',
    //         'department',
    //         'purchase_date',
    //         'condition',
    //     ])->get();
    // }


    // public function headings(): array
    // {
    //     return [
    //         'id',
    //         'asset_name',
    //         'brand',
    //         'model',
    //         'serial_number',
    //         'cost',
    //         'supplier',
    //         'site',
    //         'location',
    //         'category',
    //         'department',
    //         'purchase_date',
    //         'condition',
    //     ];
    // }
}
