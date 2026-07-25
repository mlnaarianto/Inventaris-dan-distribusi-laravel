<x-app-layout>
    <x-slot name="header">
        Laporan Mutasi Stok
    </x-slot>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        table.dataTable, .dataTables_scrollHeadInner { width: 100% !important; }
        .dataTables_wrapper .dataTables_length select {
            width: 75px !important; padding: 4px 24px 4px 12px !important;
            background-color: #ffffff !important; color: #334155 !important;
            border: 1px solid #cbd5e1 !important; border-radius: 0.5rem !important;
            outline: none !important; background-position: right 0.5rem center !important;
        }
        .dataTables_wrapper .dataTables_filter input {
            background-color: #ffffff !important; color: #334155 !important;
            border: 1px solid #cbd5e1 !important; border-radius: 0.5rem !important;
            padding: 4px 12px !important; outline: none !important; margin-left: 8px !important;
        }
        .dataTables_wrapper .dataTables_filter input:focus, .dataTables_wrapper .dataTables_length select:focus {
            border-color: #2563eb !important; box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2) !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: #2563eb !important; color: white !important;
            border: none !important; border-radius: 0.5rem !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #f1f5f9 !important; color: #1e293b !important;
            border: none !important; border-radius: 0.5rem !important;
        }
        table.dataTable.no-footer { border-bottom: 1px solid #f1f5f9 !important; }
    </style>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-6">

        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50/50">
            <div>
                <h5 class="text-lg font-bold text-slate-800">Buku Pencatatan Mutasi</h5>
                <p class="text-sm text-slate-500">Riwayat pergerakan stok (masuk & keluar) di gudang utama pusat.</p>
            </div>
            <button onclick="window.print()" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-bold text-slate-600 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak Laporan
            </button>
        </div>

        <div class="p-6 overflow-x-auto">
            <table id="mutasiTable" class="w-full text-sm text-left text-slate-500" width="100%">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-bold">Waktu & Tanggal</th>
                        <th scope="col" class="px-6 py-4 font-bold">Jenis Mutasi</th>
                        <th scope="col" class="px-6 py-4 font-bold">Nama Produk</th>
                        <th scope="col" class="px-6 py-4 font-bold text-center">Kuantitas</th>
                        <th scope="col" class="px-6 py-4 font-bold">Referensi / Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mutasi as $item)
                        <tr class="bg-white border-b border-slate-100 hover:bg-slate-50 transition-colors">

                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-700">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</div>
                                <div class="text-xs text-slate-400 mt-0.5">{{ \Carbon\Carbon::parse($item->created_at)->format('H:i:s') }} WIB</div>
                            </td>

                            <td class="px-6 py-4">
                                @if(strtolower($item->jenis_mutasi) == 'masuk')
                                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold text-emerald-700 bg-emerald-100 rounded-md border border-emerald-200">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                        MASUK
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold text-rose-700 bg-rose-100 rounded-md border border-rose-200">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                        KELUAR
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div class="font-bold text-blue-600 text-sm">
                                    {{ $item->product?->nama_barang ?? 'Produk Dihapus' }}
                                </div>
                                <div class="text-xs text-slate-500 mt-0.5">
                                    {{ $item->product?->ukuran ?? '-' }} | {{ $item->product?->satuan ?? '-' }}
                                </div>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <span class="font-extrabold text-slate-700 text-base">
                                    @if(strtolower($item->jenis_mutasi) == 'masuk')
                                        <span class="text-emerald-500">+</span>
                                    @else
                                        <span class="text-rose-500">-</span>
                                    @endif
                                    {{ $item->qty }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-slate-700">
                                    {{ $item->keterangan ?? '-' }}
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#mutasiTable').DataTable({
                language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json' },
                "order": [[ 0, "desc" ]], // Urutkan dari tanggal terbaru
                "info": false,
                "autoWidth": false
            });
        });
    </script>
</x-app-layout>
