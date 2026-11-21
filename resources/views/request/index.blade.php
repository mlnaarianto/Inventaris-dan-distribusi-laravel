<x-app-layout>
    <x-slot name="header">
        @can('request.view-all') Permintaan Masuk @else Manajemen Pengajuan Barang @endcan
    </x-slot>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        table.dataTable, .dataTables_scrollHeadInner { width: 100% !important; }
        .dataTables_wrapper .dataTables_length select { width: 75px !important; padding: 4px 24px 4px 12px !important; background-color: #fff !important; color: #334155 !important; border: 1px solid #cbd5e1 !important; border-radius: 0.5rem !important; outline: none !important; background-position: right 0.5rem center !important; }
        .dataTables_wrapper .dataTables_filter input { background-color: #fff !important; color: #334155 !important; border: 1px solid #cbd5e1 !important; border-radius: 0.5rem !important; padding: 4px 12px !important; outline: none !important; margin-left: 8px !important; }
        .dataTables_wrapper .dataTables_filter input:focus, .dataTables_wrapper .dataTables_length select:focus { border-color: #2563eb !important; box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2) !important; }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover { background: #2563eb !important; color: white !important; border: none !important; border-radius: 0.5rem !important; }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover { background: #f1f5f9 !important; color: #1e293b !important; border: none !important; border-radius: 0.5rem !important; }
        table.dataTable.no-footer { border-bottom: 1px solid #f1f5f9 !important; }
    </style>

    @php
        $badgeMap = [
            'pending'  => 'bg-orange-100 text-orange-600 border-orange-200',
            'diproses' => 'bg-blue-100 text-blue-600 border-blue-200',
            'dikirim'  => 'bg-indigo-100 text-indigo-600 border-indigo-200',
            'selesai'  => 'bg-emerald-100 text-emerald-600 border-emerald-200',
        ];
    @endphp

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-6">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50/50">
            <div>
                <h5 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    @can('request.view-all') Daftar Order dari Distributor @else Riwayat Pesanan @endcan
                    <span class="px-2.5 py-0.5 rounded-md text-sm font-black uppercase tracking-wider border {{ $status ? ($badgeMap[$status] ?? '') : 'bg-slate-100 text-slate-600 border-slate-200' }}">
                        {{ $status ?: 'Keseluruhan' }}
                    </span>
                </h5>
                <p class="text-sm text-slate-500 mt-1">
                    @can('request.view-all')
                        Validasi pesanan, cek stok, dan proses pengiriman barang.
                    @else
                        Pantau status terkini dari barang yang Anda ajukan ke Pusat.
                    @endcan
                </p>
            </div>

            @can('request.create')
                <a href="{{ route('request.create') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-colors shadow-sm">
                    Ajukan Pesanan Baru
                </a>
            @endcan
        </div>

        <div class="p-6 overflow-x-auto">
            <table id="requestTable" class="w-full text-sm text-left text-slate-600" width="100%">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 font-bold">Kode Order & Tgl</th>
                        @can('request.view-all')
                            <th class="px-6 py-4 font-bold">Distributor Pemohon</th>
                        @endcan
                        <th class="px-6 py-4 font-bold text-center">Total Item</th>
                        <th class="px-6 py-4 font-bold text-center">Status</th>
                        <th class="px-6 py-4 font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requests as $req)
                        <tr class="bg-white border-b border-slate-100 hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-blue-600 text-base">{{ $req->kode_request }}</div>
                                <div class="text-xs text-slate-400 mt-0.5">{{ \Carbon\Carbon::parse($req->tanggal_request)->format('d M Y, H:i') }}</div>
                            </td>
                            @can('request.view-all')
                                <td class="px-6 py-4 font-bold text-slate-700">{{ $req->user?->name ?? 'Distributor Dihapus/Tidak Valid' }}</td>
                            @endcan
                            <td class="px-6 py-4 text-center font-bold text-slate-700">
                                {{ $req->details->sum('qty_diminta') }} <span class="text-xs text-slate-400 font-normal">Unit</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex px-3 py-1.5 text-xs font-bold uppercase tracking-wider border rounded-lg {{ $badgeMap[$req->status] ?? 'bg-slate-100 text-slate-600 border-slate-200' }}">
                                    {{ $req->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('request.show', $req->id) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-bold text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 hover:text-blue-600 transition-colors shadow-sm">
                                    @can('request.update-status')
                                        {{ $req->status === 'selesai' ? 'Detail' : 'Proses' }}
                                    @else
                                        {{ $req->status === 'dikirim' ? 'Terima / Detail' : 'Detail' }}
                                    @endcan
                                </a>
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
        $(document).ready(function () {
            $('#requestTable').DataTable({
                language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json' },
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