<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $conditions = ['New', 'Maintenance', 'Repaired', 'To Be Disposed'];

        foreach ($conditions as $condition) {
            DB::table('conditions')->insert([
                'condition' => $condition,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}