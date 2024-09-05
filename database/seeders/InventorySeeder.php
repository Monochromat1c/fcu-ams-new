<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Inventory;
use App\Models\Supplier;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $supplier = Supplier::where('supplier', 'Company X')->first();

        if ($supplier) {
            Inventory::create([
                'stocks' => 15, 
                'unit' => 'Pcs.', 
                'items_specs' => 'Faber-Castell Ballpen', 
                'unit_price' => 50.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'stocks' => 10, 
                'unit' => 'Pcs.', 
                'items_specs' => 'Pilot G-Tec-C4 Gel Ink Pen', 
                'unit_price' => 30.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'stocks' => 5, 
                'unit' => 'Pcs.', 
                'items_specs' => 'Staedtler Noris Pencil', 
                'unit_price' => 20.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'stocks' => 10, 
                'unit' => 'Pcs.', 
                'items_specs' => 'Faber-Castell 9000 Graphite Pencil', 
                'unit_price' => 25.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'stocks' => 15, 
                'unit' => 'Pcs.', 
                'items_specs' => 'Tombow Mono 100 Pencil', 
                'unit_price' => 30.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'stocks' => 5, 
                'unit' => 'Pcs.', 
                'items_specs' => 'Pilot Acroball Pen', 
                'unit_price' => 40.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'stocks' => 5, 
                'unit' => 'Pcs.', 
                'items_specs' => 'Zebra Sarasa Gel Pen', 
                'unit_price' => 35.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'stocks' => 0, 
                'unit' => 'Pcs.', 
                'items_specs' => 'Faber-Castell Pitt Artist Pen', 
                'unit_price' => 45.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'stocks' => 10, 
                'unit' => 'Pcs.', 
                'items_specs' => 'Staedtler Lumocolor Permanent Marker', 
                'unit_price' => 50.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'stocks' => 100, 
                'unit' => 'Pcs.', 
                'items_specs' => 'Tombow ABT Dual Tip Marker', 
                'unit_price' => 40.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'stocks' => 10, 
                'unit' => 'Pcs.', 
                'items_specs' => 'Faber-Castell Polychromos Pencil', 
                'unit_price' => 55.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'stocks' => 100, 
                'unit' => 'Pcs.', 
                'items_specs' => 'Pilot G2 Gel Ink Pen', 
                'unit_price' => 35.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'stocks' => 0, 
                'unit' => 'Pcs.', 
                'items_specs' => 'Zebra F-701 Ballpoint Pen', 
                'unit_price' => 30.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'stocks' => 5, 
                'unit' => 'Pcs.', 
                'items_specs' => 'Staedtler Ergosoft Pencil', 
                'unit_price' => 25.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'stocks' => 0, 
                'unit' => 'Pcs.', 
                'items_specs' => 'Tombow Fudenosuke Brush Pen', 
                'unit_price' => 40.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'stocks' => 100, 
                'unit' => 'Pcs.', 
                'items_specs' => 'Faber-Castell Kneaded Eraser', 
                'unit_price' => 20.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'stocks' => 0, 
                'unit' => 'Pcs.', 
                'items_specs' => 'Pilot FriXion Erasable Pen', 
                'unit_price' => 35.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'stocks' => 100, 
                'unit' => 'Pcs.', 
                'items_specs' => 'Zebra Midliner Highlighter', 
                'unit_price' => 30.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'stocks' => 100, 
                'unit' => 'Pcs.', 
                'items_specs' => 'Staedtler Textsurfer Highlighter', 
                'unit_price' => 25.00, 
                'supplier_id' => $supplier->id,
            ]);

            Inventory::create([
                'stocks' => 0, 
                'unit' => 'Pcs.', 
                'items_specs' => 'Tombow Dual Tip Highlighter', 
                'unit_price' => 40.00, 
                'supplier_id' => $supplier->id,
            ]);
        } else {
            echo "Supplier 'Company X' is required but not found.\n";
        }
    }
}
