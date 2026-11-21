<x-app-layout>
    <x-slot name="title">Permission Role: {{ Str::headline($role->name) }}</x-slot>
    <x-slot name="header">Permission Role: {{ Str::headline($role->name) }}</x-slot>

    @php
        $selectedNames  = old('permissions', $rolePermissions);
        $totalSelected  = count($selectedNames);
        $totalAvailable = 0;
        foreach ($permissions as $items) { $totalAvailable += count($items); }
    @endphp

    <form method="POST" action="{{ route('roles.permissions.update', $role) }}"
          class="space-y-5 mb-6"
          x-data="{
              count: {{ $totalSelected }},
              total: {{ $totalAvailable }},
              updateCount() {
                  this.count = document.querySelectorAll('input[name=\'permissions[]\']:checked').length;
              }
          }"
          @change="updateCount()"
          @permissions-updated.window="updateCount()"
          x-init="$nextTick(() => updateCount())">
        @csrf @method('PUT')

        {{-- ================= HERO + COUNTER ================= --}}
        <div class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 dark:from-blue-700 dark:via-indigo-800 dark:to-slate-900 rounded-2xl p-5 sm:p-6 overflow-hidden shadow-lg shadow-blue-500/20 dark:shadow-black/40">
            <div class="absolute -top-20 -right-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-32 w-32 h-32 bg-indigo-400/20 rounded-full blur-2xl"></div>

            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
                <div class="min-w-0">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-blue-50 text-[10px] font-bold uppercase tracking-widest mb-2 backdrop-blur-md">
                        <i class="fas fa-shield-halved text-xs"></i>
                        Atur Hak Akses
                    </div>
                    <h5 class="text-xl sm:text-2xl font-extrabold text-white leading-tight">
                        Permission — <span class="text-blue-200 font-mono">{{ Str::headline($role->name) }}</span>
                    </h5>
                    <p class="text-blue-100/85 text-sm mt-1 max-w-md">
                        Aktifkan akses yang boleh dilakukan oleh role ini pada sistem.
                    </p>
                </div>

                <a href="{{ route('roles.index') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-white bg-white/15 hover:bg-white/25 border border-white/25 rounded-xl backdrop-blur-md transition-colors shrink-0">
                    <i class="fas fa-arrow-left text-[10px]"></i>
                    Kembali
                </a>
            </div>

            {{-- Progress counter --}}
            <div class="relative z-10 bg-white/10 backdrop-blur-md border border-white/20 rounded-xl p-3.5">
                <div class="flex items-center justify-between text-white mb-2">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check-double text-emerald-300 text-sm"></i>
                        <span class="text-xs font-bold uppercase tracking-wider text-blue-100">Permission Terpilih</span>
                    </div>
                    <span class="text-sm font-black">
                        <span x-text="count">{{ $totalSelected }}</span>
                        <span class="text-blue-200/70 font-semibold">/ {{ $totalAvailable }}</span>
                    </span>
                </div>
                <div class="h-1.5 rounded-full bg-white/20 overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-emerald-400 to-blue-400 rounded-full transition-all duration-300"
                         :style="`width: ${Math.min((count / Math.max(total, 1)) * 100, 100)}%`"></div>
                </div>
            </div>
        </div>

        {{-- ================= KATEGORI PERMISSION ================= --}}
        @foreach ($permissions as $label => $items)
            @php
                $lc = strtolower($label);
                $sectionIcon = 'fa-key';
                if (str_contains($lc, 'produk') || str_contains($lc, 'barang')) $sectionIcon = 'fa-boxes';
                elseif (str_contains($lc, 'request') || str_contains($lc, 'order') || str_contains($lc, 'permintaan') || str_contains($lc, 'pesanan')) $sectionIcon = 'fa-clipboard-list';
                elseif (str_contains($lc, 'mutasi') || str_contains($lc, 'stok') || str_contains($lc, 'stock')) $sectionIcon = 'fa-exchange-alt';
                elseif (str_contains($lc, 'user') || str_contains($lc, 'pengguna') || str_contains($lc, 'akun')) $sectionIcon = 'fa-users';
                elseif (str_contains($lc, 'role') || str_contains($lc, 'peran')) $sectionIcon = 'fa-user-shield';
                elseif (str_contains($lc, 'dashboard')) $sectionIcon = 'fa-chart-pie';
                elseif (str_contains($lc, 'profile') || str_contains($lc, 'profil')) $sectionIcon = 'fa-user-cog';
            @endphp

            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm overflow-hidden transition-colors"
                 x-data="{
                     toggle(e) {
                         $root.querySelectorAll('input[type=checkbox][name=\'permissions[]\']').forEach(c => c.checked = e.target.checked);
                         $dispatch('permissions-updated');
                     }
                 }">

                {{-- Header kategori --}}
                <div class="p-4 sm:p-5 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between gap-3 bg-slate-50/50 dark:bg-slate-900/40">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-9 h-9 rounded-lg bg-blue-50 dark:bg-blue-500/15 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                            <i class="fas {{ $sectionIcon }} text-sm"></i>
                        </div>
                        <div class="min-w-0">
                            <h3 class="font-bold text-slate-800 dark:text-white text-sm leading-tight">{{ $label }}</h3>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">{{ count($items) }} permission tersedia</p>
                        </div>
                    </div>

                    <label class="inline-flex items-center gap-2 cursor-pointer shrink-0">
                        <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider hidden sm:inline">Pilih semua</span>
                        <input type="checkbox" @change="toggle($event)" class="peer sr-only" aria-label="Pilih semua {{ $label }}">
                        <div class="relative w-9 h-5 rounded-full bg-slate-300 dark:bg-slate-600 peer-checked:bg-blue-600 transition-colors duration-200
                                    after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:h-4 after:w-4 after:rounded-full after:bg-white after:shadow-sm after:transition-transform after:duration-200
                                    peer-checked:after:translate-x-4"></div>
                    </label>
                </div>

                {{-- Grid permission dengan toggle --}}
                <div class="p-3 sm:p-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                    @foreach ($items as $permission)
                        <label class="group flex items-center justify-between gap-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 px-3 py-2.5 cursor-pointer hover:border-blue-300 dark:hover:border-blue-500/40 hover:bg-blue-50/30 dark:hover:bg-blue-500/5 transition-all has-[:checked]:border-blue-400 has-[:checked]:bg-blue-50/60 dark:has-[:checked]:border-blue-500/50 dark:has-[:checked]:bg-blue-500/10">

                            <div class="min-w-0 flex-1">
                                <span class="block text-sm font-semibold text-slate-700 dark:text-slate-200 leading-tight truncate">
                                    {{ $labels[$permission->name] ?? $permission->name }}
                                </span>
                                <span class="block text-[11px] font-mono text-slate-400 dark:text-slate-500 truncate mt-0.5">
                                    {{ $permission->name }}
                                </span>
                            </div>

                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                   @checked(in_array($permission->name, old('permissions', $rolePermissions)))
                                   class="peer sr-only">

                            {{-- Toggle switch visual --}}
                            <div class="relative shrink-0 w-10 h-6 rounded-full bg-slate-300 dark:bg-slate-600 peer-checked:bg-blue-600 transition-colors duration-200
                                        after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow-md after:transition-transform after:duration-200
                                        peer-checked:after:translate-x-4
                                        group-hover:after:shadow-lg"></div>
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach

        {{-- ================= FOOTER ACTION ================= --}}
        <div class="sticky bottom-3 z-30 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-lg dark:shadow-black/40 p-3 sm:p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 transition-colors">
            <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 order-2 sm:order-1 justify-center sm:justify-start">
                <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-500/15 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                    <i class="fas fa-list-check text-xs"></i>
                </div>
                <span class="text-xs">
                    <span class="font-extrabold text-slate-800 dark:text-white" x-text="count">{{ $totalSelected }}</span>
                    <span>dari</span>
                    <span class="font-bold text-slate-700 dark:text-slate-300">{{ $totalAvailable }}</span>
                    <span>permission dipilih</span>
                </span>
            </div>

            <div class="flex flex-col-reverse sm:flex-row gap-2.5 order-1 sm:order-2">
                <a href="{{ route('roles.index') }}"
                   class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-bold text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-xl hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-colors shadow-sm">
                    <i class="fas fa-save text-xs"></i>
                    Simpan Permission
                </button>
            </div>
        </div>
    </form>
</x-app-layout>