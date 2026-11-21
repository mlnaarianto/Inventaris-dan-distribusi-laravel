<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'email' => 'superadmin@pocari.com',
                'role' => 'super-admin',
            ],
            [
                'name' => 'Admin Pusat Pocari',
                'username' => 'pusat',
                'email' => 'pusat@pocari.com',
                'role' => 'pusat',
            ],
            [
                'name' => 'Distributor Utama',
                'username' => 'distributor',
                'email' => 'distributor@pocari.com',
                'role' => 'distributor',
            ],
        ];

        foreach ($users as $data) {
            $user = User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make('12345678'),
            ]);

            // email_verified_at tidak ada di $fillable, jadi diisi lewat forceFill
            // (route dashboard memakai middleware 'verified')
            $user->forceFill(['email_verified_at' => now()])->save();

            $user->assignRole($data['role']);
        }
    }
}