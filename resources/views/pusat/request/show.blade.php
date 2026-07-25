<x-app-layout>
    <x-slot name="header">
        Validasi Order: <span class="text-blue-600">{{ $pengajuan->kode_request }}</span>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                    <h5 class="font-bold text-slate-800">Daftar Barang Diminta oleh Distributor</h5>
                </div>
                <div class="p-0 overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-600">
                        <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 font-bold">Produk</th>
                                <th class="px-6 py-4 font-bold text-right">Harga Varian</th>
                                <th class="px-6 py-4 font-bold text-center">Stok Gudang</th>
                                <th class="px-6 py-4 font-bold text-center">QTY Order</th>
                                <th class="px-6 py-4 font-bold text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $grandTotal = 0; @endphp
                            @foreach ($pengajuan->details as $detail)
                                @php
                                    $subtotal = $detail->qty_diminta * ($detail->product?->harga ?? 0);
                                    $grandTotal += $subtotal;

                                    // Pengecekan logika stok
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

                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center justify-center min-w-[3rem] px-2.5 py-1 text-xs font-bold rounded-lg border {{ $isStockEnough ? 'bg-slate-100 text-slate-600 border-slate-200' : 'bg-red-100 text-red-600 border-red-200' }}" title="{{ $isStockEnough ? 'Stok Aman' : 'Stok Tidak Mencukupi!' }}">
                                            {{ $stokTersedia }}
                                        </span>
                                    </td>

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
                                <td colspan="4" class="px-6 py-4 font-bold text-right text-slate-700 uppercase tracking-wide text-xs">Total Nilai Muatan Kirim:</td>
                                <td class="px-6 py-4 font-black text-slate-800 text-right text-base">
                                    Rp {{ number_format($grandTotal, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="px-6 py-3 font-bold text-right text-slate-400 uppercase tracking-wide text-[11px] border-t border-slate-100">Total Kuantitas Fisik:</td>
                                <td class="px-6 py-3 font-bold text-slate-500 text-right text-sm border-t border-slate-100">
                                    {{ $pengajuan->details->sum('qty_diminta') }} Unit
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden flex flex-col h-fit">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                    <h5 class="font-bold text-slate-800">Panel Validasi Stok</h5>
                </div>
                <div class="p-6 space-y-6">

                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Distributor Pemohon</p>
                        <p class="font-bold text-slate-700 text-lg">
                            {{ $pengajuan->user?->name ?? 'Distributor Tidak Aktif/Dihapus' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Status Alur Order</p>
                        @php
                            $badge = 'bg-orange-100 text-orange-600 border-orange-200';
                            if ($pengajuan->status == 'diproses') { $badge = 'bg-blue-100 text-blue-600 border-blue-200'; }
                            if ($pengajuan->status == 'dikirim') { $badge = 'bg-indigo-100 text-indigo-600 border-indigo-200'; }
                            if ($pengajuan->status == 'selesai') { $badge = 'bg-emerald-100 text-emerald-600 border-emerald-200'; }
                        @endphp
                        <div class="inline-flex items-center px-4 py-2 rounded-xl border font-bold text-sm uppercase tracking-wide {{ $badge }}">
                            {{ $pengajuan->status }}
                        </div>
                    </div>

                    <hr class="border-slate-100">

                    @if($pengajuan->status !== 'selesai')
                        <form action="{{ route('pusat.request.update', $pengajuan->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <label class="block mb-2 text-sm font-bold text-slate-700">Ubah Status Order</label>
                            <div class="flex gap-2">
                                <select name="status" class="bg-white border border-slate-300 text-slate-700 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none transition-all">
                                    <option value="pending" {{ $pengajuan->status == 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                                    <option value="diproses" {{ $pengajuan->status == 'diproses' ? 'selected' : '' }}>Diproses (Siap Kirim)</option>
                                    <option value="dikirim" {{ $pengajuan->status == 'dikirim' ? 'selected' : '' }}>Dikirim (Dalam Perjalanan)</option>
                                </select>
                                <button type="submit" class="px-4 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-colors shadow-sm">
                                    Update
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-5 text-center shadow-sm">
                            <div class="inline-flex items-center justify-center w-12 h-12 bg-emerald-100 rounded-full mb-3">
                                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h6 class="text-sm font-extrabold text-emerald-800 uppercase tracking-wide">Transaksi Selesai</h6>
                            <p class="text-xs text-emerald-600 mt-1 leading-relaxed">
                                Barang telah sampai dan dikonfirmasi diterima oleh pihak distributor. Panel perubahan status dikunci total demi keamanan riwayat data stok.
                            </p>
                        </div>
                    @endif

                    <div class="flex flex-col gap-3 pt-2">
                        @if(in_array($pengajuan->status, ['diproses', 'dikirim', 'selesai']))
                            <a href="{{ route('pusat.request.cetak', $pengajuan->id) }}" target="_blank" class="w-full text-center px-4 py-2.5 text-sm font-bold text-emerald-600 bg-emerald-50 border border-emerald-200 rounded-xl hover:bg-emerald-100 transition-colors shadow-sm flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                Cetak Surat Jalan Resmi
                            </a>
                        @endif
                        <a href="{{ route('pusat.request.index') }}" class="w-full text-center px-4 py-2.5 text-sm font-bold text-slate-600 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors shadow-sm">
                            Kembali ke Daftar Request
                        </a>
                    </div>

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
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2500,
                iconColor: '#2563eb',
                customClass: { popup: 'rounded-2xl' }
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal Memproses!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#2563eb',
                confirmButtonText: 'Periksa Kembali',
                customClass: { popup: 'rounded-2xl' }
            });
        @endif
    </script>
</x-app-layout>
