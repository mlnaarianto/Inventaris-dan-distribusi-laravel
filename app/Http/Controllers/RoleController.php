<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /** Role bawaan: tidak boleh diganti nama atau dihapus. */
    public const PROTECTED_ROLES = ['super-admin'];
    public function index(): View
    {
        $roles = Role::withCount(['permissions', 'users'])->orderBy('id')->paginate(10);

        return view('roles.index', [
            'roles'     => $roles,
            'protected' => self::PROTECTED_ROLES,
        ]);
    }

    public function create(): View
    {
        return view('roles.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'lowercase', 'alpha_dash', 'min:3', 'max:50', Rule::unique('roles', 'name')],
        ], [], ['name' => 'nama role']);

        $role = Role::create(['name' => $validated['name'], 'guard_name' => 'web']);

        // Langsung arahkan ke pengaturan permission role yang baru dibuat
        if ($request->user()->can('role.permission')) {
            return redirect()->route('roles.permissions.edit', $role)
                ->with('success', 'Role berhasil dibuat. Silakan atur permission-nya.');
        }

        return redirect()->route('roles.index')->with('success', 'Role berhasil dibuat.');
    }

    public function edit(Role $role): View|RedirectResponse
    {
        if ($this->isProtected($role)) {
            return redirect()->route('roles.index')->with('error', 'Role bawaan tidak dapat diubah namanya.');
        }

        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        if ($this->isProtected($role)) {
            return redirect()->route('roles.index')->with('error', 'Role bawaan tidak dapat diubah namanya.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'lowercase', 'alpha_dash', 'min:3', 'max:50', Rule::unique('roles', 'name')->ignore($role->id)],
        ], [], ['name' => 'nama role']);

        $role->update(['name' => $validated['name']]);

        return redirect()->route('roles.index')->with('success', 'Role berhasil diperbarui.');
    }

    public function destroy(Role $role): RedirectResponse
    {
        if ($this->isProtected($role)) {
            return back()->with('error', 'Role bawaan tidak dapat dihapus.');
        }

        if ($role->users()->exists()) {
            return back()->with('error', 'Role masih digunakan oleh pengguna dan tidak dapat dihapus.');
        }

        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role berhasil dihapus.');
    }

    private function isProtected(Role $role): bool
    {
        return in_array($role->name, self::PROTECTED_ROLES, true);
    }
}
