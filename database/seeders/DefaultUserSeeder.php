<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::where('role', 'Administrator')->first();

        User::create([
            'first_name' => 'Wealyn',
            'last_name' => 'Yap',
            'address' => 'Abx Xyz, 123',
            'contact_number' => '09123456789',
            'role_id' => $adminRole->id,
            'username' => 'wyap',
            'password' => Hash::make('wyap@'),
            'email' => 'wyap@gmail.com',
            'contact_number' => '1234567890',
        ]);

        User::create([
            'first_name' => 'Wealyn',
            'last_name' => 'Yap',
            'address' => 'Abx Xyz, 123',
            'contact_number' => '09123456789',
            'role_id' => $adminRole->id,
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'email' => 'wyap@gmail.com',
            'contact_number' => '1234567890',
        ]);
    }
}