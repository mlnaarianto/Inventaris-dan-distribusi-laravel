<x-app-layout>
    <x-slot name="header">
        Manajemen Pengajuan Barang
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

    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden mb-6">

        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50/50">
            <div>
                <h5 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    Riwayat Pesanan
                    @if(isset($status) && $status)
                        <span class="px-2.5 py-0.5 rounded-md text-sm font-black uppercase tracking-wider
                            {{ $status == 'pending' ? 'bg-orange-100 text-orange-600' : '' }}
                            {{ $status == 'diproses' ? 'bg-blue-100 text-blue-600' : '' }}
                            {{ $status == 'dikirim' ? 'bg-indigo-100 text-indigo-600' : '' }}
                            {{ $status == 'selesai' ? 'bg-emerald-100 text-emerald-600' : '' }}
                        ">
                            {{ $status }}
                        </span>
                    @else
                        <span class="px-2.5 py-0.5 rounded-md text-sm font-black uppercase tracking-wider bg-slate-100 text-slate-600">KESELURUHAN</span>
                    @endif
                </h5>
                <p class="text-sm text-slate-500 mt-1">Pantau status terkini dari barang yang Anda ajukan ke Pusat.</p>
            </div>

            <a href="{{ route('distributor.request.create') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-colors shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Ajukan Pesanan Baru
            </a>
        </div>

        <div class="p-6 overflow-x-auto">
            <table id="requestTable" class="w-full text-sm text-left text-slate-600" width="100%">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-bold">Kode Pesanan</th>
                        <th scope="col" class="px-6 py-4 font-bold">Waktu Pengajuan</th>
                        <th scope="col" class="px-6 py-4 font-bold text-center">Status Alur</th>
                        <th scope="col" class="px-6 py-4 font-bold text-center">Aksi / Rincian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requests as $item)
                        <tr class="bg-white border-b border-slate-100 hover:bg-slate-50 transition-colors">

                            <td class="px-6 py-4">
                                <span class="font-bold text-slate-800">{{ $item->kode_request }}</span>
                            </td>

                            <td class="px-6 py-4 font-medium">
                                {{ \Carbon\Carbon::parse($item->tanggal_request)->format('d F Y, H:i') }} WIB
                            </td>

                            <td class="px-6 py-4 text-center">
                                @php
                                    $badgeClass = 'bg-orange-100 text-orange-600 border-orange-200';
                                    if ($item->status == 'diproses') { $badgeClass = 'bg-blue-100 text-blue-600 border-blue-200'; }
                                    if ($item->status == 'dikirim') { $badgeClass = 'bg-indigo-100 text-indigo-600 border-indigo-200'; }
                                    if ($item->status == 'selesai') { $badgeClass = 'bg-emerald-100 text-emerald-600 border-emerald-200'; }
                                @endphp
                                <span class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-bold uppercase tracking-wider border rounded-lg {{ $badgeClass }}">
                                    {{ $item->status }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('distributor.request.show', $item->id) }}" class="inline-flex items-center justify-center p-2 text-slate-400 hover:text-blue-600 bg-white hover:bg-blue-50 border border-transparent hover:border-blue-100 rounded-xl transition-all transform hover:scale-110" title="Lihat Detail & Terima Barang">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
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
        $(document).ready(function() {
            $('#requestTable').DataTable({
                language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json' },
                "pageLength": 10,
                "ordering": true,
                "order": [[1, "desc"]], // Mengurutkan dari tanggal terbaru
                "info": false,
                "autoWidth": false
            });
        });

        // Menangkap notifikasi dari Controller
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2500,
                iconColor: '#2563eb',
                customClass: { popup: 'rounded-3xl' }
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#ef4444',
                customClass: { popup: 'rounded-3xl' }
            });
        @endif
    </script>
</x-app-layout>
