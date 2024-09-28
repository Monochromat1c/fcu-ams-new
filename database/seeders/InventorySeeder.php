<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Inventory;
use App\Models\Supplier;
use App\Models\Unit;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $supplier = Supplier::where('supplier', 'Company X')->first();
        $units = Unit::all();

        if ($supplier) {
            Inventory::create([
                'quantity' => 15, 
                'unit_id' => 2, 
                'items_specs' => 'Ballpen', 
                'brand' => 'Faber-Castell',
                'unit_price' => 50.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'quantity' => 10, 
                'unit_id' => 2, 
                'items_specs' => 'G-Tec-C4 Gel Ink Pen',
                'brand' => 'Pilot',
                'unit_price' => 30.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'quantity' => 5, 
                'unit_id' => 2, 
                'items_specs' => 'Pencil', 
                'brand' => 'Staedtler Noris',
                'unit_price' => 20.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'quantity' => 10, 
                'unit_id' => 2, 
                'items_specs' => '9000 Graphite Pencil', 
                'brand' => 'Faber-Castell',
                'unit_price' => 25.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'quantity' => 15, 
                'unit_id' => 2, 
                'items_specs' => 'Mono 100 Pencil', 
                'brand' => 'Tombow',
                'unit_price' => 30.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'quantity' => 5, 
                'unit_id' => 2, 
                'items_specs' => 'Acroball Pen', 
                'brand' => 'Pilot',
                'unit_price' => 40.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'quantity' => 5, 
                'unit_id' => 2, 
                'items_specs' => 'Sarasa Gel Pen', 
                'brand' => 'Zebra',
                'unit_price' => 35.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'quantity' => 0, 
                'unit_id' => 2, 
                'items_specs' => 'Pitt Artist Pen', 
                'brand' => 'Faber-Castell',
                'unit_price' => 45.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'quantity' => 10, 
                'unit_id' => 2, 
                'items_specs' => 'Lumocolor Permanent Marker', 
                'brand' => 'Staedtler',
                'unit_price' => 50.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'quantity' => 100, 
                'unit_id' => 2, 
                'items_specs' => 'ABT Dual Tip Marker', 
                'brand' => 'Tombow',
                'unit_price' => 40.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'quantity' => 10, 
                'unit_id' => 2, 
                'items_specs' => 'Polychromos Pencil', 
                'brand' => 'Faber-Castell',
                'unit_price' => 55.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'quantity' => 100, 
                'unit_id' => 2, 
                'items_specs' => 'G2 Gel Ink Pen', 
                'brand' => 'Pilot',
                'unit_price' => 35.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'quantity' => 0, 
                'unit_id' => 2, 
                'items_specs' => 'F-701 Ballpoint Pen', 
                'brand' => 'Zebra',
                'unit_price' => 30.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'quantity' => 5, 
                'unit_id' => 2, 
                'items_specs' => 'Ergosoft Pencil', 
                'brand' => 'Staedtler',
                'unit_price' => 25.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'quantity' => 0, 
                'unit_id' => 2, 
                'items_specs' => 'Fudenosuke Brush Pen', 
                'brand' => 'Tombow',
                'unit_price' => 40.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'quantity' => 100, 
                'unit_id' => 2, 
                'items_specs' => 'Kneaded Eraser', 
                'brand' => 'Faber-Castell',
                'unit_price' => 20.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'quantity' => 0, 
                'unit_id' => 2, 
                'items_specs' => 'FriXion Erasable Pen', 
                'brand' => 'Pilot',
                'unit_price' => 35.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'quantity' => 100, 
                'unit_id' => 2, 
                'items_specs' => 'Midliner Highlighter', 
                'brand' => 'Zebra',
                'unit_price' => 30.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'quantity' => 100, 
                'unit_id' => 2, 
                'items_specs' => 'Textsurfer Highlighter', 
                'brand' => 'Staedtler',
                'unit_price' => 25.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'quantity' => 0, 
                'unit_id' => 2, 
                'items_specs' => 'Dual Tip Highlighter', 
                'brand' => 'Tombow',
                'unit_price' => 40.00, 
                'supplier_id' => $supplier->id,
            ]);
        } else {
            echo "Supplier 'Company X' is required but not found.\n";
        }
    }
}
