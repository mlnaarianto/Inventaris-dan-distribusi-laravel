<x-app-layout>
    <x-slot name="header">Kelola Akun</x-slot>

    @if (session('success'))
        <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-semibold px-4 py-3">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm font-semibold px-4 py-3">{{ session('error') }}</div>
    @endif

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="flex flex-wrap items-center justify-between gap-3 p-6 border-b border-slate-100">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Daftar Akun</h2>
                <p class="text-sm text-slate-500">Kelola akun pengguna, peran, dan password.</p>
            </div>
            <div class="flex items-center gap-3">
                <form method="GET" action="{{ route('users.index') }}">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, username, email..."
                           class="w-64 rounded-xl border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                </form>
                @can('user.create')
                    <a href="{{ route('users.create') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold px-4 py-2.5 rounded-xl transition-colors">+ Tambah Akun</a>
                @endcan
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                    <tr>
                        <th class="px-6 py-3">Pengguna</th>
                        <th class="px-6 py-3">Username</th>
                        <th class="px-6 py-3">Role</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($users as $u)
                        @php
                            $isSelf = $u->id === auth()->id();
                            $targetSuper = $u->hasRole('super-admin');
                            $canTouch = ! $targetSuper || auth()->user()->hasRole('super-admin');
                        @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if ($u->foto_url)
                                        <img src="{{ $u->foto_url }}" alt="" class="w-9 h-9 rounded-full object-cover border border-slate-200">
                                    @else
                                        <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-600 border border-blue-200 flex items-center justify-center text-sm font-bold">{{ $u->inisial }}</div>
                                    @endif
                                    <div>
                                        <p class="font-bold text-slate-800">{{ $u->name }}
                                            @if ($isSelf)<span class="ml-1 text-[10px] font-bold uppercase text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">Anda</span>@endif
                                        </p>
                                        <p class="text-xs text-slate-500">{{ $u->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-mono text-slate-600">{{ $u->username }}</td>
                            <td class="px-6 py-4">
                                <span class="text-[11px] font-bold uppercase tracking-wider text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full">
                                    {{ Str::headline($u->roles->first()?->name ?? '-') }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    @if ($canTouch)
                                        @can('user.update')
                                            <a href="{{ route('users.edit', $u) }}" class="text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 px-3 py-1.5 rounded-lg">Ubah</a>
                                        @endcan
                                        @can('user.reset-password')
                                            <a href="{{ route('users.password.edit', $u) }}" class="text-xs font-bold text-amber-700 bg-amber-50 hover:bg-amber-100 px-3 py-1.5 rounded-lg">Reset Password</a>
                                        @endcan
                                        @can('user.delete')
                                            @unless ($isSelf)
                                                <form method="POST" action="{{ route('users.destroy', $u) }}"
                                                      onsubmit="return confirm('Hapus akun {{ $u->name }}? Tindakan ini tidak dapat dibatalkan.')">
                                                    @csrf @method('DELETE')
                                                    <button class="text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg">Hapus</button>
                                                </form>
                                            @endunless
                                        @endcan
                                    @else
                                        <span class="text-xs text-slate-400">Dilindungi</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-6 py-10 text-center text-slate-400">Tidak ada akun ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4">{{ $users->links() }}</div>
    </div>
</x-app-layout>