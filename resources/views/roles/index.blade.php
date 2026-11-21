<x-app-layout>
    <x-slot name="title">Manajemen Role</x-slot>
    <x-slot name="header">Manajemen Role</x-slot>

    @if (session('success'))
        <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-semibold px-4 py-3">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm font-semibold px-4 py-3">{{ session('error') }}</div>
    @endif

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="flex items-center justify-between p-6 border-b border-slate-100">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Daftar Role</h2>
                <p class="text-sm text-slate-500">Atur peran pengguna dan permission yang dimilikinya.</p>
            </div>
            @can('role.create')
                <a href="{{ route('roles.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold px-4 py-2.5 rounded-xl transition-colors">
                    + Tambah Role
                </a>
            @endcan
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                    <tr>
                        <th class="px-6 py-3">Role</th>
                        <th class="px-6 py-3 text-center">Permission</th>
                        <th class="px-6 py-3 text-center">Pengguna</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($roles as $role)
                        @php $locked = in_array($role->name, $protected, true); @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4">
                                <span class="font-bold text-slate-800">{{ Str::headline($role->name) }}</span>
                                <span class="ml-2 text-xs text-slate-400 font-mono">{{ $role->name }}</span>
                                @if ($locked)
                                    <span class="ml-2 text-[10px] font-bold uppercase text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full">Bawaan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($role->name === 'super-admin')
                                    <span class="text-xs font-semibold text-blue-600">Semua akses</span>
                                @else
                                    {{ $role->permissions_count }}
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">{{ $role->users_count }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    @can('role.permission')
                                        @if ($role->name !== 'super-admin')
                                            <a href="{{ route('roles.permissions.edit', $role) }}"
                                               class="text-xs font-bold text-blue-600 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg">Atur Permission</a>
                                        @endif
                                    @endcan
                                    @can('role.update')
                                        @unless ($locked)
                                            <a href="{{ route('roles.edit', $role) }}"
                                               class="text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 px-3 py-1.5 rounded-lg">Ubah</a>
                                        @endunless
                                    @endcan
                                    @can('role.delete')
                                        @unless ($locked)
                                            <form method="POST" action="{{ route('roles.destroy', $role) }}"
                                                  onsubmit="return confirm('Hapus role {{ $role->name }}?')">
                                                @csrf @method('DELETE')
                                                <button class="text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg">Hapus</button>
                                            </form>
                                        @endunless
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4">{{ $roles->links() }}</div>
    </div>
</x-app-layout>