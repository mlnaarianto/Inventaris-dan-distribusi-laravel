<x-app-layout>
    <x-slot name="header">
        Form Pengajuan Barang Baru
    </x-slot>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-6 max-w-5xl mx-auto">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <div>
                <h5 class="text-lg font-bold text-slate-800">Detail Pesanan</h5>
                <p class="text-sm text-slate-500">Pilih barang sesuai kemasan dan masukkan kuantitas yang dibutuhkan.</p>
            </div>
            <a href="{{ route('distributor.request.index') }}" class="text-sm font-semibold text-slate-500 hover:text-blue-600 transition-colors flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
        </div>

        <div class="p-6">
            <form action="{{ route('distributor.request.store') }}" method="POST">
                @csrf

                <div class="overflow-x-auto mb-6">
                    <table class="w-full text-sm text-left text-slate-600" id="itemTable">
                        <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-4 py-3 font-bold w-7/12">Pilih Produk & Kemasan</th>
                                <th class="px-4 py-3 font-bold w-3/12">Kuantitas (QTY)</th>
                                <th class="px-4 py-3 font-bold w-2/12 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            <tr class="border-b border-slate-100 item-row">
                                <td class="px-4 py-3">
                                    <select name="product_id[]" required class="bg-white border border-slate-300 text-slate-700 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none transition-all">
                                        <option value="" disabled selected>-- Pilih Varian Produk Pocari --</option>
                                        @foreach($produk as $p)
                                            <option value="{{ $p->id }}">
                                                {{ $p->nama_barang }} ({{ $p->ukuran }}) — Per {{ strtoupper($p->satuan) }} — Rp {{ number_format($p->harga, 0, ',', '.') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-4 py-3">
                                    <input type="number" name="qty_diminta[]" min="1" required class="bg-white border border-slate-300 text-slate-700 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none transition-all" placeholder="Contoh: 10">
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <button type="button" class="remove-row text-red-500 hover:text-red-700 font-bold p-2 bg-red-50 rounded-lg transition-colors opacity-50 cursor-not-allowed" disabled title="Baris pertama tidak bisa dihapus">
                                        <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-4 border-t border-slate-100">
                    <button type="button" id="addRow" class="inline-flex items-center px-4 py-2.5 text-sm font-bold text-slate-600 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors shadow-sm">
                        <svg class="w-4 h-4 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Baris Barang
                    </button>

                    <button type="submit" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-colors shadow-sm w-full sm:w-auto">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('addRow').addEventListener('click', function() {
            let tableBody = document.getElementById('tableBody');
            let firstRow = tableBody.querySelector('.item-row');
            let newRow = firstRow.cloneNode(true);

            // Reset input values
            newRow.querySelector('select').value = '';
            newRow.querySelector('input').value = '';

            // Aktifkan tombol hapus untuk baris baru
            let removeBtn = newRow.querySelector('.remove-row');
            removeBtn.disabled = false;
            removeBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            removeBtn.addEventListener('click', function() {
                newRow.remove();
            });

            tableBody.appendChild(newRow);
        });
    </script>
</x-app-layout>
