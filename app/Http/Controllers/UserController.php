<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    private const SUPER = 'super-admin';

    public function index(Request $request): View
    {
        $users = User::with('roles')
            ->when($request->filled('q'), function ($query) use ($request) {
                $q = $request->string('q');
                $query->where(fn ($w) => $w->where('name', 'like', "%{$q}%")
                    ->orWhere('username', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%"));
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        return view('users.create', ['roles' => $this->assignableRoles()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'lowercase', 'alpha_dash', 'min:3', 'max:50', 'unique:users,username'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role'     => ['required', Rule::in($this->assignableRoles()->pluck('name'))],
        ], [], $this->attributes());

        $user = User::create([
            'name'     => $validated['name'],
            'username' => $validated['username'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->forceFill(['email_verified_at' => now()])->save();
        $user->assignRole($validated['role']);

        return redirect()->route('users.index')->with('success', 'Akun berhasil ditambahkan.');
    }

    public function edit(User $user): View
    {
        $this->authorizeTarget($user);

        return view('users.edit', [
            'user'     => $user,
            'roles'    => $this->assignableRoles(),
            'userRole' => $user->roles->first()?->name,
            'isSelf'   => $user->id === auth()->id(),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $this->authorizeTarget($user);
        $isSelf = $user->id === auth()->id();

        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'lowercase', 'alpha_dash', 'min:3', 'max:50', Rule::unique('users', 'username')->ignore($user->id)],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'role'     => [$isSelf ? 'nullable' : 'required', Rule::in($this->assignableRoles()->pluck('name'))],
        ], [], $this->attributes());

        // Role sendiri tidak boleh diubah; role super admin terakhir tidak boleh diturunkan
        if (! $isSelf) {
            if ($user->hasRole(self::SUPER) && $validated['role'] !== self::SUPER && $this->isLastSuperAdmin()) {
                return back()->withInput()->with('error', 'Super admin terakhir tidak dapat diturunkan rolenya.');
            }
            $user->syncRoles([$validated['role']]);
        }

        $user->update([
            'name'     => $validated['name'],
            'username' => $validated['username'],
            'email'    => $validated['email'],
        ]);

        return redirect()->route('users.index')->with('success', 'Data akun berhasil diperbarui.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->authorizeTarget($user);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        if ($user->hasRole(self::SUPER) && $this->isLastSuperAdmin()) {
            return back()->with('error', 'Super admin terakhir tidak dapat dihapus.');
        }

        $foto = $user->foto;
        $user->delete();

        if ($foto) {
            Storage::disk('public')->delete($foto);
        }

        return redirect()->route('users.index')->with('success', 'Akun berhasil dihapus.');
    }

    public function editPassword(User $user): View
    {
        $this->authorizeTarget($user);

        return view('users.password', compact('user'));
    }

    public function updatePassword(Request $request, User $user): RedirectResponse
    {
        $this->authorizeTarget($user);

        $validated = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [], ['password' => 'password baru']);

        $user->update(['password' => Hash::make($validated['password'])]);

        return redirect()->route('users.index')
            ->with('success', "Password untuk \"{$user->name}\" berhasil direset.");
    }

    /** Role yang boleh dipilih: super-admin hanya muncul bagi super admin. */
    private function assignableRoles(): Collection
    {
        return Role::orderBy('name')
            ->when(! auth()->user()->hasRole(self::SUPER), fn ($q) => $q->where('name', '!=', self::SUPER))
            ->get();
    }

    /** Non-super-admin tidak boleh menyentuh akun super admin. */
    private function authorizeTarget(User $target): void
    {
        abort_if(
            $target->hasRole(self::SUPER) && ! auth()->user()->hasRole(self::SUPER),
            403,
            'Anda tidak berhak mengelola akun super admin.'
        );
    }

    private function isLastSuperAdmin(): bool
    {
        return User::role(self::SUPER)->count() <= 1;
    }

    private function attributes(): array
    {
        return [
            'name'     => 'nama',
            'username' => 'username',
            'email'    => 'email',
            'password' => 'password',
            'role'     => 'role',
        ];
    }
}