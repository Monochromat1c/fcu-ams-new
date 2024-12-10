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
     * Generate a unique asset tag based on prefix and index
     */
    private function generateUniqueAssetTag($prefix, $index)
    {
        return $prefix . str_pad($index, 3, '0', STR_PAD_LEFT);
    }

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
            // Desktop PCs (FCCPC)
            Asset::create([
                'asset_tag_id' => $this->generateUniqueAssetTag('FCCPC', 1),
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
                'purchase_date' => Carbon::now(),
                'condition_id' => 2,
                'status_id' => 2,
                'maintenance_start_date' => $maintenanceStartDate,
                'maintenance_end_date' => $maintenanceEndDate,
            ]);

            Asset::create([
                'asset_tag_id' => $this->generateUniqueAssetTag('FCCPC', 2),
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

            // Additional Desktop PCs (FCCPC)
            Asset::create([
                'asset_tag_id' => $this->generateUniqueAssetTag('FCCPC', 3),
                'specs' => 'Desktop',
                'brand_id' => $Dell->id,
                'model' => 'OptiPlex 7090',
                'serial_number' => 'DLL7090X441',
                'cost' => 45350.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 1,
                'department_id' => $ccsDepartment->id,
                'purchase_date' => Carbon::now(),
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            Asset::create([
                'asset_tag_id' => $this->generateUniqueAssetTag('FCCPC', 4),
                'specs' => 'Desktop',
                'brand_id' => $HP->id,
                'model' => 'ProDesk 600 G6',
                'serial_number' => 'HP600G6X552',
                'cost' => 42800.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 1,
                'department_id' => $casDepartment->id,
                'purchase_date' => '2024-01-18',
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            // Additional Desktop PCs with different configurations
            Asset::create([
                'asset_tag_id' => $this->generateUniqueAssetTag('FCCPC', 5),
                'specs' => 'Desktop Workstation',
                'brand_id' => $HP->id,
                'model' => 'Z4 G4',
                'serial_number' => 'HPZ4G4X661',
                'cost' => 85000.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 1,
                'department_id' => $ccsDepartment->id,
                'purchase_date' => Carbon::now(),
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            Asset::create([
                'asset_tag_id' => $this->generateUniqueAssetTag('FCCPC', 6),
                'specs' => 'Desktop',
                'brand_id' => $Dell->id,
                'model' => 'Precision 3660',
                'serial_number' => 'DLL3660X772',
                'cost' => 78500.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 1,
                'department_id' => $casDepartment->id,
                'purchase_date' => '2024-06-05',
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            // Monitors (FCCMO)
            Asset::create([
                'asset_tag_id' => $this->generateUniqueAssetTag('FCCMO', 1),
                'specs' => 'Monitor',
                'brand_id' => $HP->id,
                'model' => 'HP EliteDisplay',
                'serial_number' => 'CNC634P8KD',
                'cost' => 3859.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 2,
                'department_id' => $ccsDepartment->id,
                'purchase_date' => Carbon::now(),
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            // Additional Monitors (FCCMO)
            Asset::create([
                'asset_tag_id' => $this->generateUniqueAssetTag('FCCMO', 2),
                'specs' => 'Monitor 24-inch',
                'brand_id' => $Dell->id,
                'model' => 'P2419H',
                'serial_number' => 'DLL2419H773',
                'cost' => 12500.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 2,
                'department_id' => $ccsDepartment->id,
                'purchase_date' => '2024-02-01',
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            Asset::create([
                'asset_tag_id' => $this->generateUniqueAssetTag('FCCMO', 3),
                'specs' => 'Monitor 27-inch',
                'brand_id' => $HP->id,
                'model' => 'Z27n G2',
                'serial_number' => 'HPZ27G2X884',
                'cost' => 15800.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 2,
                'department_id' => $casDepartment->id,
                'purchase_date' => '2024-02-05',
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            // Additional High-End Monitors
            Asset::create([
                'asset_tag_id' => $this->generateUniqueAssetTag('FCCMO', 4),
                'specs' => 'Monitor 32-inch 4K',
                'brand_id' => $Dell->id,
                'model' => 'UltraSharp U3219Q',
                'serial_number' => 'DLLU3219X883',
                'cost' => 32000.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 2,
                'department_id' => $ccsDepartment->id,
                'purchase_date' => Carbon::now(),
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            Asset::create([
                'asset_tag_id' => $this->generateUniqueAssetTag('FCCMO', 5),
                'specs' => 'Monitor 27-inch QHD',
                'brand_id' => $HP->id,
                'model' => 'E27q G4',
                'serial_number' => 'HPE27Q4X994',
                'cost' => 28500.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 2,
                'department_id' => $casDepartment->id,
                'purchase_date' => '2024-07-05',
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            // Laptops (FCCLT)
            Asset::create([
                'asset_tag_id' => $this->generateUniqueAssetTag('FCCLT', 1),
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
                'purchase_date' => Carbon::now(),
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            // Additional Laptops (FCCLT)
            Asset::create([
                'asset_tag_id' => $this->generateUniqueAssetTag('FCCLT', 2),
                'specs' => 'Laptop',
                'brand_id' => $HP->id,
                'model' => 'ProBook 450 G8',
                'serial_number' => 'HP450G8X995',
                'cost' => 52300.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 3,
                'department_id' => $ccsDepartment->id,
                'purchase_date' => '2024-03-01',
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            Asset::create([
                'asset_tag_id' => $this->generateUniqueAssetTag('FCCLT', 3),
                'specs' => 'Laptop',
                'brand_id' => $Dell->id,
                'model' => 'Latitude 5520',
                'serial_number' => 'DLL5520X116',
                'cost' => 54800.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 3,
                'department_id' => $casDepartment->id,
                'purchase_date' => '2024-03-05',
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            // Additional High-Performance Laptops
            Asset::create([
                'asset_tag_id' => $this->generateUniqueAssetTag('FCCLT', 4),
                'specs' => 'Laptop Workstation',
                'brand_id' => $HP->id,
                'model' => 'ZBook Fury 15 G8',
                'serial_number' => 'HPZBK15X105',
                'cost' => 125000.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 3,
                'department_id' => $ccsDepartment->id,
                'purchase_date' => Carbon::now(),
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            Asset::create([
                'asset_tag_id' => $this->generateUniqueAssetTag('FCCLT', 5),
                'specs' => 'Laptop',
                'brand_id' => $Dell->id,
                'model' => 'Precision 5570',
                'serial_number' => 'DLLP5570X216',
                'cost' => 118000.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 3,
                'department_id' => $casDepartment->id,
                'purchase_date' => '2024-08-05',
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            // Printers (FCCPR)
            Asset::create([
                'asset_tag_id' => $this->generateUniqueAssetTag('FCCPR', 1),
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
                'purchase_date' => Carbon::now(),
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            // Additional Printers (FCCPR)
            Asset::create([
                'asset_tag_id' => $this->generateUniqueAssetTag('FCCPR', 2),
                'specs' => 'Printer',
                'brand_id' => $HP->id,
                'model' => 'LaserJet Pro M404dn',
                'serial_number' => 'HPM404X227',
                'cost' => 22500.00,
                'supplier_id' => 5,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 4,
                'department_id' => $ccsDepartment->id,
                'purchase_date' => '2024-04-01',
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            Asset::create([
                'asset_tag_id' => $this->generateUniqueAssetTag('FCCPR', 3),
                'specs' => 'Printer',
                'brand_id' => $Canon->id,
                'model' => 'PIXMA G7070',
                'serial_number' => 'CNG7070X338',
                'cost' => 18900.00,
                'supplier_id' => 5,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 4,
                'department_id' => $casDepartment->id,
                'purchase_date' => '2024-04-05',
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            // Additional Enterprise Printers
            Asset::create([
                'asset_tag_id' => $this->generateUniqueAssetTag('FCCPR', 4),
                'specs' => 'Enterprise Printer',
                'brand_id' => $HP->id,
                'model' => 'Color LaserJet Enterprise M555x',
                'serial_number' => 'HPM555X327',
                'cost' => 45000.00,
                'supplier_id' => 5,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 4,
                'department_id' => $ccsDepartment->id,
                'purchase_date' => '2024-09-01',
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            Asset::create([
                'asset_tag_id' => $this->generateUniqueAssetTag('FCCPR', 5),
                'specs' => 'Enterprise Printer',
                'brand_id' => $Canon->id,
                'model' => 'imageRUNNER 2630i',
                'serial_number' => 'CNI2630X438',
                'cost' => 52000.00,
                'supplier_id' => 5,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 4,
                'department_id' => $casDepartment->id,
                'purchase_date' => '2024-09-05',
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            // IP Phones (FCCPH)
            Asset::create([
                'asset_tag_id' => $this->generateUniqueAssetTag('FCCPH', 1),
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
                'purchase_date' => Carbon::now(),
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            // Additional IP Phones (FCCPH)
            Asset::create([
                'asset_tag_id' => $this->generateUniqueAssetTag('FCCPH', 2),
                'specs' => 'IP Phone',
                'brand_id' => $Cisco->id,
                'model' => 'IP Phone 8841',
                'serial_number' => 'CSC8841X449',
                'cost' => 12800.00,
                'supplier_id' => 6,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 5,
                'department_id' => $ccsDepartment->id,
                'purchase_date' => '2024-05-01',
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            Asset::create([
                'asset_tag_id' => $this->generateUniqueAssetTag('FCCPH', 3),
                'specs' => 'IP Phone',
                'brand_id' => $Cisco->id,
                'model' => 'IP Phone 7821',
                'serial_number' => 'CSC7821X550',
                'cost' => 9800.00,
                'supplier_id' => 6,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 5,
                'department_id' => $casDepartment->id,
                'purchase_date' => '2024-05-05',
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            // Additional Advanced IP Phones
            Asset::create([
                'asset_tag_id' => $this->generateUniqueAssetTag('FCCPH', 4),
                'specs' => 'Advanced IP Phone',
                'brand_id' => $Cisco->id,
                'model' => 'IP Phone 8861',
                'serial_number' => 'CSC8861X549',
                'cost' => 18500.00,
                'supplier_id' => 6,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 5,
                'department_id' => $ccsDepartment->id,
                'purchase_date' => Carbon::now(),
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            Asset::create([
                'asset_tag_id' => $this->generateUniqueAssetTag('FCCPH', 5),
                'specs' => 'Advanced IP Phone',
                'brand_id' => $Cisco->id,
                'model' => 'IP Phone 8845',
                'serial_number' => 'CSC8845X650',
                'cost' => 16800.00,
                'supplier_id' => 6,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 5,
                'department_id' => $casDepartment->id,
                'purchase_date' => '2024-10-05',
                'condition_id' => 1,
                'status_id' => 1,
            ]);
        }
    }
}
