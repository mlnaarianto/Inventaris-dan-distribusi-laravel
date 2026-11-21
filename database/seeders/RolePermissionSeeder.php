<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache permission
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'dashboard.view',

            'produk.view',
            'produk.create',
            'produk.update',
            'produk.delete',

            'request.view',
            'request.create',
            'request.update-status',
            'request.cetak',

            'mutasi.view',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        // Super admin: tanpa permission, aksesnya diberikan lewat Gate::before
        Role::findOrCreate('super-admin', 'web');

        // Pusat: semua permission
        Role::findOrCreate('pusat', 'web')->syncPermissions($permissions);

        // Distributor: terbatas
        Role::findOrCreate('distributor', 'web')->syncPermissions([
            'dashboard.view',
            'request.view',
            'request.create',
        ]);
    }
}