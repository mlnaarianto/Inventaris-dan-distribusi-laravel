<x-app-layout>
    <x-slot name="header">
        Permintaan Masuk
    </x-slot>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        table.dataTable, .dataTables_scrollHeadInner { width: 100% !important; }
        .dataTables_wrapper .dataTables_length select { width: 75px !important; padding: 4px 24px 4px 12px !important; background-color: #ffffff !important; color: #334155 !important; border: 1px solid #cbd5e1 !important; border-radius: 0.5rem !important; outline: none !important; background-position: right 0.5rem center !important; }
        .dataTables_wrapper .dataTables_filter input { background-color: #ffffff !important; color: #334155 !important; border: 1px solid #cbd5e1 !important; border-radius: 0.5rem !important; padding: 4px 12px !important; outline: none !important; margin-left: 8px !important; }
        .dataTables_wrapper .dataTables_filter input:focus, .dataTables_wrapper .dataTables_length select:focus { border-color: #2563eb !important; box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2) !important; }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover { background: #2563eb !important; color: white !important; border: none !important; border-radius: 0.5rem !important; }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover { background: #f1f5f9 !important; color: #1e293b !important; border: none !important; border-radius: 0.5rem !important; }
        table.dataTable.no-footer { border-bottom: 1px solid #f1f5f9 !important; }
    </style>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-6">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <div>
                <h5 class="text-lg font-bold text-slate-800">Daftar Order dari Distributor</h5>
                <p class="text-sm text-slate-500">Validasi pesanan, cek stok, dan proses pengiriman barang.</p>
            </div>
        </div>

        <div class="p-6 overflow-x-auto">
            <table id="pusatRequestTable" class="w-full text-sm text-left text-slate-500" width="100%">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 font-bold">Kode Order & Tgl</th>
                        <th class="px-6 py-4 font-bold">Distributor Pemohon</th>
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
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-700">{{ $req->user?->name ?? 'Distributor Dihapus/Tidak Valid' }}</div>
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-slate-700">
                                {{ $req->details->sum('qty_diminta') }} <span class="text-xs text-slate-400 font-normal">Unit</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $badge = 'bg-orange-100 text-orange-600';
                                    if ($req->status == 'diproses') $badge = 'bg-blue-100 text-blue-600';
                                    if ($req->status == 'dikirim') $badge = 'bg-indigo-100 text-indigo-600';
                                    if ($req->status == 'selesai') $badge = 'bg-emerald-100 text-emerald-600';
                                @endphp
                                <span class="px-3 py-1.5 text-xs font-bold uppercase rounded-lg {{ $badge }}">
                                    {{ $req->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('pusat.request.show', $req->id) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-bold text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 hover:text-blue-600 transition-colors shadow-sm">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Proses
                                    </a>
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
            $('#pusatRequestTable').DataTable({
                language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json' },
                "order": [[ 0, "desc" ]],
                "info": false,
                "autoWidth": false
            });
        });
    </script>
</x-app-layout>
