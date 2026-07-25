<x-app-layout>
    <x-slot name="header">
        Master Katalog Barang
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
                <h5 class="text-lg font-bold text-slate-800">Tabel Inventaris Utama</h5>
                <p class="text-sm text-slate-500">Kelola master data produk spesifik, harga kemasan, dan pantau ketersediaan stok fisik.</p>
            </div>
            <a href="{{ route('pusat.produk.create') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-colors shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Produk
            </a>
        </div>

        <div class="p-6 overflow-x-auto">
            <table id="productTable" class="w-full text-sm text-left text-slate-500" width="100%">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-bold">Info & Foto Produk</th>
                        <th scope="col" class="px-6 py-4 font-bold text-right">Harga Jual</th>
                        <th scope="col" class="px-6 py-4 font-bold text-center">Stok Pusat</th>
                        <th scope="col" class="px-6 py-4 font-bold text-center">Stok Distributor</th>
                        <th scope="col" class="px-6 py-4 font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produk as $item)
                        <tr class="bg-white border-b border-slate-100 hover:bg-slate-50 transition-colors">

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    @if($item->gambar)
                                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="Foto" class="w-12 h-12 rounded-xl object-cover border border-slate-200 shadow-sm shrink-0 bg-slate-50">
                                    @else
                                        <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 font-bold flex items-center justify-center text-lg shrink-0 border border-blue-200">
                                            {{ strtoupper(substr($item->nama_barang, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-bold text-slate-700 text-base leading-tight">{{ $item->nama_barang }}</div>
                                        <div class="text-xs text-slate-500 mt-1">{{ $item->ukuran }} <span class="mx-1 text-slate-300">|</span> Per <span class="px-1.5 py-0.5 rounded bg-blue-50 border border-blue-100 text-blue-600 font-bold text-[10px] uppercase tracking-wider">{{ $item->satuan }}</span></div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-right font-extrabold text-slate-700 text-sm">
                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center justify-center min-w-[3rem] px-3 py-1.5 text-sm font-bold text-blue-700 bg-blue-50 border border-blue-200 rounded-lg">
                                    {{ $item->stok_pusat }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center justify-center min-w-[3rem] px-3 py-1.5 text-sm font-bold text-slate-600 bg-slate-100 border border-slate-200 rounded-lg">
                                    {{ $item->stok_distributor }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-4">
                                    <a href="{{ route('pusat.produk.edit', $item->id) }}" class="text-slate-400 hover:text-blue-600 transition-colors transform hover:scale-110" title="Edit Data">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>

                                    <form id="delete-form-{{ $item->id }}" action="{{ route('pusat.produk.destroy', $item->id) }}" method="POST" class="m-0 p-0 flex items-center">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $item->id }})" class="text-slate-400 hover:text-red-500 transition-colors transform hover:scale-110 bg-transparent border-0 cursor-pointer p-0" title="Hapus Data">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#productTable').DataTable({
                language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json' },
                "pageLength": 10, "ordering": true, "info": false, "autoWidth": false
            });
        });

        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ session('success') }}', showConfirmButton: false, timer: 2000, iconColor: '#2563eb', customClass: { popup: 'rounded-2xl' } });
        @endif

        function confirmDelete(id) {
            Swal.fire({ title: 'Hapus Produk?', text: "Data yang dihapus tidak bisa dikembalikan ke sistem.", icon: 'warning', showCancelButton: true, confirmButtonColor: '#ef4444', cancelButtonColor: '#94a3b8', cancelButtonText: 'Batal', confirmButtonText: 'Ya, Hapus', customClass: { popup: 'rounded-2xl' } }).then((result) => { if (result.isConfirmed) { document.getElementById('delete-form-' + id).submit(); } })
        }
    </script>
</x-app-layout>
