<x-app-layout>
    <x-slot name="title">Kelola Akun</x-slot>
    <x-slot name="header">Kelola Akun</x-slot>

    <div class="space-y-5 mb-6 max-w-7xl mx-auto">

        {{-- ================= HERO ================= --}}
        <div class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 dark:from-blue-700 dark:via-indigo-800 dark:to-slate-900 rounded-2xl p-5 sm:p-6 overflow-hidden shadow-lg shadow-blue-500/20 dark:shadow-black/40">
            <div class="absolute -top-20 -right-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-32 w-32 h-32 bg-indigo-400/20 rounded-full blur-2xl"></div>

            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="min-w-0">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-blue-50 text-[10px] font-bold uppercase tracking-widest mb-2 backdrop-blur-md">
                        <i class="fas fa-users text-xs"></i>
                        Administrasi
                    </div>
                    <h5 class="text-xl sm:text-2xl font-extrabold text-white leading-tight">Daftar Akun</h5>
                    <p class="text-blue-100/85 text-sm mt-1 max-w-md">
                        Kelola akun pengguna, peran, dan password.
                    </p>
                </div>

                @can('user.create')
                    <a href="{{ route('users.create') }}"
                       class="inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-bold text-blue-700 dark:text-blue-900 bg-white hover:bg-blue-50 rounded-xl transition-all hover:-translate-y-0.5 shadow-md shrink-0">
                        <i class="fas fa-user-plus text-xs"></i>
                        Tambah Akun
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

            {{-- Search bar --}}
            <div class="p-4 sm:p-5 border-b border-slate-100 dark:border-slate-700 flex flex-col sm:flex-row sm:items-center gap-3">
                <form method="GET" action="{{ route('users.index') }}" class="flex-1 sm:max-w-md">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                            <i class="fas fa-search text-sm"></i>
                        </div>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, username, email..."
                               class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 text-slate-800 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 pl-10 pr-3 py-2.5 outline-none transition-all" />
                    </div>
                </form>

                <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400 sm:ml-auto">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-500/15 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                        <i class="fas fa-users text-xs"></i>
                    </div>
                    <span>
                        <span class="font-extrabold text-slate-800 dark:text-white">{{ $users->total() }}</span>
                        <span>akun terdaftar</span>
                    </span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-[11px] text-slate-500 dark:text-slate-400 uppercase bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700">
                        <tr>
                            <th class="px-4 sm:px-6 py-3 font-bold">Pengguna</th>
                            <th class="px-4 sm:px-6 py-3 font-bold">Username</th>
                            <th class="px-4 sm:px-6 py-3 font-bold">Role</th>
                            <th class="px-4 sm:px-6 py-3 font-bold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700 text-slate-600 dark:text-slate-300">
                        @forelse ($users as $u)
                            @php
                                $isSelf = $u->id === auth()->id();
                                $targetSuper = $u->hasRole('super-admin');
                                $canTouch = ! $targetSuper || auth()->user()->hasRole('super-admin');
                            @endphp
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/40 transition-colors">

                                <td class="px-4 sm:px-6 py-3.5">
                                    <div class="flex items-center gap-3">
                                        @if ($u->foto_url)
                                            <img src="{{ $u->foto_url }}" alt="" class="w-10 h-10 rounded-full object-cover border border-slate-200 dark:border-slate-600 shrink-0">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-500/15 text-blue-600 dark:text-blue-400 border border-blue-200 dark:border-blue-500/30 flex items-center justify-center text-sm font-bold shrink-0">
                                                {{ $u->inisial }}
                                            </div>
                                        @endif
                                        <div class="min-w-0">
                                            <div class="flex items-center gap-1.5 flex-wrap">
                                                <span class="font-bold text-slate-800 dark:text-white text-sm truncate">{{ $u->name }}</span>
                                                @if ($isSelf)
                                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold uppercase text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/15 border border-emerald-200 dark:border-emerald-500/30 px-2 py-0.5 rounded-full">
                                                        <i class="fas fa-user-check text-[8px]"></i> Anda
                                                    </span>
                                                @endif
                                                @if ($targetSuper && !$isSelf)
                                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold uppercase text-blue-700 dark:text-blue-400 bg-blue-50 dark:bg-blue-500/15 border border-blue-200 dark:border-blue-500/30 px-2 py-0.5 rounded-full">
                                                        <i class="fas fa-crown text-[8px]"></i> Super
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="text-xs text-slate-500 dark:text-slate-400 truncate">{{ $u->email }}</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-4 sm:px-6 py-3.5">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 text-xs font-mono text-slate-700 dark:text-slate-200">
                                        <i class="fas fa-at text-[9px] text-slate-400 dark:text-slate-500"></i>
                                        {{ $u->username }}
                                    </span>
                                </td>

                                <td class="px-4 sm:px-6 py-3.5">
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold uppercase tracking-wider text-blue-700 dark:text-blue-400 bg-blue-50 dark:bg-blue-500/15 border border-blue-200 dark:border-blue-500/30 px-2.5 py-1 rounded-full">
                                        <i class="fas fa-shield-halved text-[8px]"></i>
                                        {{ Str::headline($u->roles->first()?->name ?? '-') }}
                                    </span>
                                </td>

                                <td class="px-4 sm:px-6 py-3.5">
                                    <div class="flex items-center justify-end gap-1.5 flex-wrap">
                                        @if ($canTouch)
                                            @can('user.update')
                                                <a href="{{ route('users.edit', $u) }}"
                                                   class="inline-flex items-center gap-1 text-[11px] font-bold text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 border border-slate-200 dark:border-slate-600 px-2.5 py-1.5 rounded-lg transition-colors">
                                                    <i class="fas fa-pen text-[9px]"></i>
                                                    Ubah
                                                </a>
                                            @endcan
                                            @can('user.reset-password')
                                                <a href="{{ route('users.password.edit', $u) }}"
                                                   class="inline-flex items-center gap-1 text-[11px] font-bold text-amber-700 dark:text-amber-400 bg-amber-50 dark:bg-amber-500/10 hover:bg-amber-100 dark:hover:bg-amber-500/20 border border-amber-200 dark:border-amber-500/30 px-2.5 py-1.5 rounded-lg transition-colors">
                                                    <i class="fas fa-key text-[9px]"></i>
                                                    Reset
                                                </a>
                                            @endcan
                                            @can('user.delete')
                                                @unless ($isSelf)
                                                    <form method="POST" action="{{ route('users.destroy', $u) }}"
                                                          onsubmit="return confirm('Hapus akun {{ $u->name }}? Tindakan ini tidak dapat dibatalkan.')" class="inline">
                                                        @csrf @method('DELETE')
                                                        <button class="inline-flex items-center gap-1 text-[11px] font-bold text-red-700 dark:text-red-400 bg-red-50 dark:bg-red-500/10 hover:bg-red-100 dark:hover:bg-red-500/20 border border-red-200 dark:border-red-500/30 px-2.5 py-1.5 rounded-lg transition-colors">
                                                            <i class="fas fa-trash text-[9px]"></i>
                                                            Hapus
                                                        </button>
                                                    </form>
                                                @endunless
                                            @endcan
                                        @else
                                            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 px-2.5 py-1.5 rounded-lg">
                                                <i class="fas fa-lock text-[9px]"></i>
                                                Dilindungi
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-14 text-center">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-700 mb-4 text-slate-400 dark:text-slate-500 text-2xl">
                                        <i class="fas fa-user-slash"></i>
                                    </div>
                                    <p class="font-bold text-slate-600 dark:text-slate-300">Tidak ada akun ditemukan</p>
                                    <p class="text-sm text-slate-400 dark:text-slate-500 mt-1">Coba ubah kata kunci pencarian Anda.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($users->hasPages())
                <div class="p-4 border-t border-slate-100 dark:border-slate-700">{{ $users->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>