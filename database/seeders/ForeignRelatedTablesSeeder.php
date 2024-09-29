<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier;
use App\Models\Site;
use App\Models\Location;
use App\Models\Category;
use App\Models\Department;
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
            ['supplier' => 'Company X'],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }

        // Seed Site
        Site::create([
            'site' => 'Main Campus',
        ]);

        // Seed Location
        Location::create([
            'location' => 'Roxas City',
        ]);

        // Seed Category
        Category::create([
            'category' => 'Equipment',
        ]);

        Category::create([
            'category' => 'Vehicles',
        ]);

        // Seed Department
        Department::create([
            'department' => 'CCS Department',
        ]);

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
