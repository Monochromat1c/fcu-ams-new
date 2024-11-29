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
use App\Models\Status;
use App\Models\Brand;
use Carbon\Carbon;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $supplier = Supplier::all();
        $site = Site::where('site', 'Annex Campus')->first();
        $location = Location::where('location', 'Roxas City')->first();
        $category = Category::all();
        $ccsDepartment = Department::where('department', 'CCS Department')->first();
        $casDepartment = Department::where('department', 'CAS Department')->first();
        $conditions = Condition::all();
        $status = Status::all();
        $Canon = Brand::where('brand', 'Canon')->first();
        $FaberCastell = Brand::where('brand', 'Faber-Castell')->first();
        $Pilot = Brand::where('brand', 'Pilot')->first();
        $Staedtler = Brand::where('brand', 'Staedtler')->first();
        $StaedtlerNoris = Brand::where('brand', 'Staedtler Noris')->first();
        $Tombow = Brand::where('brand', 'Tombow')->first();
        $Zebra = Brand::where('brand', 'Zebra')->first();
        $HP = Brand::where('brand', 'HP')->first();
        $Dell = Brand::where('brand', 'Dell')->first();
        $Cisco = Brand::where('brand', 'Cisco')->first();
        $maintenanceStartDate = Carbon::now()->subDays(rand(30, 365)); 
        $maintenanceEndDate = Carbon::now()->subDays(rand(1, 29)); 

        if ($supplier && $site && $location && $category && $ccsDepartment) {
            Asset::create([
                'asset_tag_id' => 'FCCPC001',
                'specs' => 'Desktop',
                'brand_id' => $HP->id,
                'model' => 'HP OMEN',
                'serial_number' => '4CE8061CQG',
                'cost' => 12350.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 1,
                'department_id' => $ccsDepartment->id,
                'purchase_date' => '2022-01-24',
                'condition_id' => 2,
                'status_id' => 2,
                'maintenance_start_date' => $maintenanceStartDate,
                'maintenance_end_date' => $maintenanceEndDate,
            ]);
        
            Asset::create([
                'asset_tag_id' => 'FCCPC002',
                'specs' => 'Desktop',
                'brand_id' => $HP->id,
                'model' => 'HP OMEN',
                'serial_number' => 'CZC7139K48',
                'cost' => 11425.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 1,
                'department_id' => $ccsDepartment->id,
                'purchase_date' => '2023-01-24',
                'condition_id' => 1,
                'status_id' => 1,
            ]);
        
            Asset::create([
                'asset_tag_id' => 'FCCPC003',
                'specs' => 'Desktop',
                'brand_id' => $HP->id,
                'model' => 'HP OMEN',
                'serial_number' => 'CZC7139K4B',
                'cost' => 11425.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 1,
                'department_id' => $ccsDepartment->id,
                'purchase_date' => '2022-01-24',
                'condition_id' => 1,
                'status_id' => 1,
            ]);
        
            Asset::create([
                'asset_tag_id' => 'FCCPC004',
                'specs' => 'Desktop',
                'brand_id' => $HP->id,
                'model' => 'HP OMEN',
                'serial_number' => '4CE80966NT',
                'cost' => 10224.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 1,
                'department_id' => $casDepartment->id,
                'purchase_date' => '2024-01-24',
                'condition_id' => 2,
                'status_id' => 2,
                'maintenance_start_date' => $maintenanceStartDate,
                'maintenance_end_date' => $maintenanceEndDate,
            ]);
        
            Asset::create([
                'asset_tag_id' => 'FCCPC005',
                'specs' => 'Desktop',
                'brand_id' => $HP->id,
                'model' => 'HP OMEN',
                'serial_number' => '4CE8061CP0',
                'cost' => 10224.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 1,
                'department_id' => $casDepartment->id,
                'purchase_date' => '2023-02-24',
                'condition_id' => 2,
                'status_id' => 2,
                'maintenance_start_date' => $maintenanceStartDate,
                'maintenance_end_date' => $maintenanceEndDate,
            ]);
        
            Asset::create([
                'asset_tag_id' => 'FCCPC006',
                'specs' => 'Desktop',
                'brand_id' => $HP->id,
                'model' => 'HP OMEN',
                'serial_number' => '4CE8061CPG',
                'cost' => 10224.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 1,
                'department_id' => $casDepartment->id,
                'purchase_date' => '2024-01-24',
                'condition_id' => 1,
                'status_id' => 1,
            ]);
        
            Asset::create([
                'asset_tag_id' => 'FCCPC007',
                'specs' => 'Desktop',
                'brand_id' => $HP->id,
                'model' => 'HP OMEN',
                'serial_number' => 'CZC7139K0W',
                'cost' => 11425.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 1,
                'department_id' => $casDepartment->id,
                'purchase_date' => '2022-01-24',
                'condition_id' => 2,
                'status_id' => 2,
                'maintenance_start_date' => $maintenanceStartDate,
                'maintenance_end_date' => $maintenanceEndDate,
            ]);

            Asset::create([
                'asset_tag_id' => 'FCCMO001',
                'specs' => 'Monitor',
                'brand_id' => $HP->id,
                'model' => 'HP EliteDisplay',
                'serial_number' => 'CNC634P8KD',
                'cost' => 3859.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 2,
                'department_id' => $casDepartment->id,
                'purchase_date' => '2024-02-17',
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            Asset::create([
                'asset_tag_id' => 'FCCMO002',
                'specs' => 'Monitor',
                'brand_id' => $HP->id,
                'model' => 'HP EliteDisplay',
                'serial_number' => 'CNC801NT2X',
                'cost' => 4680.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 2,
                'department_id' => $casDepartment->id,
                'purchase_date' => '2024-02-17',
                'condition_id' => 2,
                'status_id' => 2,
                'maintenance_start_date' => $maintenanceStartDate,
                'maintenance_end_date' => $maintenanceEndDate,
            ]);

            Asset::create([
                'asset_tag_id' => 'FCCMO003',
                'specs' => 'Monitor',
                'brand_id' => $HP->id,
                'model' => 'HP EliteDisplay',
                'serial_number' => 'CNC72816TB',
                'cost' => 4680.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 2,
                'department_id' => $casDepartment->id,
                'purchase_date' => '2024-02-17',
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            Asset::create([
                'asset_tag_id' => 'FCCMO004',
                'specs' => 'Monitor',
                'brand_id' => $HP->id,
                'model' => 'HP EliteDisplay',
                'serial_number' => 'CNC72816VF',
                'cost' => 3859.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 2,
                'department_id' => $casDepartment->id,
                'purchase_date' => '2024-02-17',
                'condition_id' => 2,
                'status_id' => 2,
                'maintenance_start_date' => $maintenanceStartDate,
                'maintenance_end_date' => $maintenanceEndDate,
            ]);

            Asset::create([
                'asset_tag_id' => 'FCCMO005',
                'specs' => 'Monitor',
                'brand_id' => $HP->id,
                'model' => 'HP EliteDisplay',
                'serial_number' => 'CNC801NT1L',
                'cost' => 3859.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 2,
                'department_id' => $ccsDepartment->id,
                'purchase_date' => '2024-02-17',
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            Asset::create([
                'asset_tag_id' => 'FCCMO006',
                'specs' => 'Monitor',
                'brand_id' => $HP->id,
                'model' => 'HP EliteDisplay',
                'serial_number' => 'CNC634PDVV',
                'cost' => 3859.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 2,
                'department_id' => $ccsDepartment->id,
                'purchase_date' => '2024-02-17',
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            Asset::create([
                'asset_tag_id' => 'FCCMO007',
                'specs' => 'Monitor',
                'brand_id' => $HP->id,
                'model' => 'HP EliteDisplay',
                'serial_number' => 'CNC540NZWL',
                'cost' => 4680.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 2,
                'department_id' => $ccsDepartment->id,
                'purchase_date' => '2024-02-17',
                'condition_id' => 2,
                'status_id' => 2,
                'maintenance_start_date' => $maintenanceStartDate,
                'maintenance_end_date' => $maintenanceEndDate,
            ]);

            Asset::create([
                'asset_tag_id' => 'FCCLT001',
                'specs' => 'Laptop',
                'brand_id' => $Dell->id,
                'model' => 'Alienware',
                'serial_number' => '8C2W533',
                'cost' => 125520.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 3,
                'department_id' => $ccsDepartment->id,
                'purchase_date' => '2024-03-17',
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            Asset::create([
                'asset_tag_id' => 'FCCLT002',
                'specs' => 'Laptop',
                'brand_id' => $Dell->id,
                'model' => 'Alienware',
                'serial_number' => 'BVCX533',
                'cost' => 125520.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 3,
                'department_id' => $ccsDepartment->id,
                'purchase_date' => '2024-03-17',
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            Asset::create([
                'asset_tag_id' => 'FCCLT003',
                'specs' => 'Laptop',
                'brand_id' => $Dell->id,
                'model' => 'Alienware',
                'serial_number' => '9B2W533',
                'cost' => 125520.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 3,
                'department_id' => $ccsDepartment->id,
                'purchase_date' => '2024-04-17',
                'condition_id' => 2,
                'status_id' => 2,
                'maintenance_start_date' => $maintenanceStartDate,
                'maintenance_end_date' => $maintenanceEndDate,
            ]);

            Asset::create([
                'asset_tag_id' => 'FCCLT004',
                'specs' => 'Laptop',
                'brand_id' => $Dell->id,
                'model' => 'Alienware',
                'serial_number' => '66M1633',
                'cost' => 110872.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 3,
                'department_id' => $ccsDepartment->id,
                'purchase_date' => '2024-04-17',
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            Asset::create([
                'asset_tag_id' => 'FCCLT005',
                'specs' => 'Laptop',
                'brand_id' => $Dell->id,
                'model' => 'Alienware',
                'serial_number' => '6A693415Q',
                'cost' => 110872.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 3,
                'department_id' => $ccsDepartment->id,
                'purchase_date' => '2024-05-17',
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            Asset::create([
                'asset_tag_id' => 'FCCLT006',
                'specs' => 'Laptop',
                'brand_id' => $Dell->id,
                'model' => 'Alienware',
                'serial_number' => 'B90X533',
                'cost' => 110872.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 3,
                'department_id' => $ccsDepartment->id,
                'purchase_date' => '2024-06-17',
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            Asset::create([
                'asset_tag_id' => 'FCCLT007',
                'specs' => 'Laptop',
                'brand_id' => $Dell->id,
                'model' => 'Alienware',
                'serial_number' => '92GW533',
                'cost' => 110872.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 3,
                'department_id' => $ccsDepartment->id,
                'purchase_date' => '2024-06-17',
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            Asset::create([
                'asset_tag_id' => 'FCCPR001',
                'specs' => 'Printer',
                'brand_id' => $HP->id,
                'model' => 'HP Color LaserJet',
                'serial_number' => 'NLBVM8H0LX',
                'cost' => 63299.00,
                'supplier_id' => 5,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 4,
                'department_id' => $ccsDepartment->id,
                'purchase_date' => '2024-07-17',
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            Asset::create([
                'asset_tag_id' => 'FCCPR002',
                'specs' => 'Printer',
                'brand_id' => $HP->id,
                'model' => 'HP Color LaserJet',
                'serial_number' => 'NLBVM8H045',
                'cost' => 63299.00,
                'supplier_id' => 5,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 4,
                'department_id' => $ccsDepartment->id,
                'purchase_date' => '2024-08-17',
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            Asset::create([
                'asset_tag_id' => 'FCCPR003',
                'specs' => 'Printer',
                'brand_id' => $HP->id,
                'model' => 'HP Color LaserJet',
                'serial_number' => 'NLBVM8H08F',
                'cost' => 63299.00,
                'supplier_id' => 5,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 4,
                'department_id' => $ccsDepartment->id,
                'purchase_date' => '2024-08-17',
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            Asset::create([
                'asset_tag_id' => 'FCCPH001',
                'specs' => 'IP Phone',
                'brand_id' => $Cisco->id,
                'model' => 'Cisco IP Phone',
                'serial_number' => '20EZIZCL30229E46',
                'cost' => 14259.00,
                'supplier_id' => 6,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 5,
                'department_id' => $ccsDepartment->id,
                'purchase_date' => '2024-09-17',
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            Asset::create([
                'asset_tag_id' => 'FCCPH002',
                'specs' => 'IP Phone',
                'brand_id' => $Cisco->id,
                'model' => 'Cisco IP Phone',
                'serial_number' => '20EZIZCL30229E49',
                'cost' => 14259.00,
                'supplier_id' => 6,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 5,
                'department_id' => $ccsDepartment->id,
                'purchase_date' => '2024-09-17',
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            Asset::create([
                'asset_tag_id' => 'FCCPH003',
                'specs' => 'IP Phone',
                'brand_id' => $Cisco->id,
                'model' => 'Cisco IP Phone',
                'serial_number' => '20EZIZCL30229E47',
                'cost' => 14259.00,
                'supplier_id' => 6,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 5,
                'department_id' => $ccsDepartment->id,
                'purchase_date' => '2024-10-7',
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            Asset::create([
                'asset_tag_id' => 'FCCPH004',
                'specs' => 'IP Phone',
                'brand_id' => $Cisco->id,
                'model' => 'Cisco IP Phone',
                'serial_number' => '20EZIZCL30229E51',
                'cost' => 14259.00,
                'supplier_id' => 6,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 5,
                'department_id' => $ccsDepartment->id,
                'purchase_date' => '2024-10-15',
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            Asset::create([
                'asset_tag_id' => 'FCCPH005',
                'specs' => 'IP Phone',
                'brand_id' => $Cisco->id,
                'model' => 'Cisco IP Phone',
                'serial_number' => '20EZIZCL30229E3B',
                'cost' => 14259.00,
                'supplier_id' => 6,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 5,
                'department_id' => $ccsDepartment->id,
                'purchase_date' => '2024-10-22',
                'condition_id' => 1,
                'status_id' => 1,
            ]);
        
        } else {
            echo "Some required records are missing.\n";
        }
    }
}
