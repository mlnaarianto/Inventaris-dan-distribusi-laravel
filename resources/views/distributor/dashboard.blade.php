<x-app-layout>
    <x-slot name="header">
        Ruang Kerja Distributor
    </x-slot>

    @php
        $userId = auth()->id();

        // Menghitung statistik pesanan
        $totalPesanan = \App\Models\ProductRequest::where('user_id', $userId)->count();
        $pendingCount = \App\Models\ProductRequest::where('user_id', $userId)->where('status', 'pending')->count();
        $dikirimCount = \App\Models\ProductRequest::where('user_id', $userId)->where('status', 'dikirim')->count();
        $selesaiCount = \App\Models\ProductRequest::where('user_id', $userId)->where('status', 'selesai')->count();

        // Mengambil 5 pesanan terbaru
        $recentRequests = \App\Models\ProductRequest::with('details')
                            ->where('user_id', $userId)
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();
    @endphp

    <div class="space-y-6 mb-8">

        <div class="relative bg-gradient-to-br from-blue-600 to-indigo-800 rounded-3xl p-8 sm:p-10 overflow-hidden shadow-lg shadow-blue-500/20 text-white flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-10 w-40 h-40 bg-indigo-500/30 rounded-full blur-2xl"></div>

            <div class="relative z-10 w-full md:w-2/3">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 border border-white/20 text-blue-100 text-xs font-bold uppercase tracking-wide mb-4 backdrop-blur-md">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Portal Mitra Resmi
                </div>
                <h2 class="text-3xl sm:text-4xl font-extrabold mb-3 leading-tight">
                    Selamat Datang, <br><span class="text-blue-200">{{ auth()->user()->name }}</span>
                </h2>
                <p class="text-blue-100/80 text-sm sm:text-base max-w-lg leading-relaxed mb-6">
                    Pantau pengiriman stok Anda hari ini. Kelola inventaris dan ajukan permintaan barang ke gudang pusat dengan lebih cepat dan transparan.
                </p>
                <a href="{{ route('distributor.request.create') }}" class="inline-flex items-center justify-center px-6 py-3 text-sm font-bold text-blue-700 bg-white rounded-xl hover:bg-blue-50 transition-all hover:-translate-y-1 shadow-md">
                    <i class="fas fa-plus mr-2"></i> Buat Pesanan Baru
                </a>
            </div>

            <div class="relative z-10 hidden md:flex w-1/3 justify-end">
                <div class="w-40 h-40 bg-white/10 backdrop-blur-lg border border-white/20 rounded-3xl flex items-center justify-center transform rotate-3 hover:rotate-0 transition-transform duration-500">
                    <i class="fas fa-boxes text-7xl text-white/90 shadow-sm"></i>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex items-center gap-4">
                <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-500 text-2xl shrink-0">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pesanan</p>
                    <h4 class="text-2xl font-black text-slate-800">{{ $totalPesanan }}</h4>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex items-center gap-4">
                <div class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-500 text-2xl shrink-0">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pending</p>
                    <h4 class="text-2xl font-black text-slate-800">{{ $pendingCount }}</h4>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex items-center gap-4">
                <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-500 text-2xl shrink-0">
                    <i class="fas fa-truck-fast"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Diperjalanan</p>
                    <h4 class="text-2xl font-black text-slate-800">{{ $dikirimCount }}</h4>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex items-center gap-4">
                <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500 text-2xl shrink-0">
                    <i class="fas fa-check-double"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Telah Tiba</p>
                    <h4 class="text-2xl font-black text-slate-800">{{ $selesaiCount }}</h4>
                </div>
            </div>

        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <div>
                    <h5 class="text-lg font-bold text-slate-800">Aktivitas Pesanan Terakhir</h5>
                    <p class="text-sm text-slate-500">Pantau 5 pengajuan barang terakhir Anda.</p>
                </div>
                <a href="{{ route('distributor.request.index') }}" class="text-sm font-bold text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 px-4 py-2 rounded-xl transition-colors">
                    Lihat Semua
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-600">
                    <thead class="text-xs text-slate-400 uppercase bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4 font-bold">Kode Pesanan</th>
                            <th class="px-6 py-4 font-bold">Tanggal</th>
                            <th class="px-6 py-4 font-bold text-center">Total Item</th>
                            <th class="px-6 py-4 font-bold text-center">Status</th>
                            <th class="px-6 py-4 font-bold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentRequests as $req)
                            <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-bold text-slate-700">
                                    {{ $req->kode_request }}
                                </td>
                                <td class="px-6 py-4 text-slate-500 font-medium">
                                    {{ \Carbon\Carbon::parse($req->tanggal_request)->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4 text-center font-extrabold text-slate-700">
                                    {{ $req->details->sum('qty_diminta') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $badge = 'bg-orange-100 text-orange-600 border-orange-200';
                                        if ($req->status == 'diproses') $badge = 'bg-blue-100 text-blue-600 border-blue-200';
                                        if ($req->status == 'dikirim') $badge = 'bg-indigo-100 text-indigo-600 border-indigo-200';
                                        if ($req->status == 'selesai') $badge = 'bg-emerald-100 text-emerald-600 border-emerald-200';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md border text-[10px] font-bold uppercase tracking-wider {{ $badge }}">
                                        {{ $req->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('distributor.request.show', $req->id) }}" class="inline-flex items-center justify-center p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 mb-4 text-slate-400 text-2xl">
                                        <i class="fas fa-box-open"></i>
                                    </div>
                                    <p class="font-bold text-slate-600">Belum ada pengajuan</p>
                                    <p class="text-sm text-slate-400 mt-1">Anda belum membuat pesanan barang ke pusat.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
