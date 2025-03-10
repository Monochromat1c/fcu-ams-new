<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ConditionSeeder::class,
            RoleSeeder::class,
            ForeignRelatedTablesSeeder::class,
            AssetSeeder::class,
            InventorySeeder::class,
            DefaultUserSeeder::class,
        ]);
    }
}
