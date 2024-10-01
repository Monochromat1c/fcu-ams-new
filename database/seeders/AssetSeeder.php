<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Asset;
use App\Models\Supplier;
use App\Models\Site;
use App\Models\Location;
use App\Models\Category;
use App\Models\Department;
use App\Models\Condition;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $supplier = Supplier::where('supplier', 'Company X')->first();
        $site = Site::where('site', 'Main Campus')->first();
        $location = Location::where('location', 'Roxas City')->first();
        $category = Category::where('category', 'Equipment')->first();
        $category2 = Category::where('category', 'Vehicles')->first();
        $department = Department::where('department', 'CCS Department')->first();
        $conditions = Condition::all();

        if ($supplier && $site && $location && $category && $department) {
            Asset::create([
                'asset_name' => 'Asus Zephyr 2020 Edition',
                'brand' => 'Asus',
                'model' => 'Zephyr',
                'serial_number' => 'SN123456',
                'cost' => 34499.00,
                'supplier_id' => $supplier->id,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => $category->id,
                'department_id' => $department->id,
                'purchase_date' => '2024-07-18',
                'condition_id' => 1,
            ]);
        } else {
            echo "Some required records are missing.\n";
        }
        
        if ($supplier && $site && $location && $category && $department) {
            Asset::create([
                'asset_name' => 'Asus Zephyr',
                'brand' => 'Asus',
                'model' => 'Zephyr',
                'serial_number' => 'SN395456',
                'cost' => 24999.00,
                'supplier_id' => $supplier->id,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => $category->id,
                'department_id' => $department->id,
                'purchase_date' => '2024-07-18',
                'condition_id' => 1,
            ]);
        } else {
            echo "Some required records are missing.\n";
        }

        if ($supplier && $site && $location && $category2 && $department) {
            Asset::create([
                'asset_name' => 'NMAX 155',
                'brand' => 'Yamaha',
                'model' => 'NMAX',
                'serial_number' => 'FD396456',
                'cost' => 151900.00,
                'supplier_id' => $supplier->id,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => $category2->id,
                'department_id' => $department->id,
                'purchase_date' => '2024-07-18',
                'condition_id' => 1,
            ]);
        } else {
            echo "Some required records are missing.\n";
        }

        if ($supplier && $site && $location && $category && $category2 && $department) {
        Asset::create([
            'asset_name' => 'Laptop 1',
            'brand' => 'Dell',
            'model' => 'Inspiron 15',
            'serial_number' => 'ABC123456',
            'cost' => 35000.00,
            'supplier_id' => $supplier->id,
            'site_id' => $site->id,
            'location_id' => $location->id,
            'category_id' => $category->id,
            'department_id' => $department->id,
            'purchase_date' => '2024-07-18',
            'condition_id' => 1,
        ]);

        Asset::create([
            'asset_name' => 'Printer 1',
            'brand' => 'HP',
            'model' => 'LaserJet 1020',
            'serial_number' => 'XYZ789012',
            'cost' => 15000.00,
            'supplier_id' => $supplier->id,
            'site_id' => $site->id,
            'location_id' => $location->id,
            'category_id' => $category->id,
            'department_id' => $department->id,
            'purchase_date' => '2024-07-18',
            'condition_id' => 1,
        ]);

        Asset::create([
            'asset_name' => 'Projector 1',
            'brand' => 'Epson',
            'model' => 'PowerLite 2155',
            'serial_number' => 'DEF456789',
            'cost' => 40000.00,
            'supplier_id' => $supplier->id,
            'site_id' => $site->id,
            'location_id' => $location->id,
            'category_id' => $category->id,
            'department_id' => $department->id,
            'purchase_date' => '2024-07-18',
            'condition_id' => 1,
        ]);

        Asset::create([
            'asset_name' => 'Van 1',
            'brand' => 'Toyota',
            'model' => 'Hiace',
            'serial_number' => 'GHI012345',
            'cost' => 800000.00,
            'supplier_id' => $supplier->id,
            'site_id' => $site->id,
            'location_id' => $location->id,
            'category_id' => $category2->id,
            'department_id' => $department->id,
            'purchase_date' => '2024-07-18',
            'condition_id' => 1,
        ]);

        Asset::create([
            'asset_name' => 'Truck 1',
            'brand' => 'Isuzu',
            'model' => 'Elf',
            'serial_number' => 'JKL678901',
            'cost' => 1200000.00,
            'supplier_id' => $supplier->id,
            'site_id' => $site->id,
            'location_id' => $location->id,
            'category_id' => $category2->id,
            'department_id' => $department->id,
            'purchase_date' => '2024-07-18',
            'condition_id' => 1,
        ]);

        Asset::create([
            'asset_name' => 'Motorcycle 1',
            'brand' => 'Honda',
            'model' => 'XRM',
            'serial_number' => 'MNO234567',
            'cost' => 80000.00,
            'supplier_id' => $supplier->id,
            'site_id' => $site->id,
            'location_id' => $location->id,
            'category_id' => $category2->id,
            'department_id' => $department->id,
            'purchase_date' => '2024-07-18',
            'condition_id' => 1,
        ]);

        Asset::create([
            'asset_name' => 'Bicycle 1',
            'brand' => 'Trek',
            'model' => 'Mountain Bike',
            'serial_number' => 'PQR345678',
            'cost' => 30000.00,
            'supplier_id' => $supplier->id,
            'site_id' => $site->id,
            'location_id' => $location->id,
            'category_id' => $category->id,
            'department_id' => $department->id,
            'purchase_date' => '2024-07-18',
            'condition_id' => 1,
        ]);

        Asset::create([
            'asset_name' => 'Generator 1',
            'brand' => 'Kipor',
            'model' => 'KG 2000',
            'serial_number' => 'STU901234',
            'cost' => 50000.00,
            'supplier_id' => $supplier->id,
            'site_id' => $site->id,
            'location_id' => $location->id,
            'category_id' => $category->id,
            'department_id' => $department->id,
            'purchase_date' => now(),
            'condition_id' => 1,
        ]);

        Asset::create([
            'asset_name' => 'Air Conditioner 1',
            'brand' => 'LG',
            'model' => 'Inverter',
            'serial_number' => 'VWX567890',
            'cost' => 60000.00,
            'supplier_id' => $supplier->id,
            'site_id' => $site->id,
            'location_id' => $location->id,
            'category_id' => $category->id,
            'department_id' => $department->id,
            'purchase_date' => '2024-07-18',
            'condition_id' => 1,
        ]);

        Asset::create([
            'asset_name' => 'Refrigerator 1',
            'brand' => 'Samsung',
            'model' => 'French Door',
            'serial_number' => 'YZA123456',
            'cost' => 80000.00,
            'supplier_id' => $supplier->id,
            'site_id' => $site->id,
            'location_id' => $location->id,
            'category_id' => $category->id,
            'department_id' => $department->id,
            'purchase_date' => '2024-06-18',
            'condition_id' => 1,
        ]);

        Asset::create([
            'asset_name' => 'Washing Machine 1',
            'brand' => 'Whirlpool',
            'model' => 'Front Load',
            'serial_number' => 'BCD789012',
            'cost' => 40000.00,
            'supplier_id' => $supplier->id,
            'site_id' => $site->id,
            'location_id' => $location->id,
            'category_id' => $category->id,
            'department_id' => $department->id,
            'purchase_date' => now(),
            'condition_id' => 1,
        ]);

        Asset::create([
            'asset_name' => 'Dryer 1',
            'brand' => 'LG',
            'model' => 'Inverter',
            'serial_number' => 'EFG456789',
            'cost' => 50000.00,
            'supplier_id' => $supplier->id,
            'site_id' => $site->id,
            'location_id' => $location->id,
            'category_id' => $category->id,
            'department_id' => $department->id,
            'purchase_date' => now(),
            'condition_id' => 1,
        ]);

        Asset::create([
            'asset_name' => 'Microwave 1',
            'brand' => 'Panasonic',
            'model' => 'Inverter',
            'serial_number' => 'HIJ012345',
            'cost' => 30000.00,
            'supplier_id' => $supplier->id,
            'site_id' => $site->id,
            'location_id' => $location->id,
            'category_id' => $category->id,
            'department_id' => $department->id,
            'purchase_date' => now(),
            'condition_id' => 1,
        ]);

        Asset::create([
            'asset_name' => 'Toaster 1',
            'brand' => 'Black+Decker',
            'model' => '4-Slice',
            'serial_number' => 'KLM678901',
            'cost' => 20000.00,
            'supplier_id' => $supplier->id,
            'site_id' => $site->id,
            'location_id' => $location->id,
            'category_id' => $category->id,
            'department_id' => $department->id,
            'purchase_date' => now(),
            'condition_id' => 3,
        ]);

        Asset::create([
            'asset_name' => 'Blender 1',
            'brand' => 'Philips',
            'model' => 'Hand Blender',
            'serial_number' => 'NOP234567',
            'cost' => 25000.00,
            'supplier_id' => $supplier->id,
            'site_id' => $site->id,
            'location_id' => $location->id,
            'category_id' => $category->id,
            'department_id' => $department->id,
            'purchase_date' => now(),
            'condition_id' => 3,
        ]);

        Asset::create([
            'asset_name' => 'Stand Fan 1',
            'brand' => 'KDK',
            'model' => '16-Inch',
            'serial_number' => 'QRS345678',
            'cost' => 15000.00,
            'supplier_id' => $supplier->id,
            'site_id' => $site->id,
            'location_id' => $location->id,
            'category_id' => $category->id,
            'department_id' => $department->id,
            'purchase_date' => now(),
            'condition_id' => 3,
        ]);

        Asset::create([
            'asset_name' => 'Ceiling Fan 1',
            'brand' => 'Hunter',
            'model' => '52-Inch',
            'serial_number' => 'TUV678901',
            'cost' => 40000.00,
            'supplier_id' => $supplier->id,
            'site_id' => $site->id,
            'location_id' => $location->id,
            'category_id' => $category->id,
            'department_id' => $department->id,
            'purchase_date' => now(),
            'condition_id' => 3,
        ]);

        Asset::create([
            'asset_name' => 'Water Dispenser 1',
            'brand' => 'Aquasana',
            'model' => 'Hot and Cold',
            'serial_number' => 'WXY012345',
            'cost' => 60000.00,
            'supplier_id' => $supplier->id,
            'site_id' => $site->id,
            'location_id' => $location->id,
            'category_id' => $category->id,
            'department_id' => $department->id,
            'purchase_date' => now(),
            'condition_id' => 3,
        ]);

        Asset::create([
            'asset_name' => 'Water Purifier 1',
            'brand' => 'Brita',
            'model' => 'Longlast',
            'serial_number' => 'ZAB234567',
            'cost' => 80000.00,
            'supplier_id' => $supplier->id,
            'site_id' => $site->id,
            'location_id' => $location->id,
            'category_id' => $category->id,
            'department_id' => $department->id,
            'purchase_date' => now(),
            'condition_id' => 3,
        ]);
    } else {
        echo "Some required records are missing.\n";
    }
    }
}
