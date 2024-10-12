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
        $managerRole = Role::where('role', 'Manager')->first();
        $viewerRole = Role::where('role', 'Viewer')->first();

        User::create([
            'profile_picture' => 'profile/light.jpg',
            'first_name' => 'Wealyn',
            'last_name' => 'Yap',
            'address' => 'Roxas City',
            'contact_number' => '09123456789',
            'role_id' => $managerRole->id,
            'username' => 'wyap',
            'password' => Hash::make('wyap@'),
            'email' => 'wyap@gmail.com',
        ]);

        User::create([
            'profile_picture' => 'profile/mele.jpg',
            'first_name' => 'Gimelle Jen',
            'last_name' => 'Galera',
            'address' => 'Roxas City',
            'contact_number' => '09123456389',
            'role_id' => $adminRole->id,
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'email' => 'mele@gmail.com',
        ]);

        User::create([
            'profile_picture' => 'profile/liling.jpg',
            'first_name' => 'Eliza Jane',
            'last_name' => 'Hingco',
            'address' => 'Roxas City',
            'contact_number' => '09123476389',
            'role_id' => $viewerRole->id,
            'username' => 'liling',
            'password' => Hash::make('liling@'),
            'email' => 'liling@gmail.com',
        ]);
    }
}