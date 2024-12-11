<?php

namespace App\Imports;

use App\Models\Asset;
use App\Models\Brand;
use App\Models\Supplier;
use App\Models\Site;
use App\Models\Location;
use App\Models\Category;
use App\Models\Department;
use App\Models\Condition;
use App\Models\Status;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class AssetsImport implements ToCollection, WithHeadingRow, WithValidation
{
    public function collection(Collection $rows)
    {
        DB::beginTransaction();
        try {
            foreach ($rows as $row) {
                // Map the CSV columns to our expected fields
                $mappedRow = [
                    'asset_tag_id' => $row['asset_tag_id'],
                    'brand' => $row['brand'],
                    'model' => $row['model'],
                    'specs' => $row['specification'],  // Changed from specs to specification
                    'serial_number' => $row['serial_number'],
                    'cost' => $row['cost'],
                    'supplier' => $row['supplier'],
                    'site' => $row['site'],
                    'location' => $row['location'],
                    'category' => $row['category'],
                    'department' => $row['department'],
                    'condition' => $row['condition'],
                    'status' => $row['status'],
                    'purchase_date' => Carbon::createFromFormat('d/m/Y', $row['purchase_date'])->format('Y-m-d'),
                    'assigned_to' => $row['assigned_to'] ?? null,
                ];

                $brand = Brand::where('brand', $mappedRow['brand'])->first();
                $supplier = Supplier::where('supplier', $mappedRow['supplier'])->first();
                $site = Site::where('site', $mappedRow['site'])->first();
                $location = Location::where('location', $mappedRow['location'])->first();
                $category = Category::where('category', $mappedRow['category'])->first();
                $department = Department::where('department', $mappedRow['department'])->first();
                $condition = Condition::where('condition', $mappedRow['condition'])->first();
                $status = Status::where('status', $mappedRow['status'])->first();

                if (!$brand || !$supplier || !$site || !$location || !$category || !$department || !$condition || !$status) {
                    throw new \Exception('One or more required relationships not found');
                }

                Asset::create([
                    'asset_tag_id' => $mappedRow['asset_tag_id'],
                    'specs' => $mappedRow['specs'],
                    'brand_id' => $brand->id,
                    'model' => $mappedRow['model'],
                    'serial_number' => $mappedRow['serial_number'],
                    'cost' => $mappedRow['cost'],
                    'supplier_id' => $supplier->id,
                    'site_id' => $site->id,
                    'location_id' => $location->id,
                    'category_id' => $category->id,
                    'department_id' => $department->id,
                    'condition_id' => $condition->id,
                    'status_id' => $status->id,
                    'purchase_date' => $mappedRow['purchase_date'],
                    'assigned_to' => $mappedRow['assigned_to'],
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function rules(): array
    {
        return [
            'asset_tag_id' => [
                'required',
                'string',
                Rule::unique('assets', 'asset_tag_id')->whereNull('deleted_at'),
            ],
            'brand' => 'required|string',
            'model' => 'required|string',
            'specification' => 'nullable|string',  // Changed from specs to specification
            'serial_number' => 'required|string',
            'cost' => 'required|numeric|min:0',
            'supplier' => 'required|string',
            'site' => 'required|string',
            'location' => 'required|string',
            'category' => 'required|string',
            'department' => 'required|string',
            'condition' => 'required|string',
            'status' => 'required|string',
            'purchase_date' => 'required|string',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'asset_tag_id.required' => 'Asset Tag ID is required',
            'asset_tag_id.unique' => 'Asset Tag ID must be unique',
            'brand.required' => 'Brand is required',
            'model.required' => 'Model is required',
            'serial_number.required' => 'Serial Number is required',
            'cost.required' => 'Cost is required',
            'cost.numeric' => 'Cost must be a number',
            'cost.min' => 'Cost must be greater than or equal to 0',
            'supplier.required' => 'Supplier is required',
            'site.required' => 'Site is required',
            'location.required' => 'Location is required',
            'category.required' => 'Category is required',
            'department.required' => 'Department is required',
            'condition.required' => 'Condition is required',
            'status.required' => 'Status is required',
            'purchase_date.required' => 'Purchase Date is required',
        ];
    }
}
