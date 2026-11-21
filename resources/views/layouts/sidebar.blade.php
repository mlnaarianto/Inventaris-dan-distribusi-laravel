@php
    // Tampilan sidebar (label versi pusat vs distributor), diatur lewat dashboard.view-all
    $dashboardAll = auth()->user()->can('dashboard.view-all');

    $statuses = [
        [
            'key' => 'pending',
            'icon' => 'fa-clock',
            'label' => $dashboardAll ? 'Pesanan Baru' : 'Menunggu Pusat',
            'bg' => 'bg-orange-50',
            'iconActive' => 'bg-orange-500 text-white shadow-md shadow-orange-500/20',
            'iconHover' => 'group-hover:bg-orange-100 group-hover:text-orange-600',
            'textActive' => 'text-orange-700',
            'textHover' => 'group-hover:text-orange-600',
        ],
        [
            'key' => 'diproses',
            'icon' => 'fa-box-open',
            'label' => $dashboardAll ? 'Siap Kirim' : 'Sedang Diproses',
            'bg' => 'bg-blue-50',
            'iconActive' => 'bg-blue-600 text-white shadow-md shadow-blue-500/20',
            'iconHover' => 'group-hover:bg-blue-100 group-hover:text-blue-600',
            'textActive' => 'text-blue-700',
            'textHover' => 'group-hover:text-blue-700',
        ],
        [
            'key' => 'dikirim',
            'icon' => 'fa-truck',
            'label' => $dashboardAll ? 'Sedang Dikirim' : 'Dalam Perjalanan',
            'bg' => 'bg-indigo-50',
            'iconActive' => 'bg-indigo-500 text-white shadow-md shadow-indigo-500/20',
            'iconHover' => 'group-hover:bg-indigo-100 group-hover:text-indigo-600',
            'textActive' => 'text-indigo-700',
            'textHover' => 'group-hover:text-indigo-700',
        ],
        [
            'key' => 'selesai',
            'icon' => 'fa-check-circle',
            'label' => $dashboardAll ? 'Riwayat Selesai' : 'Pesanan Selesai',
            'bg' => 'bg-emerald-50',
            'iconActive' => 'bg-emerald-500 text-white shadow-md shadow-emerald-500/20',
            'iconHover' => 'group-hover:bg-emerald-100 group-hover:text-emerald-600',
            'textActive' => 'text-emerald-700',
            'textHover' => 'group-hover:text-emerald-700',
        ],
    ];

    $allActive = request()->routeIs('request.index') && !request()->has('status');
@endphp

{{-- BACKDROP: Hanya muncul di mobile/tablet (lg:hidden) --}}
<div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false" class="fixed inset-0 z-30 bg-slate-900/60 backdrop-blur-sm lg:hidden" x-cloak></div>

