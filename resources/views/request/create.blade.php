<x-app-layout>
    <x-slot name="title">Ajukan Permintaan Baru</x-slot>
    <x-slot name="header">Form Pengajuan Barang Baru</x-slot>

    <div class="space-y-5 mb-6">

        {{-- ================= HEADER CARD ================= --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-5 sm:p-6 flex items-start justify-between gap-4 transition-colors">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-500/15 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                    <i class="fas fa-cart-plus text-xl"></i>
                </div>
                <div>
                    <h5 class="text-lg font-bold text-slate-800 dark:text-white">Detail Pesanan</h5>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                        Pilih barang sesuai kemasan dan masukkan kuantitas yang dibutuhkan.
                    </p>
                </div>
            </div>

            <a href="{{ route('request.index') }}"
               class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors shrink-0">
                <i class="fas fa-arrow-left text-xs"></i>
                <span class="hidden sm:inline">Kembali</span>
            </a>
        </div>

        {{-- ================= FORM CARD ================= --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden transition-colors">
            <form action="{{ route('request.store') }}" method="POST">
                @csrf

                <div class="p-5 sm:p-6">

                    {{-- Info banner --}}
                    <div class="mb-5 flex items-start gap-3 p-3.5 rounded-xl bg-blue-50 dark:bg-blue-500/10 border border-blue-100 dark:border-blue-500/20">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                            <i class="fas fa-info-circle text-sm"></i>
                        </div>
                        <p class="text-xs sm:text-sm text-blue-800 dark:text-blue-300 leading-relaxed">
                            Tambahkan satu atau lebih baris produk. Sistem akan memvalidasi ketersediaan stok pusat saat pengajuan dikirim.
                        </p>
                    </div>

                    {{-- ================= TABEL ITEM ================= --}}
                    <div class="overflow-x-auto -mx-1 px-1">
                        <table class="w-full text-sm text-left text-slate-600 dark:text-slate-300" id="itemTable">
                            <thead class="text-[11px] text-slate-500 dark:text-slate-400 uppercase bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700">
                                <tr>
                                    <th class="px-3 sm:px-4 py-3 font-bold w-7/12">Pilih Produk & Kemasan</th>
                                    <th class="px-3 sm:px-4 py-3 font-bold w-3/12">Kuantitas (QTY)</th>
                                    <th class="px-3 sm:px-4 py-3 font-bold w-2/12 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody" class="divide-y divide-slate-100 dark:divide-slate-700">
                                <tr class="item-row">
                                    <td class="px-3 sm:px-4 py-3">
                                        <select name="product_id[]" required
                                            class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-white text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block w-full p-2.5 outline-none transition-all">
                                            <option value="" disabled selected>-- Pilih Varian Produk Pocari --</option>
                                            @foreach($produk as $p)
                                                <option value="{{ $p->id }}">
                                                    {{ $p->nama_barang }} ({{ $p->ukuran }}) — Per {{ strtoupper($p->satuan) }} — Rp {{ number_format($p->harga, 0, ',', '.') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-3 sm:px-4 py-3">
                                        <div class="relative">
                                            <input type="number" name="qty_diminta[]" min="1" required placeholder="0"
                                                class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block w-full p-2.5 pr-12 outline-none transition-all" />
                                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider pointer-events-none">Qty</span>
                                        </div>
                                    </td>
                                    <td class="px-3 sm:px-4 py-3 text-center">
                                        <button type="button"
                                            class="remove-row inline-flex items-center justify-center w-9 h-9 text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 bg-red-50 dark:bg-red-500/10 hover:bg-red-100 dark:hover:bg-red-500/20 rounded-lg transition-colors opacity-50 cursor-not-allowed"
                                            disabled title="Baris pertama tidak bisa dihapus" aria-label="Hapus baris">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Tombol tambah baris --}}
                    <div class="mt-4">
                        <button type="button" id="addRow"
                            class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-bold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-500/10 border border-blue-200 dark:border-blue-500/30 rounded-xl hover:bg-blue-100 dark:hover:bg-blue-500/20 transition-colors">
                            <i class="fas fa-plus text-xs"></i>
                            Tambah Baris Barang
                        </button>
                    </div>
                </div>

                {{-- ================= FOOTER ACTION ================= --}}
                <div class="px-5 sm:px-6 py-4 bg-slate-50 dark:bg-slate-900/40 border-t border-slate-100 dark:border-slate-700 flex flex-col sm:flex-row sm:justify-between items-stretch sm:items-center gap-3">

                    {{-- Live counter --}}
                    <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 order-2 sm:order-1 justify-center sm:justify-start">
                        <div class="w-8 h-8 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center">
                            <i class="fas fa-list-check text-blue-500 dark:text-blue-400 text-xs"></i>
                        </div>
                        <span>
                            <span id="totalItems" class="font-extrabold text-slate-800 dark:text-white">0</span>
                            <span class="text-xs">baris produk dipilih</span>
                        </span>
                    </div>

                    {{-- Action buttons --}}
                    <div class="flex flex-col-reverse sm:flex-row gap-2.5 order-1 sm:order-2">
                        <a href="{{ route('request.index') }}"
                           class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-bold text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                            Batal
                        </a>
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-colors shadow-sm">
                            <i class="fas fa-paper-plane text-xs"></i>
                            Kirim Pengajuan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // ============ TAMBAH BARIS ============
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
                updateTotal(); // update setelah hapus
            });

            tableBody.appendChild(newRow);
            updateTotal(); // update setelah tambah
        });

        // ============ LIVE COUNTER ============
        (function () {
            const tableBody = document.getElementById('tableBody');
            const totalEl   = document.getElementById('totalItems');

            function updateTotal() {
                const selects = tableBody.querySelectorAll('select[name="product_id[]"]');
                let filled = 0;
                selects.forEach(s => { if (s.value !== '') filled++; });
                totalEl.textContent = filled;
            }

            // Update saat select berubah
            tableBody.addEventListener('change', function (e) {
                if (e.target.matches('select[name="product_id[]"]')) updateTotal();
            });

            // Hitung awal (saat page load)
            updateTotal();
        })();
    </script>
</x-app-layout>