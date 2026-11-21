<x-app-layout>
    <x-slot name="title">Daftar Permintaan</x-slot>
    <x-slot name="header">
        @can('request.view-all') Permintaan Masuk @else Daftar Pengajuan Barang @endcan
    </x-slot>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        table.dataTable, .dataTables_scrollHeadInner { width: 100% !important; }

        .dataTables_wrapper .dataTables_length select {
            width: 75px !important; padding: 4px 24px 4px 12px !important;
            background-color: #fff !important; color: #334155 !important;
            border: 1px solid #cbd5e1 !important; border-radius: 0.5rem !important;
            outline: none !important; background-position: right 0.5rem center !important;
        }
        .dataTables_wrapper .dataTables_filter input {
            background-color: #fff !important; color: #334155 !important;
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

    @php
        $badgeMap = [
            'pending'  => 'bg-orange-100 text-orange-700 border-orange-200 dark:bg-orange-500/15 dark:text-orange-400 dark:border-orange-500/30',
            'diproses' => 'bg-blue-100 text-blue-700 border-blue-200 dark:bg-blue-500/15 dark:text-blue-400 dark:border-blue-500/30',
            'dikirim'  => 'bg-indigo-100 text-indigo-700 border-indigo-200 dark:bg-indigo-500/15 dark:text-indigo-400 dark:border-indigo-500/30',
            'selesai'  => 'bg-emerald-100 text-emerald-700 border-emerald-200 dark:bg-emerald-500/15 dark:text-emerald-400 dark:border-emerald-500/30',
        ];
    @endphp

    <div class="space-y-5 mb-6">

        {{-- ================= HERO / HEADER CARD ================= --}}
        <div class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 dark:from-blue-700 dark:via-indigo-800 dark:to-slate-900 rounded-2xl p-5 sm:p-6 overflow-hidden shadow-lg shadow-blue-500/20 dark:shadow-black/40">
            <div class="absolute -top-20 -right-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-32 w-32 h-32 bg-indigo-400/20 rounded-full blur-2xl"></div>

            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-5">

                <div class="min-w-0">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-blue-50 text-[10px] font-bold uppercase tracking-widest mb-3 backdrop-blur-md">
                        <i class="fas fa-inbox text-xs"></i>
                        @can('request.view-all') Inbox Distributor @else Riwayat Pengajuan @endcan
                    </div>

                    <div class="flex items-center gap-3 flex-wrap">
                        <h5 class="text-xl sm:text-2xl font-extrabold text-white leading-tight">
                            @can('request.view-all') Daftar Order dari Distributor @else Daftar Pesanan @endcan
                        </h5>
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-[11px] font-black uppercase tracking-wider border backdrop-blur-md
                            {{ $status
                                ? (strpos($badgeMap[$status] ?? '', 'bg-orange') !== false ? 'bg-orange-500/20 text-orange-200 border-orange-300/30'
                                  : (strpos($badgeMap[$status] ?? '', 'bg-blue') !== false ? 'bg-blue-500/20 text-blue-200 border-blue-300/30'
                                  : (strpos($badgeMap[$status] ?? '', 'bg-indigo') !== false ? 'bg-indigo-500/20 text-indigo-200 border-indigo-300/30'
                                  : (strpos($badgeMap[$status] ?? '', 'bg-emerald') !== false ? 'bg-emerald-500/20 text-emerald-200 border-emerald-300/30'
                                  : 'bg-white/15 text-white border-white/30'))))
                                : 'bg-white/15 text-white border-white/30' }}">
                            {{ $status ?: 'Keseluruhan' }}
                        </span>
                    </div>

                    <p class="text-blue-100/85 text-sm mt-1 max-w-md leading-relaxed">
                        @can('request.view-all')
                            Validasi pesanan, cek stok, dan proses pengiriman barang.
                        @else
                            Pantau status pengajuan barang ke Pusat. Order milik Anda ditandai "Order Anda".
                        @endcan
                    </p>
                </div>

                @can('request.create')
                    <a href="{{ route('request.create') }}"
                       class="inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-bold text-blue-700 dark:text-blue-900 bg-white hover:bg-blue-50 rounded-xl transition-all hover:-translate-y-0.5 shadow-md shrink-0">
                        <i class="fas fa-plus text-xs"></i>
                        Ajukan Pesanan Baru
                    </a>
                @endcan
            </div>
        </div>

        {{-- ================= TABEL ================= --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden transition-colors">

            <div class="p-4 sm:p-5 border-b border-slate-100 dark:border-slate-700 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-indigo-50 dark:bg-indigo-500/15 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0">
                    <i class="fas fa-list-ul text-sm"></i>
                </div>
                <div class="min-w-0">
                    <h6 class="text-sm font-bold text-slate-800 dark:text-white">Riwayat Permintaan</h6>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Urut dari transaksi terbaru.</p>
                </div>
            </div>

            <div class="p-4 sm:p-6 overflow-x-auto">
                <table id="requestTable" class="w-full text-sm text-left text-slate-600 dark:text-slate-300" width="100%">
                    <thead class="text-[11px] text-slate-500 dark:text-slate-400 uppercase bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700">
                        <tr>
                            <th class="px-4 sm:px-6 py-3 font-bold">Kode Order & Tgl</th>
                            <th class="px-4 sm:px-6 py-3 font-bold">Distributor Pemohon</th>
                            <th class="px-4 sm:px-6 py-3 font-bold text-center">Total Item</th>
                            <th class="px-4 sm:px-6 py-3 font-bold text-center">Status</th>
                            <th class="px-4 sm:px-6 py-3 font-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @foreach ($requests as $req)
                            @php $milikSaya = $req->user_id === auth()->id(); @endphp
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/40 transition-colors">

                                <td class="px-4 sm:px-6 py-3.5" data-order="{{ \Carbon\Carbon::parse($req->tanggal_request)->timestamp }}">
                                    <div class="font-bold text-blue-600 dark:text-blue-400 text-sm font-mono">{{ $req->kode_request }}</div>
                                    <div class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">{{ \Carbon\Carbon::parse($req->tanggal_request)->format('d M Y, H:i') }}</div>
                                </td>

                                <td class="px-4 sm:px-6 py-3.5">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="font-bold text-slate-700 dark:text-white text-sm">{{ $req->user?->name ?? 'Distributor Dihapus/Tidak Valid' }}</span>
                                        @if ($milikSaya)
                                            <span class="inline-flex items-center gap-1 text-[10px] font-bold uppercase text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/15 border border-emerald-200 dark:border-emerald-500/30 px-2 py-0.5 rounded-full">
                                                <i class="fas fa-user-check text-[8px]"></i>
                                                Order Anda
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-4 sm:px-6 py-3.5 text-center">
                                    <span class="inline-flex items-baseline gap-1 px-3 py-1 rounded-lg bg-slate-100 dark:bg-slate-700 border border-slate-200 dark:border-slate-600">
                                        <span class="font-extrabold text-slate-700 dark:text-white text-sm">{{ $req->details->sum('qty_diminta') }}</span>
                                        <span class="text-[10px] text-slate-500 dark:text-slate-400 font-medium uppercase">Unit</span>
                                    </span>
                                </td>

                                <td class="px-4 sm:px-6 py-3.5 text-center">
                                    <span class="inline-flex items-center px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider border rounded-lg {{ $badgeMap[$req->status] ?? 'bg-slate-100 text-slate-600 border-slate-200 dark:bg-slate-700 dark:text-slate-300 dark:border-slate-600' }}">
                                        @if($req->status === 'pending') <i class="fas fa-clock mr-1 text-[9px]"></i>
                                        @elseif($req->status === 'diproses') <i class="fas fa-box-open mr-1 text-[9px]"></i>
                                        @elseif($req->status === 'dikirim') <i class="fas fa-truck mr-1 text-[9px]"></i>
                                        @elseif($req->status === 'selesai') <i class="fas fa-check-circle mr-1 text-[9px]"></i>
                                        @endif
                                        {{ $req->status }}
                                    </span>
                                </td>

                                <td class="px-4 sm:px-6 py-3.5 text-center">
                                    <a href="{{ route('request.show', $req->id) }}"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-600 hover:text-blue-600 dark:hover:text-blue-400 hover:border-blue-300 dark:hover:border-blue-500/40 transition-colors shadow-sm">
                                        @can('request.update-status')
                                            <i class="fas {{ $req->status === 'selesai' ? 'fa-eye' : 'fa-tasks' }} text-[10px]"></i>
                                            {{ $req->status === 'selesai' ? 'Detail' : 'Proses' }}
                                        @else
                                            <i class="fas {{ ($req->status === 'dikirim' && $milikSaya) ? 'fa-check-double' : 'fa-eye' }} text-[10px]"></i>
                                            {{ ($req->status === 'dikirim' && $milikSaya) ? 'Terima / Detail' : 'Detail' }}
                                        @endcan
                                    </a>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $('#requestTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json',
                    emptyTable: '<div class="text-center py-10">' +
                        '<i class="fas fa-inbox text-4xl text-slate-300 dark:text-slate-600"></i>' +
                        '<p class="text-sm font-bold text-slate-500 dark:text-slate-400 mt-3">Belum ada permintaan</p>' +
                        '<p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Daftar pesanan akan muncul di sini.</p>' +
                        '</div>'
                },
                pageLength: 10,
                order: [[0, 'desc']],
                info: false,
                autoWidth: false
            });
        });

        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: @json(session('success')), showConfirmButton: false, timer: 2500, iconColor: '#2563eb', customClass: { popup: 'rounded-3xl' } });
        @endif
        @if(session('error'))
            Swal.fire({ icon: 'error', title: 'Gagal!', text: @json(session('error')), confirmButtonColor: '#ef4444', customClass: { popup: 'rounded-3xl' } });
        @endif
    </script>
</x-app-layout>