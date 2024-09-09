<?php

namespace App\Imports;

use App\Models\Asset;
use App\Models\Supplier;
use App\Models\Site;
use App\Models\Location;
use App\Models\Category;
use App\Models\Department;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;

class AssetsImport implements ToModel, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    use Importable;

    public function model(array $row)
    {
        $supplier = Supplier::where('supplier', $row['Supplier'])->first();
        $site = Site::where('site', $row['Site'])->first();
        $location = Location::where('location', $row['Location'])->first();
        $category = Category::where('category', $row['Category'])->first();
        $department = Department::where('department', $row['Department'])->first();

        return new Asset([
            'asset_name' => $row['Asset Name'],
            'brand' => $row['Brand'],
            'model' => $row['Model'],
            'serial_number' => $row['Serial Number'],
            'cost' => $row['Cost'],
            'supplier_id' => $supplier->id,
            'site_id' => $site->id,
            'location_id' => $location->id,
            'category_id' => $category->id,
            'department_id' => $department->id,
            'purchase_date' => $row['Purchase Date'],
            'condition' => $row['Condition'],
        ]);
    }

    public function rules(): array
    {
        return [
            '*.Asset Name' => [
                'required',
                'string',
                Rule::unique('assets', 'asset_name')->whereNull('deleted_at'),
            ],
            '*.Brand' => 'required|string',
            '*.Model' => 'required|string',
            '*.Serial Number' => 'required|string',
            '*.Cost' => 'required|numeric',
            '*.Supplier' => 'required|exists:suppliers,supplier',
            '*.Site' => 'required|exists:sites,site',
            '*.Location' => 'required|exists:locations,location',
            '*.Category' => 'required|exists:categories,category',
            '*.Department' => 'required|exists:departments,department',
            '*.Purchase Date' => 'required|date',
            '*.Condition' => 'nullable|string', 
        ];
    }
}