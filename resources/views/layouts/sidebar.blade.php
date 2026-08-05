<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-slate-200 sm:translate-x-0 shadow-[4px_0_24px_rgba(0,0,0,0.02)]" aria-label="Sidebar">
    <div class="h-full flex flex-col justify-between bg-white">

        <!-- Bagian Menu yang Bisa Di-scroll -->
        <div class="px-4 overflow-y-auto flex-1 pb-4">
            <ul class="space-y-1.5 font-medium mt-2">
                <li class="px-3 pb-2 pt-2 text-[11px] font-bold tracking-widest text-slate-400 uppercase">
                    Menu Utama
                </li>

                @if(auth()->user()->role === 'pusat')
                    <li>
                        <a href="{{ route('dashboard') }}" class="flex items-center p-2.5 rounded-lg transition-all group {{ request()->routeIs('dashboard') ? 'bg-blue-50' : 'hover:bg-slate-50' }}">
                            <div class="flex items-center justify-center w-9 h-9 rounded-md transition-all {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'bg-slate-100 text-slate-500 group-hover:bg-blue-100 group-hover:text-blue-600' }}">
                                <i class="fas fa-chart-pie text-sm"></i>
                            </div>
                            <span class="ms-3 font-semibold text-sm {{ request()->routeIs('dashboard') ? 'text-blue-700' : 'text-slate-600 group-hover:text-blue-700' }}">Dashboard Pusat</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('pusat.produk.index') }}" class="flex items-center p-2.5 rounded-lg transition-all group {{ request()->routeIs('pusat.produk.*') ? 'bg-blue-50' : 'hover:bg-slate-50' }}">
                            <div class="flex items-center justify-center w-9 h-9 rounded-md transition-all {{ request()->routeIs('pusat.produk.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'bg-slate-100 text-slate-500 group-hover:bg-blue-100 group-hover:text-blue-600' }}">
                                <i class="fas fa-boxes text-sm"></i>
                            </div>
                            <span class="ms-3 font-semibold text-sm {{ request()->routeIs('pusat.produk.*') ? 'text-blue-700' : 'text-slate-600 group-hover:text-blue-700' }}">Katalog Barang</span>
                        </a>
                    </li>

                    <li class="px-3 pb-2 pt-4 text-[11px] font-bold tracking-widest text-slate-400 uppercase">
                        Alur Pesanan
                    </li>

                    <li>
                        <a href="{{ route('pusat.request.index', ['status' => 'pending']) }}" class="flex items-center p-2.5 rounded-lg transition-all group {{ request('status') == 'pending' ? 'bg-orange-50' : 'hover:bg-slate-50' }}">
                            <div class="flex items-center justify-center w-9 h-9 rounded-md transition-all {{ request('status') == 'pending' ? 'bg-orange-500 text-white shadow-md shadow-orange-500/20' : 'bg-slate-100 text-slate-500 group-hover:bg-orange-100 group-hover:text-orange-600' }}">
                                <i class="fas fa-clock text-sm"></i>
                            </div>
                            <span class="ms-3 font-semibold text-sm {{ request('status') == 'pending' ? 'text-orange-700' : 'text-slate-600 group-hover:text-orange-600' }}">Pesanan Baru</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('pusat.request.index', ['status' => 'diproses']) }}" class="flex items-center p-2.5 rounded-lg transition-all group {{ request('status') == 'diproses' ? 'bg-blue-50' : 'hover:bg-slate-50' }}">
                            <div class="flex items-center justify-center w-9 h-9 rounded-md transition-all {{ request('status') == 'diproses' ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'bg-slate-100 text-slate-500 group-hover:bg-blue-100 group-hover:text-blue-600' }}">
                                <i class="fas fa-box-open text-sm"></i>
                            </div>
                            <span class="ms-3 font-semibold text-sm {{ request('status') == 'diproses' ? 'text-blue-700' : 'text-slate-600 group-hover:text-blue-700' }}">Siap Kirim</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('pusat.request.index', ['status' => 'dikirim']) }}" class="flex items-center p-2.5 rounded-lg transition-all group {{ request('status') == 'dikirim' ? 'bg-indigo-50' : 'hover:bg-slate-50' }}">
                            <div class="flex items-center justify-center w-9 h-9 rounded-md transition-all {{ request('status') == 'dikirim' ? 'bg-indigo-500 text-white shadow-md shadow-indigo-500/20' : 'bg-slate-100 text-slate-500 group-hover:bg-indigo-100 group-hover:text-indigo-600' }}">
                                <i class="fas fa-truck text-sm"></i>
                            </div>
                            <span class="ms-3 font-semibold text-sm {{ request('status') == 'dikirim' ? 'text-indigo-700' : 'text-slate-600 group-hover:text-indigo-700' }}">Sedang Dikirim</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('pusat.request.index', ['status' => 'selesai']) }}" class="flex items-center p-2.5 rounded-lg transition-all group {{ request('status') == 'selesai' ? 'bg-emerald-50' : 'hover:bg-slate-50' }}">
                            <div class="flex items-center justify-center w-9 h-9 rounded-md transition-all {{ request('status') == 'selesai' ? 'bg-emerald-500 text-white shadow-md shadow-emerald-500/20' : 'bg-slate-100 text-slate-500 group-hover:bg-emerald-100 group-hover:text-emerald-600' }}">
                                <i class="fas fa-check-circle text-sm"></i>
                            </div>
                            <span class="ms-3 font-semibold text-sm {{ request('status') == 'selesai' ? 'text-emerald-700' : 'text-slate-600 group-hover:text-emerald-700' }}">Riwayat Selesai</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('pusat.request.index') }}" class="flex items-center p-2.5 rounded-lg transition-all group {{ request()->routeIs('pusat.request.index') && !request()->has('status') ? 'bg-slate-100' : 'hover:bg-slate-50' }}">
                            <div class="flex items-center justify-center w-9 h-9 rounded-md transition-all {{ request()->routeIs('pusat.request.index') && !request()->has('status') ? 'bg-slate-600 text-white shadow-md shadow-slate-500/20' : 'bg-slate-100 text-slate-500 group-hover:bg-slate-200 group-hover:text-slate-700' }}">
                                <i class="fas fa-list-ul text-sm"></i>
                            </div>
                            <span class="ms-3 font-semibold text-sm {{ request()->routeIs('pusat.request.index') && !request()->has('status') ? 'text-slate-800' : 'text-slate-600 group-hover:text-slate-800' }}">Semua Transaksi</span>
                        </a>
                    </li>

                    <li class="px-3 pb-2 pt-4 text-[11px] font-bold tracking-widest text-slate-400 uppercase">
                        Pelaporan
                    </li>

                    <li>
                        <a href="{{ route('pusat.mutasi.index') }}" class="flex items-center p-2.5 rounded-lg transition-all group {{ request()->routeIs('pusat.mutasi.*') ? 'bg-blue-50' : 'hover:bg-slate-50' }}">
                            <div class="flex items-center justify-center w-9 h-9 rounded-md transition-all {{ request()->routeIs('pusat.mutasi.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'bg-slate-100 text-slate-500 group-hover:bg-blue-100 group-hover:text-blue-600' }}">
                                <i class="fas fa-exchange-alt text-sm"></i>
                            </div>
                            <span class="ms-3 font-semibold text-sm {{ request()->routeIs('pusat.mutasi.*') ? 'text-blue-700' : 'text-slate-600 group-hover:text-blue-700' }}">Riwayat Mutasi</span>
                        </a>
                    </li>

                    <!-- MENU BARU: Prediksi Stok AI -->
                    <li>
                        <a href="{{ route('pusat.prediksi.index') }}" class="flex items-center p-2.5 rounded-lg transition-all group {{ request()->routeIs('pusat.prediksi.*') ? 'bg-blue-50' : 'hover:bg-slate-50' }}">
                            <div class="flex items-center justify-center w-9 h-9 rounded-md transition-all {{ request()->routeIs('pusat.prediksi.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'bg-slate-100 text-slate-500 group-hover:bg-blue-100 group-hover:text-blue-600' }}">
                                <i class="fas fa-brain text-sm"></i>
                            </div>
                            <span class="ms-3 font-semibold text-sm {{ request()->routeIs('pusat.prediksi.*') ? 'text-blue-700' : 'text-slate-600 group-hover:text-blue-700' }}">Prediksi Stok (AI)</span>
                        </a>
                    </li>
                @else
                    <li>
                        <a href="{{ route('dashboard') }}" class="flex items-center p-2.5 rounded-lg transition-all group {{ request()->routeIs('dashboard') ? 'bg-blue-50' : 'hover:bg-slate-50' }}">
                            <div class="flex items-center justify-center w-9 h-9 rounded-md transition-all {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'bg-slate-100 text-slate-500 group-hover:bg-blue-100 group-hover:text-blue-600' }}">
                                <i class="fas fa-chart-pie text-sm"></i>
                            </div>
                            <span class="ms-3 font-semibold text-sm {{ request()->routeIs('dashboard') ? 'text-blue-700' : 'text-slate-600 group-hover:text-blue-700' }}">Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('distributor.request.create') }}" class="flex items-center p-2.5 rounded-lg transition-all group {{ request()->routeIs('distributor.request.create') ? 'bg-blue-50' : 'hover:bg-slate-50' }}">
                            <div class="flex items-center justify-center w-9 h-9 rounded-md transition-all {{ request()->routeIs('distributor.request.create') ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'bg-slate-100 text-slate-500 group-hover:bg-blue-100 group-hover:text-blue-600' }}">
                                <i class="fas fa-cart-plus text-sm"></i>
                            </div>
                            <span class="ms-3 font-semibold text-sm {{ request()->routeIs('distributor.request.create') ? 'text-blue-700' : 'text-slate-600 group-hover:text-blue-700' }}">Buat Pesanan Baru</span>
                        </a>
                    </li>

                    <li class="px-3 pb-2 pt-4 text-[11px] font-bold tracking-widest text-slate-400 uppercase">
                        Pantau Pesanan
                    </li>

                    <li>
                        <a href="{{ route('distributor.request.index', ['status' => 'pending']) }}" class="flex items-center p-2.5 rounded-lg transition-all group {{ request('status') == 'pending' ? 'bg-orange-50' : 'hover:bg-slate-50' }}">
                            <div class="flex items-center justify-center w-9 h-9 rounded-md transition-all {{ request('status') == 'pending' ? 'bg-orange-500 text-white shadow-md shadow-orange-500/20' : 'bg-slate-100 text-slate-500 group-hover:bg-orange-100 group-hover:text-orange-600' }}">
                                <i class="fas fa-clock text-sm"></i>
                            </div>
                            <span class="ms-3 font-semibold text-sm {{ request('status') == 'pending' ? 'text-orange-700' : 'text-slate-600 group-hover:text-orange-600' }}">Menunggu Pusat</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('distributor.request.index', ['status' => 'diproses']) }}" class="flex items-center p-2.5 rounded-lg transition-all group {{ request('status') == 'diproses' ? 'bg-blue-50' : 'hover:bg-slate-50' }}">
                            <div class="flex items-center justify-center w-9 h-9 rounded-md transition-all {{ request('status') == 'diproses' ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'bg-slate-100 text-slate-500 group-hover:bg-blue-100 group-hover:text-blue-600' }}">
                                <i class="fas fa-box-open text-sm"></i>
                            </div>
                            <span class="ms-3 font-semibold text-sm {{ request('status') == 'diproses' ? 'text-blue-700' : 'text-slate-600 group-hover:text-blue-700' }}">Sedang Diproses</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('distributor.request.index', ['status' => 'dikirim']) }}" class="flex items-center p-2.5 rounded-lg transition-all group {{ request('status') == 'dikirim' ? 'bg-indigo-50' : 'hover:bg-slate-50' }}">
                            <div class="flex items-center justify-center w-9 h-9 rounded-md transition-all {{ request('status') == 'dikirim' ? 'bg-indigo-500 text-white shadow-md shadow-indigo-500/20' : 'bg-slate-100 text-slate-500 group-hover:bg-indigo-100 group-hover:text-indigo-600' }}">
                                <i class="fas fa-truck text-sm"></i>
                            </div>
                            <span class="ms-3 font-semibold text-sm {{ request('status') == 'dikirim' ? 'text-indigo-700' : 'text-slate-600 group-hover:text-indigo-700' }}">Dalam Perjalanan</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('distributor.request.index', ['status' => 'selesai']) }}" class="flex items-center p-2.5 rounded-lg transition-all group {{ request('status') == 'selesai' ? 'bg-emerald-50' : 'hover:bg-slate-50' }}">
                            <div class="flex items-center justify-center w-9 h-9 rounded-md transition-all {{ request('status') == 'selesai' ? 'bg-emerald-500 text-white shadow-md shadow-emerald-500/20' : 'bg-slate-100 text-slate-500 group-hover:bg-emerald-100 group-hover:text-emerald-600' }}">
                                <i class="fas fa-check-circle text-sm"></i>
                            </div>
                            <span class="ms-3 font-semibold text-sm {{ request('status') == 'selesai' ? 'text-emerald-700' : 'text-slate-600 group-hover:text-emerald-700' }}">Pesanan Selesai</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('distributor.request.index') }}" class="flex items-center p-2.5 rounded-lg transition-all group {{ request()->routeIs('distributor.request.index') && !request()->has('status') ? 'bg-slate-100' : 'hover:bg-slate-50' }}">
                            <div class="flex items-center justify-center w-9 h-9 rounded-md transition-all {{ request()->routeIs('distributor.request.index') && !request()->has('status') ? 'bg-slate-600 text-white shadow-md shadow-slate-500/20' : 'bg-slate-100 text-slate-500 group-hover:bg-slate-200 group-hover:text-slate-700' }}">
                                <i class="fas fa-list-ul text-sm"></i>
                            </div>
                            <span class="ms-3 font-semibold text-sm {{ request()->routeIs('distributor.request.index') && !request()->has('status') ? 'text-slate-800' : 'text-slate-600 group-hover:text-slate-800' }}">Semua Pesanan</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>

        <!-- Bagian Pusat Bantuan di Bawah (Fixed/Sticky di dalam Flex) -->
        <div class="p-4 mx-4 mb-4 mt-2 rounded-xl bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100/50 relative overflow-hidden flex-shrink-0">
            <div class="absolute -right-4 -top-4 w-16 h-16 bg-blue-500/10 rounded-full blur-xl"></div>
            <div class="flex items-center gap-3 mb-2 relative z-10">
                <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-blue-600 shadow-sm">
                    <i class="fas fa-headset text-xs"></i>
                </div>
                <h6 class="text-sm font-bold text-slate-800 leading-tight">Pusat Bantuan</h6>
            </div>
            <p class="text-xs text-slate-500 leading-relaxed relative z-10">Kendala pada sistem? Hubungi IT Support Pocari.</p>
        </div>

    </div>
</aside>