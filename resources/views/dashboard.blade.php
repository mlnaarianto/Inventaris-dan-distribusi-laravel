<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>
    <x-slot name="header">
        {{ $dashboardAll ? 'Dashboard Pusat' : 'Ruang Kerja Distributor' }}
    </x-slot>

    @php
    $badgeMap = [
    'pending' => 'bg-orange-100 text-orange-700 border-orange-200 dark:bg-orange-500/15 dark:text-orange-400 dark:border-orange-500/30',
    'diproses' => 'bg-blue-100 text-blue-700 border-blue-200 dark:bg-blue-500/15 dark:text-blue-400 dark:border-blue-500/30',
    'dikirim' => 'bg-indigo-100 text-indigo-700 border-indigo-200 dark:bg-indigo-500/15 dark:text-indigo-400 dark:border-indigo-500/30',
    'selesai' => 'bg-emerald-100 text-emerald-700 border-emerald-200 dark:bg-emerald-500/15 dark:text-emerald-400 dark:border-emerald-500/30',
    ];

    $kartuOrder = [
    ['label' => 'Total Pesanan', 'nilai' => $stat['total'], 'icon' => 'fa-clipboard-list', 'bg' => 'bg-slate-100 dark:bg-slate-700/40', 'warna' => 'text-slate-600 dark:text-slate-300'],
    ['label' => $dashboardAll ? 'Request Pending' : 'Menunggu Pusat', 'nilai' => $stat['pending'], 'icon' => 'fa-clock', 'bg' => 'bg-orange-100 dark:bg-orange-500/15', 'warna' => 'text-orange-600 dark:text-orange-400'],
    ['label' => $dashboardAll ? 'Sedang Dikirim' : 'Diperjalanan', 'nilai' => $stat['dikirim'], 'icon' => 'fa-truck-fast', 'bg' => 'bg-indigo-100 dark:bg-indigo-500/15', 'warna' => 'text-indigo-600 dark:text-indigo-400'],
    ['label' => $dashboardAll ? 'Order Selesai' : 'Telah Tiba', 'nilai' => $stat['selesai'], 'icon' => 'fa-check-double', 'bg' => 'bg-emerald-100 dark:bg-emerald-500/15', 'warna' => 'text-emerald-600 dark:text-emerald-400'],
    ];

    // Progress bar percentage (read-only, tidak ubah $stat)
    $totalForBar = max((int) ($stat['total'] ?? 0), 1);
    $pctPending = round((($stat['pending'] ?? 0) / $totalForBar) * 100);
    $pctDikirim = round((($stat['dikirim'] ?? 0) / $totalForBar) * 100);
    $pctSelesai = round((($stat['selesai'] ?? 0) / $totalForBar) * 100);
    $pctDiproses = max(0, 100 - $pctPending - $pctDikirim - $pctSelesai);
    @endphp

    <div class="space-y-5 mb-8">

        {{-- ============ BANNER / HERO ============ --}}
        <div class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 dark:from-blue-700 dark:via-indigo-800 dark:to-slate-900 rounded-2xl p-5 sm:p-8 overflow-hidden shadow-lg shadow-blue-500/20 dark:shadow-black/40">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-10 w-40 h-40 bg-indigo-400/20 rounded-full blur-2xl"></div>
            <div class="absolute top-6 right-6 w-2 h-2 bg-white/40 rounded-full"></div>
            <div class="absolute top-16 right-24 w-1.5 h-1.5 bg-white/30 rounded-full"></div>

            <div class="relative z-10 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">

                {{-- Text & CTA --}}
                <div class="w-full lg:w-2/3 min-w-0">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-blue-50 text-[10px] font-bold uppercase tracking-widest mb-4 backdrop-blur-md">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        {{ $dashboardAll ? 'Otoritas Gudang Utama' : 'Portal Mitra Resmi' }}
                    </div>

                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold mb-2 leading-tight text-white">
                        Selamat Datang, {{ auth()->user()->name }} 👋
                    </h2>
                    <p class="text-blue-100/90 text-sm sm:text-base max-w-xl leading-relaxed mb-5">
                        @if ($dashboardAll)
                        Pantau stok fisik gudang, validasi permintaan distributor, dan proses pengiriman barang dari satu tempat.
                        @else
                        Pantau pengiriman stok Anda hari ini dan ajukan permintaan barang ke gudang pusat dengan lebih cepat dan transparan.
                        @endif
                    </p>

                    <div class="flex flex-wrap gap-2">
                        @can('request.create')
                        <a href="{{ route('request.create') }}"
                            class="inline-flex items-center px-4 py-2.5 text-sm font-bold text-blue-700 dark:text-blue-900 bg-white hover:bg-blue-50 rounded-xl transition-all hover:-translate-y-0.5 shadow-md">
                            <i class="fas fa-plus mr-2 text-xs"></i> Buat Pesanan
                        </a>
                        @endcan
                        @can('request.update-status')
                        <a href="{{ route('request.index', ['status' => 'pending']) }}"
                            class="inline-flex items-center px-4 py-2.5 text-sm font-bold text-white bg-white/15 border border-white/25 rounded-xl hover:bg-white/25 backdrop-blur-sm transition-all hover:-translate-y-0.5">
                            <i class="fas fa-clipboard-check mr-2 text-xs"></i> Validasi Order
                        </a>
                        @endcan
                        @can('produk.view')
                        <a href="{{ route('produk.index') }}"
                            class="inline-flex items-center px-4 py-2.5 text-sm font-bold text-white bg-white/15 border border-white/25 rounded-xl hover:bg-white/25 backdrop-blur-sm transition-all hover:-translate-y-0.5">
                            <i class="fas fa-boxes mr-2 text-xs"></i> Katalog
                        </a>
                        @endcan
                    </div>
                </div>

                {{-- Mini stats + logo panel --}}
                <div class="w-full lg:w-1/3 flex items-center gap-3">
                    <div class="grid grid-cols-2 gap-2 flex-1">
                        <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl p-3 text-center">
                            <p class="text-[9px] font-bold text-blue-100 uppercase tracking-wider">Total</p>
                            <p class="text-xl font-black text-white leading-tight">{{ number_format($stat['total'] ?? 0, 0, ',', '.') }}</p>
                            <p class="text-[9px] text-blue-100/70">Pesanan</p>
                        </div>
                        <div class="bg-emerald-500/20 backdrop-blur-md border border-emerald-300/30 rounded-xl p-3 text-center">
                            <p class="text-[9px] font-bold text-emerald-200 uppercase tracking-wider">Selesai</p>
                            <p class="text-xl font-black text-emerald-300 leading-tight">{{ number_format($stat['selesai'] ?? 0, 0, ',', '.') }}</p>
                            <p class="text-[9px] text-emerald-100/70">Order</p>
                        </div>
                    </div>

                    {{-- Logo Panel: SELALU PUTIH --}}
                    <div class="hidden lg:flex w-24 h-24 shrink-0 bg-white rounded-2xl p-2 shadow-xl shadow-black/20 border-2 border-white items-center justify-center transform rotate-3 hover:rotate-0 transition-transform duration-500 overflow-hidden">
                        <img src="{{ asset('assets/123.jpg') }}" alt="Logo PT. Amerta Indah Otsuka" class="w-full h-full object-contain">
                    </div>
                </div>
            </div>
        </div>

        {{-- ============ STATISTIK GUDANG (PUSAT ONLY) ============ --}}
        @if ($gudang)
        <div>
            <div class="flex items-center gap-2 mb-3">
                <div class="w-1 h-5 rounded-full bg-blue-600 dark:bg-blue-500"></div>
                <h6 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider">Ringkasan Gudang</h6>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-5">
                <div class="group bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md dark:hover:border-slate-600 transition-all flex items-center gap-4 relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 w-16 h-16 bg-blue-500/5 rounded-full blur-xl group-hover:bg-blue-500/10 transition-colors"></div>
                    <div class="w-14 h-14 bg-blue-50 dark:bg-blue-500/15 rounded-2xl flex items-center justify-center text-blue-600 dark:text-blue-400 text-2xl shrink-0 group-hover:scale-110 transition-transform">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Katalog Produk</p>
                        <h4 class="text-2xl font-black text-slate-800 dark:text-white leading-tight truncate">
                            {{ number_format($gudang['totalProduk'], 0, ',', '.') }}
                            <span class="text-sm font-medium text-slate-400 dark:text-slate-500">Jenis</span>
                        </h4>
                    </div>
                </div>
                <div class="group bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md dark:hover:border-slate-600 transition-all flex items-center gap-4 relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 w-16 h-16 bg-emerald-500/5 rounded-full blur-xl group-hover:bg-emerald-500/10 transition-colors"></div>
                    <div class="w-14 h-14 bg-emerald-50 dark:bg-emerald-500/15 rounded-2xl flex items-center justify-center text-emerald-500 dark:text-emerald-400 text-2xl shrink-0 group-hover:scale-110 transition-transform">
                        <i class="fas fa-warehouse"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Volume Stok Pusat</p>
                        <h4 class="text-2xl font-black text-slate-800 dark:text-white leading-tight truncate">
                            {{ number_format($gudang['totalStok'], 0, ',', '.') }}
                            <span class="text-sm font-medium text-slate-400 dark:text-slate-500">Unit</span>
                        </h4>
                    </div>
                </div>
                <div class="group bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md dark:hover:border-slate-600 transition-all flex items-center gap-4 relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 w-16 h-16 bg-indigo-500/5 rounded-full blur-xl group-hover:bg-indigo-500/10 transition-colors"></div>
                    <div class="w-14 h-14 bg-indigo-50 dark:bg-indigo-500/15 rounded-2xl flex items-center justify-center text-indigo-500 dark:text-indigo-400 text-2xl shrink-0 group-hover:scale-110 transition-transform">
                        <i class="fas fa-truck-loading"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Total Distribusi</p>
                        <h4 class="text-2xl font-black text-slate-800 dark:text-white leading-tight truncate">
                            {{ number_format($gudang['mutasiKeluar'], 0, ',', '.') }}
                            <span class="text-sm font-medium text-slate-400 dark:text-slate-500">Aktivitas</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- ============ RINGKASAN ORDER + DISTRIBUSI STATUS ============ --}}
        <div>
            <div class="flex items-center gap-2 mb-3">
                <div class="w-1 h-5 rounded-full bg-indigo-600 dark:bg-indigo-500"></div>
                <h6 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider">Ringkasan Pesanan</h6>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-5">
                @foreach ($kartuOrder as $k)
                <div class="group bg-white dark:bg-slate-800 rounded-2xl p-4 sm:p-5 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md dark:hover:border-slate-600 transition-all">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-11 h-11 {{ $k['bg'] }} rounded-xl flex items-center justify-center {{ $k['warna'] }} text-lg shrink-0 group-hover:scale-110 transition-transform">
                            <i class="fas {{ $k['icon'] }}"></i>
                        </div>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">{{ $k['label'] }}</p>
                        <h4 class="text-2xl sm:text-3xl font-black text-slate-800 dark:text-white leading-tight">{{ number_format($k['nilai'], 0, ',', '.') }}</h4>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Progress bar distribusi status --}}
            @if ($stat['total'] > 0)
            <div class="mt-4 bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 flex items-center justify-center">
                            <i class="fas fa-chart-pie text-xs"></i>
                        </div>
                        <h6 class="text-sm font-bold text-slate-800 dark:text-white">Distribusi Status Pesanan</h6>
                    </div>
                    <span class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">100%</span>
                </div>
                <div class="flex h-3 rounded-full overflow-hidden bg-slate-100 dark:bg-slate-700">
                    @if ($pctPending > 0)<div class="bg-orange-400 dark:bg-orange-500 transition-all" style="width: {{ $pctPending }}%" title="Pending: {{ $pctPending }}%"></div>@endif
                    @if ($pctDiproses > 0)<div class="bg-blue-500 dark:bg-blue-500 transition-all" style="width: {{ $pctDiproses }}%" title="Diproses: {{ $pctDiproses }}%"></div>@endif
                    @if ($pctDikirim > 0)<div class="bg-indigo-500 dark:bg-indigo-500 transition-all" style="width: {{ $pctDikirim }}%" title="Dikirim: {{ $pctDikirim }}%"></div>@endif
                    @if ($pctSelesai > 0)<div class="bg-emerald-500 dark:bg-emerald-500 transition-all" style="width: {{ $pctSelesai }}%" title="Selesai: {{ $pctSelesai }}%"></div>@endif
                </div>
                <div class="flex flex-wrap gap-x-4 gap-y-2 mt-3 text-[11px]">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-sm bg-orange-400 dark:bg-orange-500"></span>
                        <span class="text-slate-500 dark:text-slate-400 font-semibold">Pending</span>
                        <span class="font-bold text-slate-700 dark:text-white">{{ $pctPending }}%</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-sm bg-blue-500"></span>
                        <span class="text-slate-500 dark:text-slate-400 font-semibold">Diproses</span>
                        <span class="font-bold text-slate-700 dark:text-white">{{ $pctDiproses }}%</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-sm bg-indigo-500"></span>
                        <span class="text-slate-500 dark:text-slate-400 font-semibold">Dikirim</span>
                        <span class="font-bold text-slate-700 dark:text-white">{{ $pctDikirim }}%</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-sm bg-emerald-500"></span>
                        <span class="text-slate-500 dark:text-slate-400 font-semibold">Selesai</span>
                        <span class="font-bold text-slate-700 dark:text-white">{{ $pctSelesai }}%</span>
                    </div>
                </div>
            </div>
            @endif
        </div>

        {{-- ============ AKTIVITAS TERAKHIR ============ --}}
        @can('request.view')
        <div>
            <div class="flex items-center gap-2 mb-3">
                <div class="w-1 h-5 rounded-full bg-emerald-600 dark:bg-emerald-500"></div>
                <h6 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider">Aktivitas Terakhir</h6>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden transition-colors">

                <div class="p-4 sm:p-5 border-b border-slate-100 dark:border-slate-700 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h5 class="text-base font-bold text-slate-800 dark:text-white flex items-center gap-2">
                            <i class="fas fa-history text-blue-500 dark:text-blue-400 text-sm"></i>
                            Aktivitas Pesanan Terakhir
                        </h5>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                            {{ $viewAll ? '5 order terbaru dari seluruh distributor.' : 'Pantau 5 pengajuan barang terakhir Anda.' }}
                        </p>
                    </div>
                    <a href="{{ route('request.index') }}"
                        class="inline-flex items-center justify-center gap-2 text-xs font-bold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 bg-blue-50 dark:bg-blue-500/10 hover:bg-blue-100 dark:hover:bg-blue-500/20 px-3 py-2 rounded-xl transition-colors w-full sm:w-auto">
                        Lihat Semua
                        <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-600 dark:text-slate-300">
                        <thead class="text-[11px] text-slate-400 dark:text-slate-500 uppercase bg-slate-50 dark:bg-slate-900/50 border-b border-slate-100 dark:border-slate-700">
                            <tr>
                                <th class="px-4 sm:px-6 py-3 font-bold">Kode Pesanan</th>
                                @if ($viewAll)
                                <th class="px-4 sm:px-6 py-3 font-bold">Distributor</th>
                                @endif
                                <th class="px-4 sm:px-6 py-3 font-bold">Tanggal</th>
                                <th class="px-4 sm:px-6 py-3 font-bold text-center">Total Item</th>
                                <th class="px-4 sm:px-6 py-3 font-bold text-center">Status</th>
                                <th class="px-4 sm:px-6 py-3 font-bold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                            @forelse ($recentRequests as $req)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-4 sm:px-6 py-3.5">
                                    <span class="font-bold text-slate-700 dark:text-white font-mono text-[13px]">{{ $req->kode_request }}</span>
                                </td>
                                @if ($viewAll)
                                <td class="px-4 sm:px-6 py-3.5">
                                    <div class="flex items-center gap-2">
                                        @php
                                        $namaDist = $req->user?->name ?? 'Tidak Valid';
                                        // Tetap gunakan 2 huruf inisial untuk tabel agar seragam dengan desain sebelumnya
                                        $inisial2 = strtoupper(substr($namaDist, 0, 2));
                                        @endphp

                                        {{-- Cek apakah user ada dan punya foto --}}
                                        @if ($req->user && $req->user->foto_url)
                                        <img src="{{ $req->user->foto_url }}"
                                            alt="Foto {{ $namaDist }}"
                                            class="w-7 h-7 rounded-full object-cover border border-indigo-200 dark:border-indigo-500/30 shrink-0 shadow-sm">
                                        @else
                                        {{-- Jika tidak ada foto, tampilkan inisial --}}
                                        <div class="w-7 h-7 rounded-full bg-indigo-100 dark:bg-indigo-500/20 text-indigo-700 dark:text-indigo-400 font-bold text-[10px] flex items-center justify-center border border-indigo-200 dark:border-indigo-500/30 shrink-0">
                                            {{ $inisial2 }}
                                        </div>
                                        @endif

                                        <span class="font-semibold text-slate-600 dark:text-slate-300 text-sm truncate">{{ $namaDist }}</span>
                                    </div>
                                </td>
                                @endif
                                <td class="px-4 sm:px-6 py-3.5 text-slate-500 dark:text-slate-400 font-medium whitespace-nowrap text-xs">
                                    {{ \Carbon\Carbon::parse($req->tanggal_request)->format('d M Y, H:i') }}
                                </td>
                                <td class="px-4 sm:px-6 py-3.5 text-center">
                                    <span class="inline-flex items-center justify-center min-w-[2rem] font-extrabold text-slate-700 dark:text-white bg-slate-100 dark:bg-slate-700 px-2 py-0.5 rounded-md text-xs">
                                        {{ $req->details->sum('qty_diminta') }}
                                    </span>
                                </td>
                                <td class="px-4 sm:px-6 py-3.5 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md border text-[10px] font-bold uppercase tracking-wider {{ $badgeMap[$req->status] ?? 'bg-slate-100 text-slate-600 border-slate-200 dark:bg-slate-700 dark:text-slate-300 dark:border-slate-600' }}">
                                        {{ $req->status }}
                                    </span>
                                </td>
                                <td class="px-4 sm:px-6 py-3.5 text-right">
                                    <a href="{{ route('request.show', $req->id) }}"
                                        aria-label="Lihat detail {{ $req->kode_request }}"
                                        class="inline-flex items-center justify-center w-8 h-8 text-slate-400 dark:text-slate-500 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-500/10 rounded-lg transition-all">
                                        <i class="fas fa-chevron-right text-xs"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ $viewAll ? 6 : 5 }}" class="px-6 py-14 text-center">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-700 mb-4 text-slate-400 dark:text-slate-500 text-2xl">
                                        <i class="fas fa-box-open"></i>
                                    </div>
                                    <p class="font-bold text-slate-600 dark:text-slate-300">Belum ada pengajuan</p>
                                    <p class="text-sm text-slate-400 dark:text-slate-500 mt-1">
                                        {{ $viewAll ? 'Belum ada order dari distributor.' : 'Anda belum membuat pesanan barang ke pusat.' }}
                                    </p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endcan

    </div>
</x-app-layout>