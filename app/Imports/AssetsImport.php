<?php

namespace App\Imports;

use App\Models\Asset;
use Maatwebsite\Excel\Concerns\ToModel;

class AssetsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Asset([
            'asset_name' => $row[2],
            'brand' => $row[3],
            'model' => $row[4],
            'serial_number' => $row[5],
            'cost' => $row[6],
            'supplier' => $row[7],
            'site' => $row[8],
            'location' => $row[9],
            'category' => $row[10],
            'department' => $row[11],
            'purchase_date' => $row[12],
            'condition' => $row[13],
        ]);
    }
}
