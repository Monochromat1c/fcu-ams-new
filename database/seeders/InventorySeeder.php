<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Inventory;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\Brand;
use Carbon\Carbon;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $supplier = Supplier::all();
        $units = Unit::all();
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
        $pastMonth = Carbon::now()->subMonth()->startOfMonth();
        $pastPastMonth = Carbon::now()->subMonths(2)->startOfMonth();

        if ($supplier) {
            Inventory::create([
                'quantity' => 15, 
                'unit_id' => 2, 
                'items_specs' => 'Ballpen', 
                'brand_id' => $FaberCastell->id,
                'unit_price' => 50.00, 
                'supplier_id' => 1,
            ]);

            Inventory::create([
                'quantity' => 10, 
                'unit_id' => 2, 
                'items_specs' => 'G-Tec-C4 Gel Ink Pen',
                'brand_id' => $Pilot->id,
                'unit_price' => 30.00, 
                'supplier_id' => 1,
            ]);

            Inventory::create([
                'quantity' => 5, 
                'unit_id' => 2, 
                'items_specs' => 'Pencil', 
                'brand_id' => $StaedtlerNoris->id,
                'unit_price' => 20.00, 
                'supplier_id' => 1,
            ]);

            Inventory::create([
                'quantity' => 10, 
                'unit_id' => 2, 
                'items_specs' => '9000 Graphite Pencil', 
                'brand_id' => $FaberCastell->id,
                'unit_price' => 25.00, 
                'supplier_id' => 1,
            ]);

            Inventory::create([
                'quantity' => 15, 
                'unit_id' => 2, 
                'items_specs' => 'Mono 100 Pencil', 
                'brand_id' => $Tombow->id,
                'unit_price' => 30.00, 
                'supplier_id' => 1,
            ]);

            Inventory::create([
                'quantity' => 5, 
                'unit_id' => 2, 
                'items_specs' => 'Acroball Pen', 
                'brand_id' => $Pilot->id,
                'unit_price' => 40.00, 
                'supplier_id' => 1,
            ]);

            Inventory::create([
                'quantity' => 5, 
                'unit_id' => 2, 
                'items_specs' => 'Sarasa Gel Pen', 
                'brand_id' => $Zebra->id,
                'unit_price' => 35.00, 
                'supplier_id' => 1,
            ]);

            Inventory::create([
                'quantity' => 0, 
                'unit_id' => 2, 
                'items_specs' => 'Pitt Artist Pen', 
                'brand_id' => $FaberCastell->id,
                'unit_price' => 45.00, 
                'supplier_id' => 1,
            ]);

            Inventory::create([
                'quantity' => 10, 
                'unit_id' => 2, 
                'items_specs' => 'Lumocolor Permanent Marker', 
                'brand_id' => $Staedtler->id,
                'unit_price' => 50.00, 
                'supplier_id' => 1,
            ]);

            Inventory::create([
                'quantity' => 100, 
                'unit_id' => 2, 
                'items_specs' => 'ABT Dual Tip Marker', 
                'brand_id' => $Tombow->id,
                'unit_price' => 40.00, 
                'supplier_id' => 1,
            ]);

            Inventory::create([
                'quantity' => 10, 
                'unit_id' => 2, 
                'items_specs' => 'Polychromos Pencil', 
                'brand_id' => $FaberCastell->id,
                'unit_price' => 55.00, 
                'supplier_id' => 1,
            ]);

            Inventory::create([
                'quantity' => 100, 
                'unit_id' => 2, 
                'items_specs' => 'G2 Gel Ink Pen', 
                'brand_id' => $Pilot->id,
                'unit_price' => 35.00, 
                'supplier_id' => 1,
                'created_at' => $pastPastMonth,
            ]);

            Inventory::create([
                'quantity' => 0, 
                'unit_id' => 2, 
                'items_specs' => 'F-701 Ballpoint Pen', 
                'brand_id' => $Zebra->id,
                'unit_price' => 30.00, 
                'supplier_id' => 1,
            ]);

            Inventory::create([
                'quantity' => 5, 
                'unit_id' => 2, 
                'items_specs' => 'Ergosoft Pencil', 
                'brand_id' => $Staedtler->id,
                'unit_price' => 25.00, 
                'supplier_id' => 1,
            ]);

            Inventory::create([
                'quantity' => 1, 
                'unit_id' => 2, 
                'items_specs' => 'Fudenosuke Brush Pen', 
                'brand_id' => $Tombow->id,
                'unit_price' => 40.00, 
                'supplier_id' => 1,
                'created_at' => $pastPastMonth,
            ]);

            Inventory::create([
                'quantity' => 100, 
                'unit_id' => 2, 
                'items_specs' => 'Kneaded Eraser', 
                'brand_id' => $FaberCastell->id,
                'unit_price' => 20.00, 
                'supplier_id' => 1,
            ]);

            Inventory::create([
                'quantity' => 1, 
                'unit_id' => 2, 
                'items_specs' => 'FriXion Erasable Pen', 
                'brand_id' => $Pilot->id,
                'unit_price' => 35.00, 
                'supplier_id' => 1,
                'created_at' => $pastPastMonth,
            ]);

            Inventory::create([
                'quantity' => 100, 
                'unit_id' => 2, 
                'items_specs' => 'Midliner Highlighter', 
                'brand_id' => $Zebra->id,
                'unit_price' => 30.00, 
                'supplier_id' => 1,
            ]);

            Inventory::create([
                'quantity' => 100, 
                'unit_id' => 2, 
                'items_specs' => 'Textsurfer Highlighter', 
                'brand_id' => $Staedtler->id,
                'unit_price' => 25.00, 
                'supplier_id' => 1,
            ]);

            Inventory::create([
                'quantity' => 0, 
                'unit_id' => 2, 
                'items_specs' => 'Dual Tip Highlighter', 
                'brand_id' => $Tombow->id,
                'unit_price' => 40.00, 
                'supplier_id' => 1,
            ]);

            Inventory::create([
                'quantity' => 100, 
                'unit_id' => 1, 
                'items_specs' => 'Bond Paper Long', 
                'brand_id' => $Canon->id,
                'unit_price' => 450.00,
                'supplier_id' => 2,
                'created_at' => $pastMonth,
            ]); 

            Inventory::create([
                'quantity' => 100, 
                'unit_id' => 1, 
                'items_specs' => 'Bond Paper Short', 
                'brand_id' => $Canon->id,
                'unit_price' => 350.00,
                'supplier_id' => 2,
                'created_at' => $pastMonth,
            ]);

        } else {
            echo "Supplier 'Company X' is required but not found.\n";
        }
    }
}
