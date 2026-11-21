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
            'request.view-all',
            'request.create',
            'request.update-status',
            'request.cetak',
            'request.terima',

            'mutasi.view',

            'profile.update-email',      // default: hanya super-admin
            'profile.update-username',   // default: hanya super-admin

            // Manajemen role (default: hanya super-admin)
            'role.view',
            'role.create',
            'role.update',
            'role.delete',
            'role.permission',

            // Kelola akun (default: hanya super-admin)
            'user.view',
            'user.create',
            'user.update',
            'user.delete',
            'user.reset-password',

            'mutasi.view',
            'mutasi.cetak',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        // Super admin: tanpa permission, aksesnya diberikan lewat Gate::before
        Role::findOrCreate('super-admin', 'web');

        // Permission yang khusus super-admin, tidak diberikan ke role lain secara default
        $khususSuperAdmin = [
            'profile.update-email',
            'profile.update-username',
            'role.view',
            'role.create',
            'role.update',
            'role.delete',
            'role.permission',
            'user.view',
            'user.create',
            'user.update',
            'user.delete',
        ];

        // Pusat: semua, kecuali yang khusus distributor dan yang khusus super-admin.
        // Hanya diisi saat role pertama kali dibuat, supaya perubahan lewat
        // halaman Role tidak tertimpa saat seeder dijalankan ulang.
        $pusat = Role::findOrCreate('pusat', 'web');
        if ($pusat->wasRecentlyCreated) {
            $pusat->syncPermissions(
                array_diff($permissions, array_merge(['request.create', 'request.terima'], $khususSuperAdmin))
            );
        }

        // Distributor: terbatas (juga hanya diisi saat pertama kali dibuat)
        $distributor = Role::findOrCreate('distributor', 'web');
        if ($distributor->wasRecentlyCreated) {
            $distributor->syncPermissions([
                'dashboard.view',
                'produk.view',
                'request.view',
                'request.create',
                'request.terima',
                'mutasi.view',
            ]);
        }
    }
}
