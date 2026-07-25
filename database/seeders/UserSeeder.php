<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Pastikan model User di-import

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Admin Pusat
        User::create([
            'name' => 'Admin Pusat Pocari',
            'email' => 'pusat@pocari.com',
            'password' => Hash::make('12345678'), // Password default
            'role' => 'pusat',
        ]);

        // Akun Distributor
        User::create([
            'name' => 'Distributor Utama',
            'email' => 'distributor@pocari.com',
            'password' => Hash::make('12345678'),
            'role' => 'distributor',
        ]);
    }
}
