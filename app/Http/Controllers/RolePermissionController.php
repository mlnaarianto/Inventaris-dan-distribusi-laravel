<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    public function edit(Role $role): View|RedirectResponse
    {
        if ($role->name === 'super-admin') {
            return redirect()->route('roles.index')
                ->with('error', 'Super Admin otomatis memiliki semua akses, tidak perlu diatur.');
        }

        $permissions = $this->groupPermissions(Permission::orderBy('name')->get());
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        // Peta kode => label Indonesia, dipakai view
        $labels = collect(config('permission-labels'))->collapse()->all();

        return view('roles.permissions', compact('role', 'permissions', 'rolePermissions', 'labels'));
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        if ($role->name === 'super-admin') {
            return redirect()->route('roles.index')
                ->with('error', 'Permission Super Admin tidak dapat diubah.');
        }

        $validated = $request->validate([
            'permissions'   => ['array'],
            'permissions.*' => ['exists:permissions,name'],
        ]);

        $role->syncPermissions($validated['permissions'] ?? []);

        return redirect()->route('roles.index')
            ->with('success', "Permission untuk role \"{$role->name}\" berhasil diperbarui.");
    }

    /**
     * Kelompokkan permission per modul. Permission yang belum dipetakan
     * otomatis masuk ke "Fitur Lainnya", jadi tidak pernah hilang dari tampilan.
     */
    private function groupPermissions(Collection $permissions): array
    {
        $moduleMap = config('permission-labels');
        $grouped = [];

        foreach ($moduleMap as $label => $items) {
            $matched = $permissions->whereIn('name', array_keys($items))->values();

            if ($matched->isNotEmpty()) {
                $grouped[$label] = $matched;
            }
        }

        $mappedNames = collect($moduleMap)->collapse()->keys();
        $others = $permissions->reject(fn($p) => $mappedNames->contains($p->name))->values();

        if ($others->isNotEmpty()) {
            $grouped['Fitur Lainnya'] = $others;
        }

        return $grouped;
    }
}
