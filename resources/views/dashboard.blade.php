<x-app-layout>
    <x-slot name="header">
        {{ $viewAll ? 'Dashboard Pusat' : 'Ruang Kerja Distributor' }}
    </x-slot>

    @php
        $badgeMap = [
            'pending'  => 'bg-orange-100 text-orange-600 border-orange-200',
            'diproses' => 'bg-blue-100 text-blue-600 border-blue-200',
            'dikirim'  => 'bg-indigo-100 text-indigo-600 border-indigo-200',
            'selesai'  => 'bg-emerald-100 text-emerald-600 border-emerald-200',
        ];

        // Kartu ringkasan order (label menyesuaikan sisi pusat / distributor)
        $kartuOrder = [
            ['label' => 'Total Pesanan', 'nilai' => $stat['total'],   'icon' => 'fa-clipboard-list', 'bg' => 'bg-slate-50',   'warna' => 'text-slate-500'],
            ['label' => $viewAll ? 'Request Pending' : 'Menunggu Pusat', 'nilai' => $stat['pending'], 'icon' => 'fa-clock', 'bg' => 'bg-orange-50', 'warna' => 'text-orange-500'],
            ['label' => $viewAll ? 'Sedang Dikirim' : 'Diperjalanan', 'nilai' => $stat['dikirim'], 'icon' => 'fa-truck-fast', 'bg' => 'bg-indigo-50', 'warna' => 'text-indigo-500'],
            ['label' => $viewAll ? 'Order Selesai' : 'Telah Tiba', 'nilai' => $stat['selesai'], 'icon' => 'fa-check-double', 'bg' => 'bg-emerald-50', 'warna' => 'text-emerald-500'],
        ];
    @endphp

    <div class="space-y-6 mb-8">

        {{-- Banner --}}
        <div class="relative bg-gradient-to-br from-blue-600 to-indigo-800 rounded-3xl p-8 sm:p-10 overflow-hidden shadow-lg shadow-blue-500/20 text-white flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-10 w-40 h-40 bg-indigo-500/30 rounded-full blur-2xl"></div>

            <div class="relative z-10 w-full md:w-2/3">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 border border-white/20 text-blue-100 text-xs font-bold uppercase tracking-wide mb-4 backdrop-blur-md">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    {{ $viewAll ? 'Otoritas Gudang Utama' : 'Portal Mitra Resmi' }}
                </div>
                <h2 class="text-3xl sm:text-4xl font-extrabold mb-3 leading-tight">
                    Selamat Datang, <br><span class="text-blue-200">{{ auth()->user()->name }}</span>
                </h2>
                <p class="text-blue-100/80 text-sm sm:text-base max-w-lg leading-relaxed mb-6">
                    @if ($viewAll)
                        Pantau stok fisik gudang, validasi permintaan distributor, dan proses pengiriman barang dari satu tempat.
                    @else
                        Pantau pengiriman stok Anda hari ini dan ajukan permintaan barang ke gudang pusat dengan lebih cepat dan transparan.
                    @endif
                </p>

                <div class="flex flex-wrap gap-3">
                    @can('request.create')
                        <a href="{{ route('request.create') }}" class="inline-flex items-center justify-center px-6 py-3 text-sm font-bold text-blue-700 bg-white rounded-xl hover:bg-blue-50 transition-all hover:-translate-y-1 shadow-md">
                            <i class="fas fa-plus mr-2"></i> Buat Pesanan Baru
                        </a>
                    @endcan
                    @can('request.view-all')
                        <a href="{{ route('request.index', ['status' => 'pending']) }}" class="inline-flex items-center justify-center px-6 py-3 text-sm font-bold text-white bg-white/20 border border-white/30 rounded-xl hover:bg-white/30 transition-all">
                            <i class="fas fa-clipboard-check mr-2"></i> Validasi Orderan
                        </a>
                    @endcan
                    @can('produk.view')
                        <a href="{{ route('produk.index') }}" class="inline-flex items-center justify-center px-6 py-3 text-sm font-bold text-white bg-white/20 border border-white/30 rounded-xl hover:bg-white/30 transition-all">
                            <i class="fas fa-boxes mr-2"></i> Katalog Barang
                        </a>
                    @endcan
                </div>
            </div>

            <div class="relative z-10 hidden md:flex w-1/3 justify-end">
                <div class="w-40 h-40 bg-white/10 backdrop-blur-lg border border-white/20 rounded-3xl flex items-center justify-center transform rotate-3 hover:rotate-0 transition-transform duration-500">
                    <i class="fas {{ $viewAll ? 'fa-warehouse' : 'fa-boxes' }} text-7xl text-white/90"></i>
                </div>
            </div>
        </div>

        {{-- Statistik gudang (hanya yang punya request.view-all) --}}
        @if ($gudang)
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex items-center gap-4">
                    <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 text-2xl shrink-0"><i class="fas fa-box"></i></div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Katalog Produk</p>
                        <h4 class="text-2xl font-black text-slate-800">{{ number_format($gudang['totalProduk'], 0, ',', '.') }} <span class="text-sm font-medium text-slate-400">Jenis</span></h4>
                    </div>
                </div>
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex items-center gap-4">
                    <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500 text-2xl shrink-0"><i class="fas fa-warehouse"></i></div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Volume Stok Pusat</p>
                        <h4 class="text-2xl font-black text-slate-800">{{ number_format($gudang['totalStok'], 0, ',', '.') }} <span class="text-sm font-medium text-slate-400">Unit</span></h4>
                    </div>
                </div>
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex items-center gap-4">
                    <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-500 text-2xl shrink-0"><i class="fas fa-truck-loading"></i></div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Distribusi</p>
                        <h4 class="text-2xl font-black text-slate-800">{{ number_format($gudang['mutasiKeluar'], 0, ',', '.') }} <span class="text-sm font-medium text-slate-400">Aktivitas</span></h4>
                    </div>
                </div>
            </div>
        @endif

        {{-- Ringkasan order --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($kartuOrder as $k)
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex items-center gap-4">
                    <div class="w-14 h-14 {{ $k['bg'] }} rounded-2xl flex items-center justify-center {{ $k['warna'] }} text-2xl shrink-0">
                        <i class="fas {{ $k['icon'] }}"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">{{ $k['label'] }}</p>
                        <h4 class="text-2xl font-black text-slate-800">{{ number_format($k['nilai'], 0, ',', '.') }}</h4>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Aktivitas terakhir --}}
        @can('request.view')
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <div>
                        <h5 class="text-lg font-bold text-slate-800">Aktivitas Pesanan Terakhir</h5>
                        <p class="text-sm text-slate-500">
                            {{ $viewAll ? '5 order terbaru dari seluruh distributor.' : 'Pantau 5 pengajuan barang terakhir Anda.' }}
                        </p>
                    </div>
                    <a href="{{ route('request.index') }}" class="text-sm font-bold text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 px-4 py-2 rounded-xl transition-colors">
                        Lihat Semua
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-600">
                        <thead class="text-xs text-slate-400 uppercase bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-4 font-bold">Kode Pesanan</th>
                                @if ($viewAll)
                                    <th class="px-6 py-4 font-bold">Distributor</th>
                                @endif
                                <th class="px-6 py-4 font-bold">Tanggal</th>
                                <th class="px-6 py-4 font-bold text-center">Total Item</th>
                                <th class="px-6 py-4 font-bold text-center">Status</th>
                                <th class="px-6 py-4 font-bold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentRequests as $req)
                                <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 font-bold text-slate-700">{{ $req->kode_request }}</td>
                                    @if ($viewAll)
                                        <td class="px-6 py-4 font-semibold text-slate-600">{{ $req->user?->name ?? 'Tidak Valid' }}</td>
                                    @endif
                                    <td class="px-6 py-4 text-slate-500 font-medium">{{ \Carbon\Carbon::parse($req->tanggal_request)->format('d M Y, H:i') }}</td>
                                    <td class="px-6 py-4 text-center font-extrabold text-slate-700">{{ $req->details->sum('qty_diminta') }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md border text-[10px] font-bold uppercase tracking-wider {{ $badgeMap[$req->status] ?? 'bg-slate-100 text-slate-600 border-slate-200' }}">
                                            {{ $req->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('request.show', $req->id) }}" class="inline-flex items-center justify-center p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all">
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $viewAll ? 6 : 5 }}" class="px-6 py-12 text-center">
                                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 mb-4 text-slate-400 text-2xl">
                                            <i class="fas fa-box-open"></i>
                                        </div>
                                        <p class="font-bold text-slate-600">Belum ada pengajuan</p>
                                        <p class="text-sm text-slate-400 mt-1">
                                            {{ $viewAll ? 'Belum ada order dari distributor.' : 'Anda belum membuat pesanan barang ke pusat.' }}
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endcan

    </div>
</x-app-layout>