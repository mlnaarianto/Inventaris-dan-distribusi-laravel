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
            'request.view-all',      // baru: lihat request semua distributor
            'request.create',
            'request.update-status',
            'request.cetak',
            'request.terima',        // baru: konfirmasi barang diterima

            'mutasi.view',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        // Super admin: tanpa permission, aksesnya diberikan lewat Gate::before
        Role::findOrCreate('super-admin', 'web');

        // Pusat: semua, kecuali yang khusus distributor
        Role::findOrCreate('pusat', 'web')->syncPermissions(
            array_diff($permissions, ['request.create', 'request.terima'])
        );

        // Distributor: terbatas
        Role::findOrCreate('distributor', 'web')->syncPermissions([
            'dashboard.view',
            'produk.view',
            'request.view',
            'request.create',
            'request.terima',
            'mutasi.view',
        ]);
    }
}
