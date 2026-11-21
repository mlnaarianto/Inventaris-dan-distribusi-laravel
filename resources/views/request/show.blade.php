<x-app-layout>
    <x-slot name="header">
        @can('request.update-status') Validasi Order: @else Detail Order: @endcan
        <span class="text-blue-600">{{ $pengajuan->kode_request }}</span>
    </x-slot>

    @php
    $canProcess = auth()->user()->can('request.update-status');
    $badgeMap = [
    'pending' => 'bg-orange-100 text-orange-600 border-orange-200',
    'diproses' => 'bg-blue-100 text-blue-600 border-blue-200',
    'dikirim' => 'bg-indigo-100 text-indigo-600 border-indigo-200',
    'selesai' => 'bg-emerald-100 text-emerald-600 border-emerald-200',
    ];
    $grandTotal = 0;
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

        {{-- Daftar barang --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                <h5 class="font-bold text-slate-800">
                    @can('request.view-all') Daftar Barang Diminta oleh Distributor @else Daftar Barang Diminta @endcan
                </h5>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-600">
                    <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 font-bold">Produk</th>
                            <th class="px-6 py-4 font-bold text-right">Harga Satuan</th>
                            @if($canProcess)
                            <th class="px-6 py-4 font-bold text-center">Stok Gudang</th>
                            @endif
                            <th class="px-6 py-4 font-bold text-center">QTY Order</th>
                            <th class="px-6 py-4 font-bold text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengajuan->details as $detail)
                        @php
                        $subtotal = $detail->qty_diminta * ($detail->product?->harga ?? 0);
                        $grandTotal += $subtotal;
                        $stokTersedia = $detail->product?->stok_pusat ?? 0;
                        $isStockEnough = $stokTersedia >= $detail->qty_diminta;
                        @endphp
                        <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    @if($detail->product?->gambar)
                                    <img src="{{ asset('storage/' . $detail->product->gambar) }}" class="w-10 h-10 rounded-lg object-cover border border-slate-200 shadow-sm bg-white shrink-0">
                                    @else
                                    <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 font-bold flex items-center justify-center border border-blue-100 shrink-0">
                                        {{ strtoupper(substr($detail->product?->nama_barang ?? 'P', 0, 1)) }}
                                    </div>
                                    @endif
                                    <div>
                                        <div class="font-bold text-slate-700 leading-tight">{{ $detail->product?->nama_barang ?? 'Produk Dihapus' }}</div>
                                        <div class="text-xs text-slate-500 mt-1">{{ $detail->product?->ukuran ?? '-' }} | <span class="uppercase font-semibold text-blue-600 bg-blue-50 px-1.5 py-0.5 rounded text-[10px]">{{ $detail->product?->satuan ?? '-' }}</span></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right font-medium text-slate-600">
                                Rp {{ number_format($detail->product?->harga ?? 0, 0, ',', '.') }}
                            </td>
                            @if($canProcess)
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center justify-center min-w-[3rem] px-2.5 py-1 text-xs font-bold rounded-lg border {{ $isStockEnough ? 'bg-slate-100 text-slate-600 border-slate-200' : 'bg-red-100 text-red-600 border-red-200' }}" title="{{ $isStockEnough ? 'Stok Aman' : 'Stok Tidak Mencukupi!' }}">
                                    {{ $stokTersedia }}
                                </span>
                            </td>
                            @endif
                            <td class="px-6 py-4 text-center">
                                <span class="font-extrabold text-slate-700 text-base">{{ $detail->qty_diminta }}</span>
                            </td>
                            <td class="px-6 py-4 text-right font-extrabold text-blue-600">
                                Rp {{ number_format($subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-slate-50 border-t border-slate-200">
                        <tr>
                            <td colspan="{{ $canProcess ? 4 : 3 }}" class="px-6 py-4 font-bold text-right text-slate-700 uppercase tracking-wide text-xs">Total Nilai Order:</td>
                            <td class="px-6 py-4 font-black text-slate-800 text-right text-base">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="{{ $canProcess ? 4 : 3 }}" class="px-6 py-3 font-bold text-right text-slate-400 uppercase tracking-wide text-[11px] border-t border-slate-100">Total Kuantitas Fisik:</td>
                            <td class="px-6 py-3 font-bold text-slate-500 text-right text-sm border-t border-slate-100">{{ $pengajuan->details->sum('qty_diminta') }} Unit</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- Panel kanan --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden flex flex-col h-fit">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                <h5 class="font-bold text-slate-800">
                    @if($canProcess) Panel Validasi Stok @else Status Pemrosesan @endif
                </h5>
            </div>
            <div class="p-6 space-y-6">

                @can('request.view-all')
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Distributor Pemohon</p>
                    <p class="font-bold text-slate-700 text-lg">{{ $pengajuan->user?->name ?? 'Distributor Tidak Aktif/Dihapus' }}</p>
                </div>
                @endcan

                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Status Saat Ini</p>
                    <div class="inline-flex items-center px-4 py-2 rounded-xl border font-bold text-sm uppercase tracking-wide {{ $badgeMap[$pengajuan->status] ?? '' }}">
                        {{ $pengajuan->status }}
                    </div>
                </div>

                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Tanggal Input</p>
                    <p class="font-semibold text-slate-700">{{ \Carbon\Carbon::parse($pengajuan->tanggal_request)->format('d F Y, H:i') }} WIB</p>
                </div>

                <hr class="border-slate-100">

                {{-- Pusat: ubah status --}}
                @can('request.update-status')
                @if($pengajuan->status !== 'selesai')
                <form action="{{ route('request.updateStatus', $pengajuan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <label class="block mb-2 text-sm font-bold text-slate-700">Ubah Status Order</label>
                    <div class="flex gap-2">
                        <select name="status" class="bg-white border border-slate-300 text-slate-700 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none transition-all">
                            <option value="pending" {{ $pengajuan->status == 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                            <option value="diproses" {{ $pengajuan->status == 'diproses' ? 'selected' : '' }}>Diproses (Siap Kirim)</option>
                            <option value="dikirim" {{ $pengajuan->status == 'dikirim' ? 'selected' : '' }}>Dikirim (Dalam Perjalanan)</option>
                        </select>
                        <button type="submit" class="px-4 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-colors shadow-sm">Update</button>
                    </div>
                </form>
                @endif
                @endcan

                {{-- Distributor (dan superadmin): konfirmasi terima --}}
                @can('request.terima')
                @if($pengajuan->status === 'dikirim')
                <form action="{{ route('request.terima', $pengajuan->id) }}" method="POST"
                    onsubmit="return confirm('Konfirmasi barang sudah diterima dengan baik?')">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="w-full px-4 py-2.5 text-sm font-bold text-white bg-emerald-600 border border-emerald-700 rounded-xl hover:bg-emerald-700 transition-colors shadow-sm">
                        Konfirmasi Barang Diterima
                    </button>
                </form>
                @endif
                @endcan

                @if($pengajuan->status === 'selesai')
                <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-5 text-center shadow-sm">
                    <h6 class="text-sm font-extrabold text-emerald-800 uppercase tracking-wide">Transaksi Selesai</h6>
                    <p class="text-xs text-emerald-600 mt-1 leading-relaxed">
                        Barang telah diterima distributor. Status order dikunci demi keamanan riwayat stok.
                    </p>
                </div>
                @endif

                <div class="flex flex-col gap-3 pt-2">
                    @can('request.cetak')
                    @if(in_array($pengajuan->status, ['diproses', 'dikirim', 'selesai']))
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('request.cetak', $pengajuan->id) }}" target="_blank"
                            class="text-center px-4 py-2.5 text-sm font-bold text-emerald-600 bg-emerald-50 border border-emerald-200 rounded-xl hover:bg-emerald-100 transition-colors shadow-sm">
                            Lihat / Cetak
                        </a>
                        <a href="{{ route('request.cetak', ['id' => $pengajuan->id, 'unduh' => 1]) }}"
                            class="text-center px-4 py-2.5 text-sm font-bold text-blue-600 bg-blue-50 border border-blue-200 rounded-xl hover:bg-blue-100 transition-colors shadow-sm">
                            Unduh PDF
                        </a>
                    </div>
                    @endif
                    @endcan
                    <a href="{{ route('request.index') }}" class="w-full text-center px-4 py-2.5 text-sm font-bold text-slate-600 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors shadow-sm">
                        Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: @json(session('success')),
            showConfirmButton: false,
            timer: 2500,
            iconColor: '#2563eb',
            customClass: {
                popup: 'rounded-2xl'
            }
        });
        @endif
        @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal Memproses!',
            text: @json(session('error')),
            confirmButtonColor: '#2563eb',
            customClass: {
                popup: 'rounded-2xl'
            }
        });
        @endif
    </script>
</x-app-layout>