{{-- SIDEBAR UTAMA --}}
<aside id="logo-sidebar" 
       class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform duration-300 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 shadow-[4px_0_24px_rgba(0,0,0,0.02)] dark:shadow-[4px_0_24px_rgba(0,0,0,0.4)]" 
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
       aria-label="Sidebar">
    
    <div class="h-full flex flex-col justify-between bg-white dark:bg-slate-900 relative">

        {{-- TOMBOL CLOSE (X): Hanya muncul di mobile/tablet (lg:hidden) --}}
        <button @click="sidebarOpen = false" class="absolute top-4 right-4 p-2 text-slate-400 hover:text-red-500 z-50 focus:outline-none rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors lg:hidden">
            <i class="fas fa-times text-lg"></i>
        </button>

        <!-- Bagian Menu yang Bisa Di-scroll -->
        <div class="px-4 overflow-y-auto flex-1 pb-4">
            <ul class="space-y-1.5 font-medium mt-2">
                <li class="px-3 pb-2 pt-2 text-[11px] font-bold tracking-widest text-slate-400 dark:text-slate-500 uppercase">
                    Menu Utama
                </li>

                {{-- Dashboard --}}
                @can('dashboard.view')
                    <li>
                        <a href="{{ route('dashboard') }}" class="flex items-center p-2.5 rounded-lg transition-all group {{ request()->routeIs('dashboard') ? 'bg-blue-50 dark:bg-slate-800' : 'hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                            <div class="flex items-center justify-center w-9 h-9 rounded-md transition-all {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'bg-slate-100 text-slate-500 group-hover:bg-blue-100 group-hover:text-blue-600 dark:bg-slate-800 dark:text-slate-400 dark:group-hover:bg-blue-500/20 dark:group-hover:text-blue-400' }}">
                                <i class="fas fa-chart-pie text-sm"></i>
                            </div>
                            <span class="ms-3 font-semibold text-sm {{ request()->routeIs('dashboard') ? 'text-blue-700 dark:text-white' : 'text-slate-600 group-hover:text-blue-700 dark:text-slate-400 dark:group-hover:text-white' }}">{{ $dashboardAll ? 'Dashboard Pusat' : 'Dashboard' }}</span>
                        </a>
                    </li>
                @endcan

                {{-- Katalog Barang --}}
                @can('produk.view')
                    <li>
                        <a href="{{ route('produk.index') }}" class="flex items-center p-2.5 rounded-lg transition-all group {{ request()->routeIs('produk.*') ? 'bg-blue-50 dark:bg-slate-800' : 'hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                            <div class="flex items-center justify-center w-9 h-9 rounded-md transition-all {{ request()->routeIs('produk.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'bg-slate-100 text-slate-500 group-hover:bg-blue-100 group-hover:text-blue-600 dark:bg-slate-800 dark:text-slate-400 dark:group-hover:bg-blue-500/20 dark:group-hover:text-blue-400' }}">
                                <i class="fas fa-boxes text-sm"></i>
                            </div>
                            <span class="ms-3 font-semibold text-sm {{ request()->routeIs('produk.*') ? 'text-blue-700 dark:text-white' : 'text-slate-600 group-hover:text-blue-700 dark:text-slate-400 dark:group-hover:text-white' }}">Katalog Barang</span>
                        </a>
                    </li>
                @endcan

                {{-- Buat Pesanan Baru --}}
                @can('request.create')
                    <li>
                        <a href="{{ route('request.create') }}" class="flex items-center p-2.5 rounded-lg transition-all group {{ request()->routeIs('request.create') ? 'bg-blue-50 dark:bg-slate-800' : 'hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                            <div class="flex items-center justify-center w-9 h-9 rounded-md transition-all {{ request()->routeIs('request.create') ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'bg-slate-100 text-slate-500 group-hover:bg-blue-100 group-hover:text-blue-600 dark:bg-slate-800 dark:text-slate-400 dark:group-hover:bg-blue-500/20 dark:group-hover:text-blue-400' }}">
                                <i class="fas fa-cart-plus text-sm"></i>
                            </div>
                            <span class="ms-3 font-semibold text-sm {{ request()->routeIs('request.create') ? 'text-blue-700 dark:text-white' : 'text-slate-600 group-hover:text-blue-700 dark:text-slate-400 dark:group-hover:text-white' }}">Buat Pesanan Baru</span>
                        </a>
                    </li>
                @endcan

                {{-- Alur / Pantau Pesanan --}}
                @can('request.view')
                    <li class="px-3 pb-2 pt-4 text-[11px] font-bold tracking-widest text-slate-400 dark:text-slate-500 uppercase">
                        {{ $dashboardAll ? 'Alur Pesanan' : 'Pantau Pesanan' }}
                    </li>

                    @foreach ($statuses as $s)
                        @php $active = request('status') == $s['key']; @endphp
                        <li>
                            <a href="{{ route('request.index', ['status' => $s['key']]) }}" class="flex items-center p-2.5 rounded-lg transition-all group {{ $active ? $s['bg'] . ' dark:bg-slate-800' : 'hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                                <div class="flex items-center justify-center w-9 h-9 rounded-md transition-all {{ $active ? $s['iconActive'] : 'bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400 dark:group-hover:bg-slate-700 dark:group-hover:text-white ' . $s['iconHover'] }}">
                                    <i class="fas {{ $s['icon'] }} text-sm"></i>
                                </div>
                                <span class="ms-3 font-semibold text-sm {{ $active ? $s['textActive'] . ' dark:text-white' : 'text-slate-600 dark:text-slate-400 dark:group-hover:text-white ' . $s['textHover'] }}">{{ $s['label'] }}</span>
                            </a>
                        </li>
                    @endforeach

                    <li>
                        <a href="{{ route('request.index') }}" class="flex items-center p-2.5 rounded-lg transition-all group {{ $allActive ? 'bg-slate-100 dark:bg-slate-800' : 'hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                            <div class="flex items-center justify-center w-9 h-9 rounded-md transition-all {{ $allActive ? 'bg-slate-600 text-white shadow-md shadow-slate-500/20' : 'bg-slate-100 text-slate-500 group-hover:bg-slate-200 group-hover:text-slate-700 dark:bg-slate-800 dark:text-slate-400 dark:group-hover:bg-slate-700 dark:group-hover:text-white' }}">
                                <i class="fas fa-list-ul text-sm"></i>
                            </div>
                            <span class="ms-3 font-semibold text-sm {{ $allActive ? 'text-slate-800 dark:text-white' : 'text-slate-600 group-hover:text-slate-800 dark:text-slate-400 dark:group-hover:text-white' }}">{{ $dashboardAll ? 'Semua Transaksi' : 'Semua Pesanan' }}</span>
                        </a>
                    </li>
                @endcan

                {{-- Pelaporan --}}
                @can('mutasi.view')
                    <li class="px-3 pb-2 pt-4 text-[11px] font-bold tracking-widest text-slate-400 dark:text-slate-500 uppercase">
                        Pelaporan
                    </li>

                    <li>
                        <a href="{{ route('mutasi.index') }}" class="flex items-center p-2.5 rounded-lg transition-all group {{ request()->routeIs('mutasi.*') ? 'bg-blue-50 dark:bg-slate-800' : 'hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                            <div class="flex items-center justify-center w-9 h-9 rounded-md transition-all {{ request()->routeIs('mutasi.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'bg-slate-100 text-slate-500 group-hover:bg-blue-100 group-hover:text-blue-600 dark:bg-slate-800 dark:text-slate-400 dark:group-hover:bg-blue-500/20 dark:group-hover:text-blue-400' }}">
                                <i class="fas fa-exchange-alt text-sm"></i>
                            </div>
                            <span class="ms-3 font-semibold text-sm {{ request()->routeIs('mutasi.*') ? 'text-blue-700 dark:text-white' : 'text-slate-600 group-hover:text-blue-700 dark:text-slate-400 dark:group-hover:text-white' }}">Riwayat Mutasi</span>
                        </a>
                    </li>
                @endcan

                {{-- Administrasi --}}
                @canany(['user.view', 'role.view'])
                    <li class="px-3 pb-2 pt-4 text-[11px] font-bold tracking-widest text-slate-400 dark:text-slate-500 uppercase">
                        Administrasi
                    </li>
                @endcanany

                @can('user.view')
                    <li>
                        <a href="{{ route('users.index') }}" class="flex items-center p-2.5 rounded-lg transition-all group {{ request()->routeIs('users.*') ? 'bg-blue-50 dark:bg-slate-800' : 'hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                            <div class="flex items-center justify-center w-9 h-9 rounded-md transition-all {{ request()->routeIs('users.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'bg-slate-100 text-slate-500 group-hover:bg-blue-100 group-hover:text-blue-600 dark:bg-slate-800 dark:text-slate-400 dark:group-hover:bg-blue-500/20 dark:group-hover:text-blue-400' }}">
                                <i class="fas fa-users text-sm"></i>
                            </div>
                            <span class="ms-3 font-semibold text-sm {{ request()->routeIs('users.*') ? 'text-blue-700 dark:text-white' : 'text-slate-600 group-hover:text-blue-700 dark:text-slate-400 dark:group-hover:text-white' }}">Kelola Akun</span>
                        </a>
                    </li>
                @endcan

                @can('role.view')
                    <li>
                        <a href="{{ route('roles.index') }}" class="flex items-center p-2.5 rounded-lg transition-all group {{ request()->routeIs('roles.*') ? 'bg-blue-50 dark:bg-slate-800' : 'hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                            <div class="flex items-center justify-center w-9 h-9 rounded-md transition-all {{ request()->routeIs('roles.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'bg-slate-100 text-slate-500 group-hover:bg-blue-100 group-hover:text-blue-600 dark:bg-slate-800 dark:text-slate-400 dark:group-hover:bg-blue-500/20 dark:group-hover:text-blue-400' }}">
                                <i class="fas fa-user-shield text-sm"></i>
                            </div>
                            <span class="ms-3 font-semibold text-sm {{ request()->routeIs('roles.*') ? 'text-blue-700 dark:text-white' : 'text-slate-600 group-hover:text-blue-700 dark:text-slate-400 dark:group-hover:text-white' }}">Manajemen Role</span>
                        </a>
                    </li>
                @endcan

                {{-- Akun (semua user yang login) --}}
                <li class="px-3 pb-2 pt-4 text-[11px] font-bold tracking-widest text-slate-400 dark:text-slate-500 uppercase">
                    Akun
                </li>

                <li>
                    <a href="{{ route('profile.edit') }}" class="flex items-center p-2.5 rounded-lg transition-all group {{ request()->routeIs('profile.*') ? 'bg-blue-50 dark:bg-slate-800' : 'hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                        <div class="flex items-center justify-center w-9 h-9 rounded-md transition-all {{ request()->routeIs('profile.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'bg-slate-100 text-slate-500 group-hover:bg-blue-100 group-hover:text-blue-600 dark:bg-slate-800 dark:text-slate-400 dark:group-hover:bg-blue-500/20 dark:group-hover:text-blue-400' }}">
                            <i class="fas fa-user-cog text-sm"></i>
                        </div>
                        <span class="ms-3 font-semibold text-sm {{ request()->routeIs('profile.*') ? 'text-blue-700 dark:text-white' : 'text-slate-600 group-hover:text-blue-700 dark:text-slate-400 dark:group-hover:text-white' }}">Profil Saya</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Bagian Pusat Bantuan di Bawah (Fixed/Sticky di dalam Flex) -->
        <div class="p-4 mx-4 mb-4 mt-2 rounded-xl bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-500/10 dark:to-indigo-500/10 border border-blue-100/50 dark:border-blue-500/20 relative overflow-hidden flex-shrink-0 transition-colors">
            <div class="absolute -right-4 -top-4 w-16 h-16 bg-blue-500/10 dark:bg-blue-500/20 rounded-full blur-xl"></div>
            <div class="flex items-center gap-3 mb-2 relative z-10">
                <div class="w-8 h-8 bg-white dark:bg-slate-800 rounded-full flex items-center justify-center text-blue-600 dark:text-blue-400 shadow-sm">
                    <i class="fas fa-headset text-xs"></i>
                </div>
                <h6 class="text-sm font-bold text-slate-800 dark:text-white leading-tight">Pusat Bantuan</h6>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed relative z-10">Kendala pada sistem? Hubungi IT Support Pocari.</p>
        </div>

    </div>
</aside>