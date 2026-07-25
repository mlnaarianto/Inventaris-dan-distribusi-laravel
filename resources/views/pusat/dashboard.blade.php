<x-app-layout>
    <x-slot name="header">
        Dashboard Pusat
    </x-slot>

    <div class="mb-8 relative overflow-hidden bg-gradient-to-r from-blue-700 to-indigo-800 rounded-2xl p-8 shadow-lg text-white flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-blue-400/20 rounded-full blur-3xl"></div>

        <div class="relative z-10 md:w-2/3">
            <span class="inline-block py-1 px-3 rounded-full bg-white/20 text-white text-xs font-bold tracking-wider uppercase mb-3 border border-white/30">
                Otoritas Gudang Utama
            </span>
            <h2 class="text-3xl font-extrabold mb-2">Selamat Datang, {{ Auth::user()->name }}!</h2>
            <p class="text-blue-100 text-sm leading-relaxed max-w-xl">
                Sistem Informasi Manajemen Persediaan dan Distribusi Barang Pocari Sweat berjalan normal. Anda memiliki kendali penuh untuk memantau stok fisik dan menyetujui permintaan dari distributor.
            </p>
        </div>

        <div class="relative z-10 md:w-1/3 text-left md:text-right flex flex-col sm:flex-row md:flex-col gap-3 justify-end">
            <a href="{{ route('pusat.produk.index') }}" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-bold text-blue-800 bg-white rounded-xl shadow-md hover:bg-slate-50 hover:shadow-lg transition-all text-center">
                <i class="fas fa-boxes mr-2"></i> Kelola Master Barang
            </a>
            <a href="{{ route('pusat.request.index') }}" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-bold text-white bg-white/20 border border-white/30 rounded-xl hover:bg-white/30 transition-all text-center">
                <i class="fas fa-clipboard-check mr-2"></i> Validasi Orderan
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 flex items-center gap-5 hover:shadow-md transition-shadow">
            <div class="w-14 h-14 rounded-xl flex items-center justify-center bg-blue-50 text-blue-600 shrink-0">
                <i class="fas fa-box text-2xl"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Katalog Produk</p>
                <h4 class="text-2xl font-extrabold text-slate-700">
                    {{ $totalProduk ?? 0 }} <span class="text-sm font-medium text-slate-400">Jenis</span>
                </h4>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 flex items-center gap-5 hover:shadow-md transition-shadow">
            <div class="w-14 h-14 rounded-xl flex items-center justify-center bg-emerald-50 text-emerald-500 shrink-0">
                <i class="fas fa-warehouse text-2xl"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Volume Stok Pusat</p>
                <h4 class="text-2xl font-extrabold text-slate-700">
                    {{ $totalStok ?? 0 }} <span class="text-sm font-medium text-slate-400">Unit</span>
                </h4>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 flex items-center gap-5 hover:shadow-md transition-shadow">
            <div class="w-14 h-14 rounded-xl flex items-center justify-center bg-orange-50 text-orange-500 shrink-0">
                <i class="fas fa-shopping-cart text-2xl"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Request Pending</p>
                <h4 class="text-2xl font-extrabold text-slate-700">
                    {{ $requestPending ?? 0 }} <span class="text-sm font-medium text-slate-400">Antrean</span>
                </h4>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 flex items-center gap-5 hover:shadow-md transition-shadow">
            <div class="w-14 h-14 rounded-xl flex items-center justify-center bg-indigo-50 text-indigo-500 shrink-0">
                <i class="fas fa-truck-loading text-2xl"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Distribusi</p>
                <h4 class="text-2xl font-extrabold text-slate-700">
                    {{ $mutasiKeluar ?? 0 }} <span class="text-sm font-medium text-slate-400">Aktivitas</span>
                </h4>
            </div>
        </div>
    </div>
</x-app-layout>
