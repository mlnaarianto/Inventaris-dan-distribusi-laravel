<x-app-layout>
    <x-slot name="title">Master Katalog Barang</x-slot>
    <x-slot name="header">
        Master Katalog Barang
    </x-slot>

    @php
        $canManage = auth()->user()->canany(['produk.update', 'produk.delete']);
        $viewAll   = auth()->user()->can('request.view-all');

        // Statistik (read-only, tidak mengubah $produk)
        $totalProduk     = $produk->count();
        $totalStokPusat  = $produk->sum('stok_pusat');
        $totalStokDist   = $produk->sum('stok_distributor');
    @endphp

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
            padding: 8px 12px 8px 36px !important; outline: none !important;
            margin-left: 0 !important; min-width: 240px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='%2394a3b8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: 10px center;
            background-size: 16px;
        }
        .dataTables_wrapper .dataTables_filter label { font-weight: 700 !important; font-size: 0 !important; }
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
            background-color: #0f172a !important; color: #e2e8f0 !important; border-color: #334155 !important;
        }
        .dark .dataTables_wrapper .dataTables_filter input {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: 10px center;
            background-size: 16px;
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

    <div class="space-y-5 mb-6">

        {{-- ================= HERO ================= --}}
        <div class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 dark:from-blue-700 dark:via-indigo-800 dark:to-slate-900 rounded-2xl p-5 sm:p-6 overflow-hidden shadow-lg shadow-blue-500/20 dark:shadow-black/40">
            <div class="absolute -top-20 -right-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-32 w-32 h-32 bg-indigo-400/20 rounded-full blur-2xl"></div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-5">

                <div class="min-w-0">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-blue-50 text-[10px] font-bold uppercase tracking-widest mb-3 backdrop-blur-md">
                        <i class="fas fa-boxes text-xs"></i>
                        Master Data Produk
                    </div>

                    <h5 class="text-xl sm:text-2xl font-extrabold text-white leading-tight">Tabel Inventaris Utama</h5>
                    <p class="text-blue-100/85 text-sm mt-1 max-w-md leading-relaxed">
                        @can('produk.create')
                            Kelola master data produk spesifik, harga kemasan, dan pantau ketersediaan stok fisik.
                        @else
                            Lihat daftar produk, harga kemasan, dan ketersediaan stok.
                        @endcan
                    </p>

                    @can('produk.create')
                        <div class="mt-4">
                            <a href="{{ route('produk.create') }}"
                               class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-blue-700 dark:text-blue-900 bg-white hover:bg-blue-50 rounded-xl transition-all hover:-translate-y-0.5 shadow-md">
                                <i class="fas fa-plus text-xs"></i>
                                Tambah Produk
                            </a>
                        </div>
                    @endcan
                </div>

                {{-- Mini Stats --}}
                <div class="grid {{ $viewAll ? 'grid-cols-3' : 'grid-cols-2' }} gap-2.5 sm:gap-3 shrink-0">
                    <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl p-3 text-center min-w-[88px]">
                        <p class="text-[9px] font-bold text-blue-100 uppercase tracking-wider">Produk</p>
                        <p class="text-xl sm:text-2xl font-black text-white leading-tight">{{ number_format($totalProduk, 0, ',', '.') }}</p>
                        <p class="text-[9px] text-blue-100/70">Jenis</p>
                    </div>
                    @if ($viewAll)
                        <div class="bg-emerald-500/20 backdrop-blur-md border border-emerald-300/30 rounded-xl p-3 text-center min-w-[88px]">
                            <p class="text-[9px] font-bold text-emerald-200 uppercase tracking-wider">Stok Pusat</p>
                            <p class="text-xl sm:text-2xl font-black text-emerald-300 leading-tight">{{ number_format($totalStokPusat, 0, ',', '.') }}</p>
                            <p class="text-[9px] text-emerald-100/70">Unit</p>
                        </div>
                    @endif
                    <div class="bg-indigo-500/20 backdrop-blur-md border border-indigo-300/30 rounded-xl p-3 text-center min-w-[88px]">
                        <p class="text-[9px] font-bold text-indigo-200 uppercase tracking-wider">Stok Distributor</p>
                        <p class="text-xl sm:text-2xl font-black text-indigo-300 leading-tight">{{ number_format($totalStokDist, 0, ',', '.') }}</p>
                        <p class="text-[9px] text-indigo-100/70">Unit</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= TABLE CARD ================= --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden transition-colors">

            <div class="p-4 sm:p-5 border-b border-slate-100 dark:border-slate-700 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-indigo-50 dark:bg-indigo-500/15 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0">
                    <i class="fas fa-list-ul text-sm"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <h6 class="text-sm font-bold text-slate-800 dark:text-white">Daftar Produk</h6>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Gunakan pencarian & pengurutan untuk menemukan produk.</p>
                </div>
            </div>

            <div class="p-4 sm:p-6 overflow-x-auto">
                <table id="productTable" class="w-full text-sm text-left text-slate-500 dark:text-slate-300" width="100%">
                    <thead class="text-[11px] text-slate-500 dark:text-slate-400 uppercase bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700">
                        <tr>
                            <th scope="col" class="px-4 sm:px-6 py-3 font-bold">Info & Foto Produk</th>
                            <th scope="col" class="px-4 sm:px-6 py-3 font-bold text-right">Harga Jual</th>
                            @if ($viewAll)
                                <th scope="col" class="px-4 sm:px-6 py-3 font-bold text-center">Stok Pusat</th>
                            @endif
                            <th scope="col" class="px-4 sm:px-6 py-3 font-bold text-center">Stok Distributor</th>
                            @if ($canManage)
                                <th scope="col" class="px-4 sm:px-6 py-3 font-bold text-center">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @foreach ($produk as $item)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/40 transition-colors">

                                <td class="px-4 sm:px-6 py-3.5">
                                    <div class="flex items-center gap-3">
                                        @if($item->gambar)
                                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="Foto" class="w-12 h-12 rounded-xl object-cover border border-slate-200 dark:border-slate-600 shadow-sm shrink-0 bg-slate-50 dark:bg-slate-900">
                                        @else
                                            <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-500/15 text-blue-600 dark:text-blue-400 font-bold flex items-center justify-center text-lg shrink-0 border border-blue-200 dark:border-blue-500/30">
                                                {{ strtoupper(substr($item->nama_barang, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div class="min-w-0">
                                            <div class="font-bold text-slate-700 dark:text-white text-sm leading-tight truncate">{{ $item->nama_barang }}</div>
                                            <div class="flex items-center gap-2 mt-1 flex-wrap">
                                                <span class="text-xs text-slate-500 dark:text-slate-400">{{ $item->ukuran }}</span>
                                                <span class="px-1.5 py-0.5 rounded bg-blue-50 dark:bg-blue-500/15 border border-blue-100 dark:border-blue-500/30 text-blue-600 dark:text-blue-400 font-bold text-[10px] uppercase tracking-wider">{{ $item->satuan }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-4 sm:px-6 py-3.5 text-right">
                                    <span class="font-extrabold text-slate-800 dark:text-white text-sm whitespace-nowrap">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                                </td>

                                @if ($viewAll)
                                    <td class="px-4 sm:px-6 py-3.5 text-center">
                                        <span class="inline-flex items-center justify-center min-w-[3rem] px-3 py-1.5 text-sm font-bold text-blue-700 dark:text-blue-400 bg-blue-50 dark:bg-blue-500/15 border border-blue-200 dark:border-blue-500/30 rounded-lg">
                                            {{ $item->stok_pusat }}
                                        </span>
                                    </td>
                                @endif

                                <td class="px-4 sm:px-6 py-3.5 text-center">
                                    <span class="inline-flex items-center justify-center min-w-[3rem] px-3 py-1.5 text-sm font-bold text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg">
                                        {{ $item->stok_distributor }}
                                    </span>
                                </td>

                                @if ($canManage)
                                    <td class="px-4 sm:px-6 py-3.5 text-center">
                                        <div class="flex items-center justify-center gap-1">
                                            @can('produk.update')
                                                <a href="{{ route('produk.edit', $item->id) }}" class="inline-flex items-center justify-center w-8 h-8 text-slate-400 dark:text-slate-500 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-500/10 rounded-lg transition-all" title="Edit Data" aria-label="Edit {{ $item->nama_barang }}">
                                                    <i class="fas fa-pen text-sm"></i>
                                                </a>
                                            @endcan

                                            @can('produk.delete')
                                                <form id="delete-form-{{ $item->id }}" action="{{ route('produk.destroy', $item->id) }}" method="POST" class="m-0 p-0 flex items-center">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="confirmDelete({{ $item->id }})" class="inline-flex items-center justify-center w-8 h-8 text-slate-400 dark:text-slate-500 hover:text-red-500 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-lg transition-all bg-transparent border-0 cursor-pointer" title="Hapus Data" aria-label="Hapus {{ $item->nama_barang }}">
                                                        <i class="fas fa-trash text-sm"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                @endif
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
        $(document).ready(function() {
            $('#productTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json',
                    emptyTable: '<div class="text-center py-10">' +
                        '<i class="fas fa-box-open text-4xl text-slate-300 dark:text-slate-600"></i>' +
                        '<p class="text-sm font-bold text-slate-500 dark:text-slate-400 mt-3">Belum ada produk</p>' +
                        '<p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Katalog masih kosong atau tidak ada hasil pencarian.</p>' +
                        '</div>'
                },
                "pageLength": 10, "ordering": true, "info": false, "autoWidth": false
                @if ($canManage)
                    , "columnDefs": [{ "orderable": false, "targets": -1 }]
                @endif
            });
        });

        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: @json(session('success')), showConfirmButton: false, timer: 2000, iconColor: '#2563eb', customClass: { popup: 'rounded-2xl' } });
        @endif

        @if(session('error'))
            Swal.fire({ icon: 'error', title: 'Gagal!', text: @json(session('error')), confirmButtonColor: '#ef4444', customClass: { popup: 'rounded-2xl' } });
        @endif

        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Produk?',
                text: 'Data yang dihapus tidak bisa dikembalikan ke sistem.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#94a3b8',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, Hapus',
                customClass: { popup: 'rounded-2xl' }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
</x-app-layout>