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
        Department::create([
            'department' => 'CCS Department',
        ]);
        
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
