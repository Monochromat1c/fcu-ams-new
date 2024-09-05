<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier;
use App\Models\Site;
use App\Models\Location;
use App\Models\Category;
use App\Models\Department;

class ForeignRelatedTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Seed Supplier
        Supplier::create([
            'supplier' => 'Company X',
        ]);

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

    }
}
