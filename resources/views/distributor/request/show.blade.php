<x-app-layout>
    <x-slot name="header">
        Detail Order: <span class="text-blue-600">{{ $pengajuan->kode_request }}</span>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <h5 class="font-bold text-slate-800">Daftar Barang Diminta</h5>
            </div>
            <div class="p-0 overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-600">
                    <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 font-bold">Item Produk</th>
                            <th class="px-6 py-4 font-bold text-right">Harga Satuan</th>
                            <th class="px-6 py-4 font-bold text-right">Kuantitas</th>
                            <th class="px-6 py-4 font-bold text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $grandTotal = 0; @endphp
                        @foreach ($pengajuan->details as $detail)
                            @php
                                $subtotal = $detail->qty_diminta * $detail->product->harga;
                                $grandTotal += $subtotal;
                            @endphp
                            <tr class="border-b border-slate-100 hover:bg-slate-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        @if($detail->product->gambar)
                                            <img src="{{ asset('storage/' . $detail->product->gambar) }}" class="w-10 h-10 rounded-lg object-cover border border-slate-200 shadow-sm bg-white shrink-0">
                                        @else
                                            <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 font-bold flex items-center justify-center border border-blue-100 shrink-0">
                                                {{ strtoupper(substr($detail->product->nama_barang, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-bold text-slate-700 leading-tight">{{ $detail->product->nama_barang }}</div>
                                            <div class="text-xs text-slate-500 mt-1">{{ $detail->product->ukuran }} | <span class="uppercase font-semibold text-blue-600 bg-blue-50 px-1 py-0.5 rounded">{{ $detail->product->satuan }}</span></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right font-medium text-slate-600">
                                    Rp {{ number_format($detail->product->harga, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="font-extrabold text-slate-700 text-base">{{ $detail->qty_diminta }}</span>
                                </td>
                                <td class="px-6 py-4 text-right font-extrabold text-blue-600">
                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-slate-50">
                        <tr>
                            <td colspan="3" class="px-6 py-4 font-bold text-right text-slate-700 uppercase tracking-wide">Estimasi Total Nilai Order:</td>
                            <td class="px-6 py-4 font-black text-slate-800 text-right text-lg">
                                Rp {{ number_format($grandTotal, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="px-6 py-3 font-bold text-right text-slate-500 uppercase tracking-wide border-t border-slate-200">Total Kuantitas Fisik:</td>
                            <td class="px-6 py-3 font-bold text-slate-500 text-right border-t border-slate-200">
                                {{ $pengajuan->details->sum('qty_diminta') }} Unit
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden flex flex-col h-fit">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                <h5 class="font-bold text-slate-800">Status Pemrosesan</h5>
            </div>
            <div class="p-6 space-y-6">

                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Status Saat Ini</p>
                    @php
                        $badge = 'bg-orange-100 text-orange-600 border-orange-200';
                        $icon = 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'; // Clock
                        if ($pengajuan->status == 'diproses') {
                            $badge = 'bg-blue-100 text-blue-600 border-blue-200';
                            $icon = 'M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4'; // Box
                        }
                        if ($pengajuan->status == 'dikirim') {
                            $badge = 'bg-indigo-100 text-indigo-600 border-indigo-200';
                            $icon = 'M8 14V3m0 0H5a2 2 0 00-2 2v7a2 2 0 002 2h3zm0-11h9a2 2 0 012 2v3m-2 4h4a2 2 0 012 2v3a2 2 0 01-2 2h-4a2 2 0 01-2-2v-3a2 2 0 012-2zM3 14h2M19 14h2M9 21h6'; // Truck
                        }
                        if ($pengajuan->status == 'selesai') {
                            $badge = 'bg-emerald-100 text-emerald-600 border-emerald-200';
                            $icon = 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'; // Check
                        }
                    @endphp
                    <div class="inline-flex items-center px-4 py-2 rounded-xl border font-bold text-sm uppercase tracking-wide {{ $badge }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"></path></svg>
                        {{ $pengajuan->status }}
                    </div>
                </div>

                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Tanggal Input</p>
                    <p class="font-semibold text-slate-700 flex items-center">
                        <svg class="w-4 h-4 text-slate-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ \Carbon\Carbon::parse($pengajuan->tanggal_request)->format('d F Y, H:i') }} WIB
                    </p>
                </div>

                @if($pengajuan->status == 'dikirim')
                    <form action="{{ route('distributor.request.update', $pengajuan->id) }}" method="POST" class="w-full mb-4">
                        @csrf
                        @method('PUT')
                        <button type="submit" onclick="return confirm('Apakah Anda yakin barang sudah diterima dengan baik?')" class="block w-full text-center px-4 py-2.5 text-sm font-bold text-white bg-emerald-600 border border-emerald-700 rounded-xl hover:bg-emerald-700 transition-colors shadow-sm">
                            <div class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Konfirmasi Barang Diterima
                            </div>
                        </button>
                    </form>
                @endif

                <hr class="border-slate-100">

                <a href="{{ route('distributor.request.index') }}" class="block w-full text-center px-4 py-2.5 text-sm font-bold text-slate-600 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors shadow-sm">
                    <div class="flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Daftar
                    </div>
                </a>

            </div>
        </div>

    </div>
</x-app-layout>
