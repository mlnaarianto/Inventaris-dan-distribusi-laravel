<x-app-layout>
    <x-slot name="title">Detail Permintaan</x-slot>
    <x-slot name="header">
        @can('request.update-status') Validasi Order: @else Detail Order: @endcan
        <span class="text-blue-600 dark:text-blue-400">{{ $pengajuan->kode_request }}</span>
    </x-slot>

    @php
        $canProcess = auth()->user()->can('request.update-status');
        $milikSaya  = $pengajuan->user_id === auth()->id();
        $bisaTerima = auth()->user()->can('request.terima')
            && $pengajuan->status === 'dikirim'
            && ($milikSaya || auth()->user()->can('request.view-all'));

        $badgeMap = [
            'pending'  => 'bg-orange-100 text-orange-700 border-orange-200 dark:bg-orange-500/15 dark:text-orange-400 dark:border-orange-500/30',
            'diproses' => 'bg-blue-100 text-blue-700 border-blue-200 dark:bg-blue-500/15 dark:text-blue-400 dark:border-blue-500/30',
            'dikirim'  => 'bg-indigo-100 text-indigo-700 border-indigo-200 dark:bg-indigo-500/15 dark:text-indigo-400 dark:border-indigo-500/30',
            'selesai'  => 'bg-emerald-100 text-emerald-700 border-emerald-200 dark:bg-emerald-500/15 dark:text-emerald-400 dark:border-emerald-500/30',
        ];
        $grandTotal = 0;
    @endphp

    {{-- ================= HERO SUMMARY ================= --}}
    <div class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 dark:from-blue-700 dark:via-indigo-800 dark:to-slate-900 rounded-2xl p-5 sm:p-6 overflow-hidden shadow-lg shadow-blue-500/20 dark:shadow-black/40 mb-5">
        <div class="absolute -top-20 -right-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-32 w-32 h-32 bg-indigo-400/20 rounded-full blur-2xl"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div class="min-w-0">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-blue-50 text-[10px] font-bold uppercase tracking-widest mb-3 backdrop-blur-md">
                    <i class="fas fa-file-invoice text-xs"></i>
                    @can('request.update-status') Validasi @else Detail @endcan
                </div>

                <div class="flex items-center gap-3 flex-wrap">
                    <h5 class="text-xl sm:text-2xl font-extrabold text-white leading-tight font-mono">
                        {{ $pengajuan->kode_request }}
                    </h5>
                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-[11px] font-black uppercase tracking-wider border backdrop-blur-md
                        {{ $pengajuan->status === 'pending' ? 'bg-orange-500/20 text-orange-200 border-orange-300/30'
                          : ($pengajuan->status === 'diproses' ? 'bg-blue-500/20 text-blue-200 border-blue-300/30'
                          : ($pengajuan->status === 'dikirim' ? 'bg-indigo-500/20 text-indigo-200 border-indigo-300/30'
                          : 'bg-emerald-500/20 text-emerald-200 border-emerald-300/30')) }}">
                        @if($pengajuan->status === 'pending') <i class="fas fa-clock mr-1 text-[9px]"></i>
                        @elseif($pengajuan->status === 'diproses') <i class="fas fa-box-open mr-1 text-[9px]"></i>
                        @elseif($pengajuan->status === 'dikirim') <i class="fas fa-truck mr-1 text-[9px]"></i>
                        @elseif($pengajuan->status === 'selesai') <i class="fas fa-check-circle mr-1 text-[9px]"></i>
                        @endif
                        {{ $pengajuan->status }}
                    </span>
                </div>

                <p class="text-blue-100/85 text-sm mt-1">
                    Diajukan oleh <span class="font-bold text-white">{{ $pengajuan->user?->name ?? 'Distributor Tidak Aktif/Dihapus' }}</span>
                    @if ($milikSaya)
                        <span class="inline-flex items-center gap-1 ml-2 text-[10px] font-bold uppercase text-emerald-200 bg-emerald-500/20 border border-emerald-300/30 px-2 py-0.5 rounded-full">
                            <i class="fas fa-user-check text-[8px]"></i> Order Anda
                        </span>
                    @endif
                </p>
            </div>

            <div class="grid grid-cols-3 gap-2.5 sm:gap-3 shrink-0">
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl p-3 text-center min-w-[88px]">
                    <p class="text-[9px] font-bold text-blue-100 uppercase tracking-wider">Item</p>
                    <p class="text-xl sm:text-2xl font-black text-white leading-tight">{{ $pengajuan->details->sum('qty_diminta') }}</p>
                    <p class="text-[9px] text-blue-100/70">Unit</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl p-3 text-center min-w-[88px]">
                    <p class="text-[9px] font-bold text-blue-100 uppercase tracking-wider">Produk</p>
                    <p class="text-xl sm:text-2xl font-black text-white leading-tight">{{ $pengajuan->details->count() }}</p>
                    <p class="text-[9px] text-blue-100/70">Jenis</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl p-3 text-center min-w-[110px]">
                    <p class="text-[9px] font-bold text-blue-100 uppercase tracking-wider">Tanggal</p>
                    <p class="text-xs font-black text-white leading-tight mt-0.5">{{ \Carbon\Carbon::parse($pengajuan->tanggal_request)->format('d M Y') }}</p>
                    <p class="text-[9px] text-blue-100/70">{{ \Carbon\Carbon::parse($pengajuan->tanggal_request)->format('H:i') }} WIB</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-6">

        {{-- ================= DAFTAR BARANG ================= --}}
        <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden transition-colors">

            <div class="p-4 sm:p-5 border-b border-slate-100 dark:border-slate-700 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-blue-50 dark:bg-blue-500/15 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                    <i class="fas fa-boxes text-sm"></i>
                </div>
                <div>
                    <h6 class="text-sm font-bold text-slate-800 dark:text-white">
                        @can('request.view-all') Daftar Barang Diminta oleh Distributor @else Daftar Barang Diminta @endcan
                    </h6>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Rincian produk & kuantitas.</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-600 dark:text-slate-300">
                    <thead class="text-[11px] text-slate-500 dark:text-slate-400 uppercase bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700">
                        <tr>
                            <th class="px-4 sm:px-6 py-3 font-bold">Produk</th>
                            <th class="px-4 sm:px-6 py-3 font-bold text-right">Harga Satuan</th>
                            @if ($canProcess)
                                <th class="px-4 sm:px-6 py-3 font-bold text-center">Stok Gudang</th>
                            @endif
                            <th class="px-4 sm:px-6 py-3 font-bold text-center">QTY Order</th>
                            <th class="px-4 sm:px-6 py-3 font-bold text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @foreach ($pengajuan->details as $detail)
                            @php
                                $subtotal = $detail->qty_diminta * ($detail->product?->harga ?? 0);
                                $grandTotal += $subtotal;
                                $stokTersedia = $detail->product?->stok_pusat ?? 0;
                                $isStockEnough = $stokTersedia >= $detail->qty_diminta;
                            @endphp
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/40 transition-colors">
                                <td class="px-4 sm:px-6 py-3.5">
                                    <div class="flex items-center gap-3">
                                        @if ($detail->product?->gambar)
                                            <img src="{{ asset('storage/' . $detail->product->gambar) }}" class="w-10 h-10 rounded-lg object-cover border border-slate-200 dark:border-slate-600 shadow-sm bg-white dark:bg-slate-900 shrink-0">
                                        @else
                                            <div class="w-10 h-10 rounded-lg bg-blue-50 dark:bg-blue-500/15 text-blue-600 dark:text-blue-400 font-bold flex items-center justify-center border border-blue-100 dark:border-blue-500/30 shrink-0">
                                                {{ strtoupper(substr($detail->product?->nama_barang ?? 'P', 0, 1)) }}
                                            </div>
                                        @endif
                                        <div class="min-w-0">
                                            <div class="font-bold text-slate-700 dark:text-white leading-tight text-sm truncate">{{ $detail->product?->nama_barang ?? 'Produk Dihapus' }}</div>
                                            <div class="text-xs text-slate-500 dark:text-slate-400 mt-1 flex items-center gap-1.5 flex-wrap">
                                                <span>{{ $detail->product?->ukuran ?? '-' }}</span>
                                                <span class="text-slate-300 dark:text-slate-600">|</span>
                                                <span class="uppercase font-bold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-500/15 px-1.5 py-0.5 rounded text-[10px] border border-blue-100 dark:border-blue-500/30">
                                                    {{ $detail->product?->satuan ?? '-' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 sm:px-6 py-3.5 text-right font-medium text-slate-600 dark:text-slate-400 whitespace-nowrap">
                                    Rp {{ number_format($detail->product?->harga ?? 0, 0, ',', '.') }}
                                </td>
                                @if ($canProcess)
                                    <td class="px-4 sm:px-6 py-3.5 text-center">
                                        <span class="inline-flex items-center justify-center min-w-[3rem] px-2.5 py-1 text-xs font-bold rounded-lg border
                                            {{ $isStockEnough
                                                ? 'bg-slate-100 text-slate-600 border-slate-200 dark:bg-slate-700 dark:text-slate-300 dark:border-slate-600'
                                                : 'bg-red-100 text-red-600 border-red-200 dark:bg-red-500/15 dark:text-red-400 dark:border-red-500/30' }}"
                                            title="{{ $isStockEnough ? 'Stok Aman' : 'Stok Tidak Mencukupi!' }}">
                                            @if(!$isStockEnough) <i class="fas fa-exclamation-triangle text-[9px] mr-1"></i> @endif
                                            {{ $stokTersedia }}
                                        </span>
                                    </td>
                                @endif
                                <td class="px-4 sm:px-6 py-3.5 text-center">
                                    <span class="inline-flex items-center justify-center min-w-[2.5rem] px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 font-extrabold text-slate-700 dark:text-white text-sm">
                                        {{ $detail->qty_diminta }}
                                    </span>
                                </td>
                                <td class="px-4 sm:px-6 py-3.5 text-right font-extrabold text-blue-600 dark:text-blue-400 whitespace-nowrap">
                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-slate-50 dark:bg-slate-900/50 border-t border-slate-200 dark:border-slate-700">
                        <tr>
                            <td colspan="{{ $canProcess ? 4 : 3 }}" class="px-4 sm:px-6 py-3 font-bold text-right text-slate-500 dark:text-slate-400 uppercase tracking-wider text-[10px]">Total Nilai Order:</td>
                            <td class="px-4 sm:px-6 py-3 font-black text-slate-800 dark:text-white text-right text-base whitespace-nowrap">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="border-t border-slate-200 dark:border-slate-700">
                            <td colspan="{{ $canProcess ? 4 : 3 }}" class="px-4 sm:px-6 py-2.5 font-bold text-right text-slate-400 dark:text-slate-500 uppercase tracking-wider text-[10px]">Total Kuantitas Fisik:</td>
                            <td class="px-4 sm:px-6 py-2.5 font-bold text-slate-500 dark:text-slate-300 text-right text-sm whitespace-nowrap">{{ $pengajuan->details->sum('qty_diminta') }} Unit</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- ================= PANEL KANAN ================= --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden flex flex-col h-fit transition-colors">

            <div class="p-4 sm:p-5 border-b border-slate-100 dark:border-slate-700 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-indigo-50 dark:bg-indigo-500/15 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0">
                    <i class="fas {{ $canProcess ? 'fa-clipboard-check' : 'fa-info-circle' }} text-sm"></i>
                </div>
                <h6 class="text-sm font-bold text-slate-800 dark:text-white">
                    @if ($canProcess) Panel Validasi Stok @else Status Pemrosesan @endif
                </h6>
            </div>

            <div class="p-4 sm:p-5 space-y-4">

                {{-- Distributor --}}
                <div>
                    <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-1">Distributor Pemohon</p>
                    <p class="font-bold text-slate-800 dark:text-white text-base leading-tight">
                        {{ $pengajuan->user?->name ?? 'Distributor Tidak Aktif/Dihapus' }}
                    </p>
                    @if ($milikSaya)
                        <span class="inline-flex items-center gap-1 mt-1.5 text-[10px] font-bold uppercase text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/15 border border-emerald-200 dark:border-emerald-500/30 px-2 py-0.5 rounded-full">
                            <i class="fas fa-user-check text-[8px]"></i> Order Anda
                        </span>
                    @endif
                </div>

                {{-- Status --}}
                <div>
                    <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-1.5">Status Saat Ini</p>
                    <div class="inline-flex items-center px-3.5 py-1.5 rounded-lg border font-bold text-xs uppercase tracking-wider {{ $badgeMap[$pengajuan->status] ?? '' }}">
                        @if($pengajuan->status === 'pending') <i class="fas fa-clock mr-1.5 text-[10px]"></i>
                        @elseif($pengajuan->status === 'diproses') <i class="fas fa-box-open mr-1.5 text-[10px]"></i>
                        @elseif($pengajuan->status === 'dikirim') <i class="fas fa-truck mr-1.5 text-[10px]"></i>
                        @elseif($pengajuan->status === 'selesai') <i class="fas fa-check-circle mr-1.5 text-[10px]"></i>
                        @endif
                        {{ $pengajuan->status }}
                    </div>
                </div>

                {{-- Tanggal --}}
                <div>
                    <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-1">Tanggal Input</p>
                    <p class="font-semibold text-slate-700 dark:text-slate-300 text-sm">{{ \Carbon\Carbon::parse($pengajuan->tanggal_request)->format('d F Y, H:i') }} WIB</p>
                </div>

                <hr class="border-slate-100 dark:border-slate-700">

                {{-- Pusat: form ubah status --}}
                @can('request.update-status')
                    @if ($pengajuan->status !== 'selesai')
                        <form action="{{ route('request.updateStatus', $pengajuan->id) }}" method="POST" class="space-y-2">
                            @csrf
                            @method('PUT')
                            <label class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Ubah Status Order</label>
                            <select name="status" class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-white text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block w-full p-2.5 outline-none transition-all">
                                <option value="pending" {{ $pengajuan->status == 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                                <option value="diproses" {{ $pengajuan->status == 'diproses' ? 'selected' : '' }}>Diproses (Siap Kirim)</option>
                                <option value="dikirim" {{ $pengajuan->status == 'dikirim' ? 'selected' : '' }}>Dikirim (Dalam Perjalanan)</option>
                            </select>
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-colors shadow-sm">
                                <i class="fas fa-check text-xs"></i>
                                Update Status
                            </button>
                        </form>
                    @endif
                @endcan

                {{-- Konfirmasi terima --}}
                @if ($bisaTerima)
                    <form action="{{ route('request.terima', $pengajuan->id) }}" method="POST"
                          onsubmit="return confirm('Konfirmasi barang sudah diterima dengan baik?')">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-bold text-white bg-emerald-600 border border-emerald-700 rounded-xl hover:bg-emerald-700 transition-colors shadow-sm">
                            <i class="fas fa-check-double text-xs"></i>
                            Konfirmasi Barang Diterima
                        </button>
                    </form>
                @elseif ($pengajuan->status === 'dikirim' && ! $milikSaya && ! $canProcess)
                    <div class="bg-indigo-50 dark:bg-indigo-500/10 border border-indigo-200 dark:border-indigo-500/30 rounded-xl p-3.5 flex items-start gap-2.5">
                        <i class="fas fa-info-circle text-indigo-600 dark:text-indigo-400 text-sm mt-0.5"></i>
                        <p class="text-xs text-indigo-700 dark:text-indigo-300 leading-relaxed">
                            Order ini milik distributor lain. Konfirmasi penerimaan hanya dapat dilakukan oleh pemiliknya.
                        </p>
                    </div>
                @endif

                @if ($pengajuan->status === 'selesai')
                    <div class="bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/30 rounded-xl p-4 text-center">
                        <div class="w-12 h-12 mx-auto rounded-full bg-emerald-100 dark:bg-emerald-500/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400 mb-2">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                        <h6 class="text-sm font-extrabold text-emerald-800 dark:text-emerald-300 uppercase tracking-wider">Transaksi Selesai</h6>
                        <p class="text-xs text-emerald-600 dark:text-emerald-400/80 mt-1 leading-relaxed">
                            Barang telah diterima distributor. Status order dikunci demi keamanan riwayat stok.
                        </p>
                    </div>
                @endif

                <div class="flex flex-col gap-2 pt-1">
                    @can('request.cetak')
                        @if (in_array($pengajuan->status, ['diproses', 'dikirim', 'selesai']))
                            <div class="grid grid-cols-2 gap-2">
                                <a href="{{ route('request.cetak', $pengajuan->id) }}" target="_blank"
                                   class="inline-flex items-center justify-center gap-1.5 px-3 py-2.5 text-xs font-bold text-emerald-700 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-500/15 border border-emerald-200 dark:border-emerald-500/30 rounded-xl hover:bg-emerald-100 dark:hover:bg-emerald-500/25 transition-colors shadow-sm">
                                    <i class="fas fa-print text-[10px]"></i>
                                    Cetak
                                </a>
                                <a href="{{ route('request.cetak', ['id' => $pengajuan->id, 'unduh' => 1]) }}"
                                   class="inline-flex items-center justify-center gap-1.5 px-3 py-2.5 text-xs font-bold text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-500/15 border border-blue-200 dark:border-blue-500/30 rounded-xl hover:bg-blue-100 dark:hover:bg-blue-500/25 transition-colors shadow-sm">
                                    <i class="fas fa-file-pdf text-[10px]"></i>
                                    PDF
                                </a>
                            </div>
                        @endif
                    @endcan

                    <a href="{{ route('request.index') }}" class="inline-flex items-center justify-center gap-1.5 w-full px-4 py-2.5 text-sm font-bold text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-xl hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors">
                        <i class="fas fa-arrow-left text-xs"></i>
                        Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('success'))
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: @json(session('success')), showConfirmButton: false, timer: 2500, iconColor: '#2563eb', customClass: { popup: 'rounded-2xl' } });
        @endif
        @if (session('error'))
            Swal.fire({ icon: 'error', title: 'Gagal Memproses!', text: @json(session('error')), confirmButtonColor: '#2563eb', customClass: { popup: 'rounded-2xl' } });
        @endif
    </script>
</x-app-layout>