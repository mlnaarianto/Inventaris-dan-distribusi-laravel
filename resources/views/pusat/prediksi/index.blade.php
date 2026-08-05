<x-app-layout>
    <x-slot name="header">
        Prediksi Mutasi Stok Barang (AI)
    </x-slot>

    <!-- Style tambahan agar konsisten -->
    <style>
        .form-input-custom {
            background-color: #ffffff !important;
            color: #334155 !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 0.5rem !important;
            padding: 8px 12px !important;
            outline: none !important;
            width: 100% !important;
        }
        .form-input-custom:focus {
            border-color: #2563eb !important;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2) !important;
        }
    </style>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-6">

        <!-- Header Card -->
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50/50">
            <div>
                <h5 class="text-lg font-bold text-slate-800">Kalkulator Prediksi Permintaan Stok</h5>
                <p class="text-sm text-slate-500">Gunakan model kecerdasan buatan (Machine Learning) untuk memperkirakan jumlah kuantiti keluar berdasarkan ID produk dan waktu.</p>
            </div>
        </div>

        <!-- Body Form -->
        <div class="p-6">
            <form action="{{ route('pusat.prediksi.predict') }}" method="POST" class="max-w-xl">
                @csrf
                
                <div class="mb-5">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Product ID:</label>
                    <input type="number" name="product_id" value="{{ old('product_id') }}" class="form-input-custom" placeholder="Contoh: 1, 2, 3..." required>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Bulan (Angka 1 - 12):</label>
                    <input type="number" name="bulan" min="1" max="12" value="{{ old('bulan') }}" class="form-input-custom" placeholder="Contoh: 6 untuk bulan Juni" required>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Hari dalam Minggu (0 = Senin, 6 = Minggu):</label>
                    <input type="number" name="hari_dalam_minggu" min="0" max="6" value="{{ old('hari_dalam_minggu') }}" class="form-input-custom" placeholder="Contoh: 0 s.d 6" required>
                </div>

                <button type="submit" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-colors shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012-2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Proses Prediksi Sekarang
                </button>
            </form>

            {{-- Hasil Prediksi --}}
            @isset($prediction)
                <div class="mt-8 p-6 bg-blue-50/50 border border-blue-200 rounded-2xl max-w-xl">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-600 text-white font-bold flex items-center justify-center text-lg shrink-0 shadow-sm">
                            AI
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-base">Hasil Estimasi Prediksi Kuantiti Keluar:</h3>
                            <p class="text-2xl font-extrabold text-blue-600 mt-1">
                                {{ number_format($prediction, 2) }} <span class="text-sm font-medium text-slate-500">Unit</span>
                            </p>
                        </div>
                    </div>
                </div>
            @endisset

            {{-- Pesan Error --}}
            @if(session('error'))
                <div class="mt-8 p-6 bg-red-50 border border-red-200 rounded-2xl max-w-xl text-red-700">
                    <div class="font-bold">Terjadi Kesalahan:</div>
                    <div class="text-sm mt-1">{{ session('error') }}</div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>