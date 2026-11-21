<x-app-layout>
    <x-slot name="title">Manajemen Role</x-slot>
    <x-slot name="header">Manajemen Role</x-slot>

    <div class="space-y-5 mb-6 max-w-6xl mx-auto">

        {{-- ================= HERO ================= --}}
        <div class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 dark:from-blue-700 dark:via-indigo-800 dark:to-slate-900 rounded-2xl p-5 sm:p-6 overflow-hidden shadow-lg shadow-blue-500/20 dark:shadow-black/40">
            <div class="absolute -top-20 -right-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-32 w-32 h-32 bg-indigo-400/20 rounded-full blur-2xl"></div>

            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="min-w-0">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-blue-50 text-[10px] font-bold uppercase tracking-widest mb-2 backdrop-blur-md">
                        <i class="fas fa-shield-halved text-xs"></i>
                        Administrasi
                    </div>
                    <h5 class="text-xl sm:text-2xl font-extrabold text-white leading-tight">Daftar Role</h5>
                    <p class="text-blue-100/85 text-sm mt-1 max-w-md">
                        Atur peran pengguna dan permission yang dimilikinya.
                    </p>
                </div>

                @can('role.create')
                    <a href="{{ route('roles.create') }}"
                       class="inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-bold text-blue-700 dark:text-blue-900 bg-white hover:bg-blue-50 rounded-xl transition-all hover:-translate-y-0.5 shadow-md shrink-0">
                        <i class="fas fa-plus text-xs"></i>
                        Tambah Role
                    </a>
                @endcan
            </div>
        </div>

        {{-- ================= ALERT ================= --}}
        @if (session('success'))
            <div class="flex items-start gap-2 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/30 text-emerald-700 dark:text-emerald-400 text-sm font-semibold px-4 py-3">
                <i class="fas fa-check-circle mt-0.5"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="flex items-start gap-2 rounded-xl bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/30 text-red-700 dark:text-red-400 text-sm font-semibold px-4 py-3">
                <i class="fas fa-exclamation-circle mt-0.5"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- ================= CARD TABEL ================= --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm overflow-hidden transition-colors">

            <div class="p-4 sm:p-5 border-b border-slate-100 dark:border-slate-700 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-indigo-50 dark:bg-indigo-500/15 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0">
                    <i class="fas fa-user-shield text-sm"></i>
                </div>
                <div>
                    <h6 class="text-sm font-bold text-slate-800 dark:text-white">Tabel Role Sistem</h6>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Role bawaan tidak dapat diubah atau dihapus.</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-[11px] text-slate-500 dark:text-slate-400 uppercase bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700">
                        <tr>
                            <th class="px-4 sm:px-6 py-3 font-bold">Role</th>
                            <th class="px-4 sm:px-6 py-3 font-bold text-center">Permission</th>
                            <th class="px-4 sm:px-6 py-3 font-bold text-center">Pengguna</th>
                            <th class="px-4 sm:px-6 py-3 font-bold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700 text-slate-600 dark:text-slate-300">
                        @foreach ($roles as $role)
                            @php $locked = in_array($role->name, $protected, true); @endphp
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/40 transition-colors">

                                <td class="px-4 sm:px-6 py-3.5">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="font-bold text-slate-800 dark:text-white text-sm">{{ Str::headline($role->name) }}</span>
                                        @if ($locked)
                                            <span class="inline-flex items-center gap-1 text-[10px] font-bold uppercase text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 px-2 py-0.5 rounded-full">
                                                <i class="fas fa-lock text-[8px]"></i> Bawaan
                                            </span>
                                        @endif
                                    </div>
                                    <span class="text-[11px] text-slate-400 dark:text-slate-500 font-mono">{{ $role->name }}</span>
                                </td>

                                <td class="px-4 sm:px-6 py-3.5 text-center">
                                    @if ($role->name === 'super-admin')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10px] font-bold uppercase text-blue-700 dark:text-blue-400 bg-blue-50 dark:bg-blue-500/15 border border-blue-200 dark:border-blue-500/30 rounded-lg">
                                            <i class="fas fa-crown text-[9px]"></i> Semua
                                        </span>
                                    @else
                                        <span class="inline-flex items-center justify-center min-w-[2.5rem] px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 font-bold text-xs text-slate-700 dark:text-slate-200">
                                            {{ $role->permissions_count }}
                                        </span>
                                    @endif
                                </td>

                                <td class="px-4 sm:px-6 py-3.5 text-center">
                                    <span class="inline-flex items-center justify-center min-w-[2.5rem] px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 font-bold text-xs text-slate-700 dark:text-slate-200">
                                        {{ $role->users_count }}
                                    </span>
                                </td>

                                <td class="px-4 sm:px-6 py-3.5">
                                    <div class="flex items-center justify-end gap-1.5 flex-wrap">
                                        @can('role.permission')
                                            @if ($role->name !== 'super-admin')
                                                <a href="{{ route('roles.permissions.edit', $role) }}"
                                                   class="inline-flex items-center gap-1 text-[11px] font-bold text-blue-700 dark:text-blue-400 bg-blue-50 dark:bg-blue-500/10 hover:bg-blue-100 dark:hover:bg-blue-500/20 border border-blue-200 dark:border-blue-500/30 px-2.5 py-1.5 rounded-lg transition-colors">
                                                    <i class="fas fa-key text-[9px]"></i>
                                                    Permission
                                                </a>
                                            @endif
                                        @endcan

                                        @can('role.update')
                                            @unless ($locked)
                                                <a href="{{ route('roles.edit', $role) }}"
                                                   class="inline-flex items-center gap-1 text-[11px] font-bold text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 border border-slate-200 dark:border-slate-600 px-2.5 py-1.5 rounded-lg transition-colors">
                                                    <i class="fas fa-pen text-[9px]"></i>
                                                    Ubah
                                                </a>
                                            @endunless
                                        @endcan

                                        @can('role.delete')
                                            @unless ($locked)
                                                <form method="POST" action="{{ route('roles.destroy', $role) }}"
                                                      onsubmit="return confirm('Hapus role {{ $role->name }}?')" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button class="inline-flex items-center gap-1 text-[11px] font-bold text-red-700 dark:text-red-400 bg-red-50 dark:bg-red-500/10 hover:bg-red-100 dark:hover:bg-red-500/20 border border-red-200 dark:border-red-500/30 px-2.5 py-1.5 rounded-lg transition-colors">
                                                        <i class="fas fa-trash text-[9px]"></i>
                                                        Hapus
                                                    </button>
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

            @if ($roles->hasPages())
                <div class="p-4 border-t border-slate-100 dark:border-slate-700">{{ $roles->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>