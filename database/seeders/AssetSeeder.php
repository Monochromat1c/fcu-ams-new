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
                'specs' => 'HP OMEN Desktop PC with Intel Core i7 processor, 16GB RAM, 1TB SSD, and NVIDIA RTX 3060 graphics card',
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
                'specs' => 'HP OMEN Desktop PC featuring Intel Core i5 processor, 8GB RAM, 512GB SSD, and NVIDIA GTX 1660 Super graphics card',
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
                'condition_id' => 2,
                'status_id' => 2,
                'maintenance_start_date' => $maintenanceStartDate,
                'maintenance_end_date' => $maintenanceEndDate,
            ]);

            // Additional Desktop PCs (FCCPC)
            Asset::create([
                'asset_tag_id' => $this->generateUniqueAssetTag('FCCPC', 3),
                'specs' => 'Dell OptiPlex 7090 Desktop with Intel Core i7-11700 processor, 32GB RAM, 1TB NVMe SSD, and integrated Intel UHD Graphics',
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
                'condition_id' => 2,
                'status_id' => 2,
                'maintenance_start_date' => $maintenanceStartDate,
                'maintenance_end_date' => $maintenanceEndDate,
            ]);

            Asset::create([
                'asset_tag_id' => $this->generateUniqueAssetTag('FCCPC', 4),
                'specs' => 'HP ProDesk 600 G6 Desktop featuring Intel Core i5-10500 processor, 16GB RAM, 512GB SSD, and integrated Intel UHD Graphics',
                'brand_id' => $HP->id,
                'model' => 'ProDesk 600 G6',
                'serial_number' => 'HP600G6X552',
                'cost' => 42800.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 1,
                'department_id' => $casDepartment->id,
                'purchase_date' => '2025-01-18',
                'condition_id' => 2,
                'status_id' => 2,
                'maintenance_start_date' => $maintenanceStartDate,
                'maintenance_end_date' => $maintenanceEndDate,
            ]);

            // Additional Desktop PCs with different configurations
            Asset::create([
                'asset_tag_id' => $this->generateUniqueAssetTag('FCCPC', 5),
                'specs' => 'HP Z4 G4 Workstation powered by Intel Xeon W-2245 processor, 64GB RAM, 2TB NVMe SSD, and NVIDIA Quadro RTX 4000',
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
                'condition_id' => 2,
                'status_id' => 2,
                'maintenance_start_date' => $maintenanceStartDate,
                'maintenance_end_date' => $maintenanceEndDate,
            ]);

            Asset::create([
                'asset_tag_id' => $this->generateUniqueAssetTag('FCCPC', 6),
                'specs' => 'Dell Precision 3660 Workstation with Intel Xeon W-2223 processor, 32GB RAM, 1TB SSD, and NVIDIA RTX A2000',
                'brand_id' => $Dell->id,
                'model' => 'Precision 3660',
                'serial_number' => 'DLL3660X772',
                'cost' => 78500.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 1,
                'department_id' => $casDepartment->id,
                'purchase_date' => '2025-03-05',
                'condition_id' => 2,
                'status_id' => 2,
                'maintenance_start_date' => $maintenanceStartDate,
                'maintenance_end_date' => $maintenanceEndDate,
            ]);

            // Monitors (FCCMO)
            Asset::create([
                'asset_tag_id' => $this->generateUniqueAssetTag('FCCMO', 1),
                'specs' => 'HP EliteDisplay 23.8-inch FHD IPS monitor with 1920x1080 resolution, 60Hz refresh rate, and built-in speakers',
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
                'condition_id' => 2,
                'status_id' => 2,
                'maintenance_start_date' => $maintenanceStartDate,
                'maintenance_end_date' => $maintenanceEndDate,
            ]);

            // Additional Monitors (FCCMO)
            Asset::create([
                'asset_tag_id' => $this->generateUniqueAssetTag('FCCMO', 2),
                'specs' => 'Dell P2419H 24-inch Professional monitor with 1920x1080 resolution, 60Hz refresh rate, and anti-glare coating',
                'brand_id' => $Dell->id,
                'model' => 'P2419H',
                'serial_number' => 'DLL2419H773',
                'cost' => 12500.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 2,
                'department_id' => $ccsDepartment->id,
                'purchase_date' => '2025-02-01',
                'condition_id' => 2,
                'status_id' => 2,
                'maintenance_start_date' => $maintenanceStartDate,
                'maintenance_end_date' => $maintenanceEndDate,
            ]);

            Asset::create([
                'asset_tag_id' => $this->generateUniqueAssetTag('FCCMO', 3),
                'specs' => 'HP Z27n G2 27-inch QHD monitor with 2560x1440 resolution, 60Hz refresh rate, and USB-C connectivity',
                'brand_id' => $HP->id,
                'model' => 'Z27n G2',
                'serial_number' => 'HPZ27G2X884',
                'cost' => 15800.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 2,
                'department_id' => $casDepartment->id,
                'purchase_date' => '2025-02-05',
                'condition_id' => 2,
                'status_id' => 2,
                'maintenance_start_date' => $maintenanceStartDate,
                'maintenance_end_date' => $maintenanceEndDate,
            ]);

            // Additional High-End Monitors
            Asset::create([
                'asset_tag_id' => $this->generateUniqueAssetTag('FCCMO', 4),
                'specs' => 'Dell UltraSharp U3219Q 32-inch 4K monitor with 3840x2160 resolution, HDR support, and USB-C hub functionality',
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
                'specs' => 'HP E27q G4 27-inch QHD monitor with 2560x1440 resolution, 75Hz refresh rate, and integrated USB hub',
                'brand_id' => $HP->id,
                'model' => 'E27q G4',
                'serial_number' => 'HPE27Q4X994',
                'cost' => 28500.00,
                'supplier_id' => 4,
                'site_id' => $site->id,
                'location_id' => $location->id,
                'category_id' => 2,
                'department_id' => $casDepartment->id,
                'purchase_date' => '2025-02-05',
                'condition_id' => 1,
                'status_id' => 1,
            ]);

            // Laptops (FCCLT)
            Asset::create([
                'asset_tag_id' => $this->generateUniqueAssetTag('FCCLT', 1),
                'specs' => 'Dell Alienware laptop with Intel Core i9 processor, 32GB RAM, 1TB NVMe SSD, and NVIDIA RTX 3080 mobile GPU',
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
                'specs' => 'HP ProBook 450 G8 laptop featuring Intel Core i5-1135G7 processor, 16GB RAM, 512GB SSD, and integrated Intel Iris Xe graphics',
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
                'specs' => 'Dell Latitude 5520 laptop with Intel Core i7-1165G7 processor, 16GB RAM, 512GB SSD, and Intel Iris Xe graphics',
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
                'specs' => 'HP ZBook Fury 15 G8 mobile workstation with Intel Xeon W-11955M processor, 64GB RAM, 2TB NVMe SSD, and NVIDIA RTX A5000',
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
                'specs' => 'Dell Precision 5570 mobile workstation featuring Intel Core i9-12900H processor, 32GB RAM, 1TB SSD, and NVIDIA RTX A3000',
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
                'specs' => 'HP Color LaserJet Enterprise printer with automatic duplex printing, 30ppm color/black, and network connectivity',
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
                'specs' => 'HP LaserJet Pro M404dn monochrome printer with 40ppm print speed, automatic duplex printing, and Gigabit Ethernet',
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
                'specs' => 'Canon PIXMA G7070 all-in-one printer with high-yield ink tanks, wireless connectivity, and automatic document feeder',
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
                'specs' => 'HP Color LaserJet Enterprise M555x with 40ppm color printing, 2GB RAM, and advanced security features',
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
                'specs' => 'Canon imageRUNNER 2630i multifunction printer with 30ppm printing, scanning, copying, and advanced document handling',
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
                'specs' => 'Cisco IP Phone with 5-inch display, HD voice, and Power over Ethernet capability',
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
                'specs' => 'Cisco IP Phone 8841 with 5-inch color display, HD audio, and advanced calling features',
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
                'specs' => 'Cisco IP Phone 7821 with 3.5-inch grayscale display, dual Gigabit Ethernet ports, and basic calling features',
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
                'specs' => 'Cisco IP Phone 8861 with 5-inch color display, built-in Bluetooth, Wi-Fi, and USB port for headsets',
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
                'specs' => 'Cisco IP Phone 8845 with 5-inch color display, 720p HD video calling, and advanced telephony features',
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
