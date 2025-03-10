<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier;
use App\Models\Site;
use App\Models\Location;
use App\Models\Category;
use App\Models\Department;
use App\Models\Status;
use App\Models\Unit;
use App\Models\Brand;
use App\Models\Condition;
use App\Models\DisposedStatus;

class ForeignRelatedTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Seed Supplier
        $suppliers = [
            ['supplier' => 'Quality Source Suppliers'],
            ['supplier' => 'Apex Manufacturing Solutions'],
            ['supplier' => 'Precision Supply Co.'],
            ['supplier' => 'PC Express'],
            ['supplier' => 'Asianic Distributors Inc.'],
            ['supplier' => 'Iridium Technologies, Inc.'],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }

        // Brand seeder
        $brands = [
            ['brand' => 'Canon'],
            ['brand' => 'Faber-Castell'],
            ['brand' => 'Pilot'],
            ['brand' => 'Staedtler'],
            ['brand' => 'Staedtler Noris'],
            ['brand' => 'Tombow'],
            ['brand' => 'Zebra'],
            ['brand' => 'HP'],
            ['brand' => 'Dell'],
            ['brand' => 'Cisco'],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }

        // Disposed_status seeder
        $disposed_statuses = [
            ['status' => 'Garbage'],
            ['status' => 'Donated'],
            ['status' => 'Sold'],
        ];

        foreach ($disposed_statuses as $disposed_status) {
            DisposedStatus::create($disposed_status);
        }

        // Seed Site
        $sites = [
            ['site' => 'Annex Campus'],
            ['site' => 'Main Campus'],
        ];
        
        foreach ($sites as $site){
            Site::create($site);
        }

        // Seed Location
        Location::create([
            'location' => 'Roxas City',
        ]);

        // Seed Category
        $categories = [
            ['category' => 'Desktop'],
            ['category' => 'Monitor'],
            ['category' => 'Laptop'],
            ['category' => 'Printer'],
            ['category' => 'Phone'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        };

        // Seed Department
        $departments = [
            ['department' => 'CCS Department'],
            ['department' => 'CAS Department'],
        ];
        
        foreach ($departments as $department){
            Department::create($department);
        }
        
        // Seed Status
        $statuses = [
            ['status' => 'Available'],
            ['status' => 'Unavailable'],
            ['status' => 'Leased'],
        ];

        foreach ($statuses as $status) {
            Status::create($status);
        };

        $units = [
            ['unit' => 'per ream'],
            ['unit' => 'per piece'],
            ['unit' => 'per inch'],
            ['unit' => 'per feet'],
            ['unit' => 'per yard'],
            ['unit' => 'per liter'],
            ['unit' => 'per milliliter'],
            ['unit' => 'per gallon'],
            ['unit' => 'per ounce'],
            ['unit' => 'per dozen'],
            ['unit' => 'per pack'],
            ['unit' => 'per box'],
        ];

        foreach ($units as $unit) {
            Unit::create($unit);
        }
    }
}
