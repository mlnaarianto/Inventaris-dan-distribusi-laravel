<x-app-layout>
    <x-slot name="title">Laporan Mutasi Stok</x-slot>
    <x-slot name="header">Laporan Mutasi Stok</x-slot>

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
        .dataTables_wrapper .dataTables_filter input:focus,
        .dataTables_wrapper .dataTables_length select:focus {
            border-color: #2563eb !important; box-shadow: 0 0 0 2px rgba(37,99,235,0.2) !important;
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

        /* ================= DARK MODE ================= */
        .dark .dataTables_wrapper .dataTables_length select,
        .dark .dataTables_wrapper .dataTables_filter input {
            background-color: #0f172a !important; color: #e2e8f0 !important;
            border-color: #334155 !important;
        }
        .dark .dataTables_wrapper .dataTables_length select option { background-color: #0f172a; color: #e2e8f0; }
        .dark .dataTables_wrapper .dataTables_filter label,
        .dark .dataTables_wrapper .dataTables_length label,
        .dark .dataTables_wrapper .dataTables_info,
        .dark .dataTables_wrapper .dataTables_paginate { color: #94a3b8 !important; }
        .dark .dataTables_wrapper .dataTables_paginate .paginate_button { color: #cbd5e1 !important; }
        .dark .dataTables_wrapper .dataTables_paginate .paginate_button.disabled { color: #475569 !important; }
        .dark .dataTables_wrapper .dataTables_paginate .paginate_button:hover { background: #334155 !important; color: #f1f5f9 !important; }
        .dark .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dark .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover { background: #2563eb !important; color: white !important; }
        .dark table.dataTable.no-footer { border-bottom-color: #334155 !important; }
        .dark table.dataTable thead th, .dark table.dataTable thead td { border-bottom-color: #334155 !important; }
        .dark table.dataTable thead .sorting:before,
        .dark table.dataTable thead .sorting:after,
        .dark table.dataTable thead .sorting_asc:before,
        .dark table.dataTable thead .sorting_asc:after,
        .dark table.dataTable thead .sorting_desc:before,
        .dark table.dataTable thead .sorting_desc:after { opacity: 0.25; }
        .dark table.dataTable thead .sorting_asc:before,
        .dark table.dataTable thead .sorting_desc:after { opacity: 1; color: #60a5fa; }
    </style>

    {{-- Statistik dihitung dari collection yang sudah ada (tidak mengubah $mutasi) --}}
    @php
        $sumMasuk = 0;
        $sumKeluar = 0;
        $totalRow = 0;
        foreach ($mutasi as $m) {
            $totalRow++;
            if (strtolower($m->jenis_mutasi) === 'masuk') {
                $sumMasuk += (int) $m->qty;
            } else {
                $sumKeluar += (int) $m->qty;
            }
        }
    @endphp

    @if ($errors->any())
    <div class="mb-4 rounded-xl bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/30 text-red-700 dark:text-red-400 text-sm font-semibold px-4 py-3 flex items-start gap-2">
        <i class="fas fa-exclamation-circle mt-0.5"></i>
        <span>{{ $errors->first() }}</span>
    </div>
    @endif

    <div class="space-y-5 mb-6">

        {{-- ================= HERO + STATISTIK ================= --}}
        <div class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 dark:from-blue-700 dark:via-indigo-800 dark:to-slate-900 rounded-2xl p-5 sm:p-6 overflow-hidden shadow-lg shadow-blue-500/20 dark:shadow-black/40">
            <div class="absolute -top-20 -right-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-32 w-32 h-32 bg-indigo-400/20 rounded-full blur-2xl"></div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-5">

                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-blue-50 text-[10px] font-bold uppercase tracking-widest mb-3 backdrop-blur-md">
                        <i class="fas fa-history text-xs"></i>
                        Buku Pencatatan
                    </div>
                    <h5 class="text-xl sm:text-2xl font-extrabold text-white leading-tight">Buku Pencatatan Mutasi</h5>
                    <p class="text-blue-100/85 text-sm mt-1 max-w-md">
                        Riwayat pergerakan stok (masuk & keluar) di gudang utama pusat.
                    </p>
                </div>

                <div class="grid grid-cols-3 gap-2.5 sm:gap-3 shrink-0">
                    <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl p-3 text-center min-w-[88px]">
                        <p class="text-[9px] font-bold text-blue-100 uppercase tracking-wider">Total</p>
                        <p class="text-xl sm:text-2xl font-black text-white leading-tight">{{ number_format($totalRow, 0, ',', '.') }}</p>
                        <p class="text-[9px] text-blue-100/70">Transaksi</p>
                    </div>
                    <div class="bg-emerald-500/20 backdrop-blur-md border border-emerald-300/30 rounded-xl p-3 text-center min-w-[88px]">
                        <p class="text-[9px] font-bold text-emerald-200 uppercase tracking-wider">Masuk</p>
                        <p class="text-xl sm:text-2xl font-black text-emerald-300 leading-tight">+{{ number_format($sumMasuk, 0, ',', '.') }}</p>
                        <p class="text-[9px] text-emerald-100/70">Unit</p>
                    </div>
                    <div class="bg-rose-500/20 backdrop-blur-md border border-rose-300/30 rounded-xl p-3 text-center min-w-[88px]">
                        <p class="text-[9px] font-bold text-rose-200 uppercase tracking-wider">Keluar</p>
                        <p class="text-xl sm:text-2xl font-black text-rose-300 leading-tight">-{{ number_format($sumKeluar, 0, ',', '.') }}</p>
                        <p class="text-[9px] text-rose-100/70">Unit</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= FILTER & CETAK ================= --}}
        @can('mutasi.cetak')
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-4 sm:p-5 transition-colors">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-9 h-9 rounded-lg bg-blue-50 dark:bg-blue-500/15 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                    <i class="fas fa-filter text-sm"></i>
                </div>
                <div>
                    <h6 class="text-sm font-bold text-slate-800 dark:text-white">Filter & Cetak Laporan</h6>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Tentukan rentang tanggal & jenis mutasi.</p>
                </div>
            </div>

            <form method="GET" action="{{ route('mutasi.cetak') }}" target="_blank"
                class="grid grid-cols-2 lg:grid-cols-5 gap-3 items-end">

                <div>
                    <label for="dari" class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 mb-1 uppercase tracking-wider">Dari Tanggal</label>
                    <input type="date" id="dari" name="dari"
                        class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 text-slate-800 dark:text-white text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 p-2.5 outline-none transition-all" />
                </div>

                <div>
                    <label for="sampai" class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 mb-1 uppercase tracking-wider">Sampai Tanggal</label>
                    <input type="date" id="sampai" name="sampai"
                        class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 text-slate-800 dark:text-white text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 p-2.5 outline-none transition-all" />
                </div>

                <div class="col-span-2 lg:col-span-1">
                    <label for="jenis" class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 mb-1 uppercase tracking-wider">Jenis Mutasi</label>
                    <select id="jenis" name="jenis"
                        class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 text-slate-800 dark:text-white text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 p-2.5 outline-none transition-all">
                        <option value="">Semua Jenis</option>
                        <option value="masuk">Masuk</option>
                        <option value="keluar">Keluar</option>
                    </select>
                </div>

                <div class="col-span-2 lg:col-span-1 flex gap-2">
                    <button type="submit"
                        class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2.5 text-xs font-bold text-emerald-700 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-500/15 border border-emerald-200 dark:border-emerald-500/30 rounded-xl hover:bg-emerald-100 dark:hover:bg-emerald-500/25 transition-colors shadow-sm">
                        <i class="fas fa-print text-[11px]"></i>
                        Cetak
                    </button>
                    <button type="submit" name="unduh" value="1" formtarget="_self"
                        class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2.5 text-xs font-bold text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-500/15 border border-blue-200 dark:border-blue-500/30 rounded-xl hover:bg-blue-100 dark:hover:bg-blue-500/25 transition-colors shadow-sm">
                        <i class="fas fa-file-pdf text-[11px]"></i>
                        Unduh PDF
                    </button>
                </div>
            </form>
        </div>
        @endcan

        {{-- ================= TABEL ================= --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden transition-colors">

            <div class="p-4 sm:p-5 border-b border-slate-100 dark:border-slate-700 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-indigo-50 dark:bg-indigo-500/15 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0">
                    <i class="fas fa-list-ul text-sm"></i>
                </div>
                <div>
                    <h6 class="text-sm font-bold text-slate-800 dark:text-white">Riwayat Pergerakan Stok</h6>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Urut dari transaksi terbaru.</p>
                </div>
            </div>

            <div class="p-4 sm:p-6 overflow-x-auto">
                <table id="mutasiTable" class="w-full text-sm text-left text-slate-500 dark:text-slate-300" width="100%">
                    <thead class="text-[11px] text-slate-500 dark:text-slate-400 uppercase bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700">
                        <tr>
                            <th scope="col" class="px-4 sm:px-6 py-3 font-bold">Waktu & Tanggal</th>
                            <th scope="col" class="px-4 sm:px-6 py-3 font-bold">Jenis Mutasi</th>
                            <th scope="col" class="px-4 sm:px-6 py-3 font-bold">Nama Produk</th>
                            <th scope="col" class="px-4 sm:px-6 py-3 font-bold text-center">Kuantitas</th>
                            <th scope="col" class="px-4 sm:px-6 py-3 font-bold">Referensi / Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @foreach ($mutasi as $item)
                        @php $masuk = strtolower($item->jenis_mutasi) == 'masuk'; @endphp
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/40 transition-colors">

                            <td class="px-4 sm:px-6 py-3.5" data-order="{{ \Carbon\Carbon::parse($item->created_at)->timestamp }}">
                                <div class="font-bold text-slate-700 dark:text-white text-[13px]">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</div>
                                <div class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">{{ \Carbon\Carbon::parse($item->created_at)->format('H:i:s') }} WIB</div>
                            </td>

                            <td class="px-4 sm:px-6 py-3.5">
                                @if ($masuk)
                                <span class="inline-flex items-center px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-emerald-700 dark:text-emerald-400 bg-emerald-100 dark:bg-emerald-500/15 border border-emerald-200 dark:border-emerald-500/30 rounded-md">
                                    <i class="fas fa-arrow-down mr-1 text-[9px]"></i>
                                    Masuk
                                </span>
                                @else
                                <span class="inline-flex items-center px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-rose-700 dark:text-rose-400 bg-rose-100 dark:bg-rose-500/15 border border-rose-200 dark:border-rose-500/30 rounded-md">
                                    <i class="fas fa-arrow-up mr-1 text-[9px]"></i>
                                    Keluar
                                </span>
                                @endif
                            </td>

                            <td class="px-4 sm:px-6 py-3.5">
                                <div class="font-bold text-blue-600 dark:text-blue-400 text-[13px]">
                                    {{ $item->product?->nama_barang ?? 'Produk Dihapus' }}
                                </div>
                                <div class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                    {{ $item->product?->ukuran ?? '-' }} <span class="text-slate-300 dark:text-slate-600 mx-1">|</span> {{ $item->product?->satuan ?? '-' }}
                                </div>
                            </td>

                            <td class="px-4 sm:px-6 py-3.5 text-center">
                                <span class="inline-flex items-center justify-center font-extrabold text-sm px-3 py-1 rounded-lg
                                    {{ $masuk
                                        ? 'text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/15'
                                        : 'text-rose-700 dark:text-rose-400 bg-rose-50 dark:bg-rose-500/15' }}">
                                    {{ $masuk ? '+' : '-' }}{{ $item->qty }}
                                </span>
                            </td>

                            <td class="px-4 sm:px-6 py-3.5">
                                <div class="text-sm font-semibold text-slate-700 dark:text-slate-300">
                                    {{ $item->keterangan ?? '-' }}
                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#mutasiTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json',
                    emptyTable: '<div class="text-center py-10">' +
                        '<i class="fas fa-inbox text-4xl text-slate-300 dark:text-slate-600"></i>' +
                        '<p class="text-sm font-bold text-slate-500 dark:text-slate-400 mt-3">Belum ada data mutasi</p>' +
                        '<p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Data akan muncul setelah ada transaksi stok.</p>' +
                        '</div>'
                },
                "order": [[0, "desc"]],
                "info": false,
                "autoWidth": false,
                "pageLength": 10
            });
        });
    </script>
</x-app-layout>