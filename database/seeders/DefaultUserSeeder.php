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
        $profilePicturePath = 'profile/profile.png';

        User::create([
            'first_name' => 'Wealyn',
            'last_name' => 'Yap',
            'address' => 'Abx Xyz, 123',
            'contact_number' => '09123456789',
            'role_id' => $adminRole->id,
            'username' => 'wyap',
            'password' => Hash::make('wyap@'),
            'email' => 'wyap@gmail.com',
        ]);

        User::create([
            'first_name' => 'Admin',
            'last_name' => '01',
            'address' => 'Abx Xyz, 123',
            'contact_number' => '09123456389',
            'role_id' => $adminRole->id,
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'email' => 'admin@gmail.com',
        ]);
    }
}