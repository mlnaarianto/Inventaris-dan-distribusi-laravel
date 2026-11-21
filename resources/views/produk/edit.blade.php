<x-app-layout>
    <x-slot name="title">Edit Varian Produk</x-slot>
    <x-slot name="header">
        Edit Varian Produk
    </x-slot>

    <div class="space-y-5 mb-6">

        {{-- Header Card --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-5 sm:p-6 flex items-start justify-between gap-4 transition-colors">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-500/15 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                    <i class="fas fa-pen-to-square text-xl"></i>
                </div>
                <div>
                    <h5 class="text-lg font-bold text-slate-800 dark:text-white">Perbarui Informasi</h5>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                        Ubah spesifikasi, harga, maupun file lampiran foto untuk produk
                        <span class="font-bold text-blue-600 dark:text-blue-400">{{ $produk->nama_barang }}</span>.
                    </p>
                </div>
            </div>
            <a href="{{ route('produk.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors shrink-0">
                <i class="fas fa-arrow-left text-xs"></i>
                <span class="hidden sm:inline">Kembali</span>
            </a>
        </div>

        {{-- Form Card --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden transition-colors">
            <div class="p-5 sm:p-6">
                <form method="POST" action="{{ route('produk.update', $produk->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">

                        {{-- Section: Info Produk --}}
                        <div>
                            <h6 class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-3 flex items-center gap-2">
                                <i class="fas fa-info-circle"></i> Informasi Produk
                            </h6>
                            <div class="space-y-4">
                                <div>
                                    <label class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">Nama Produk / Barang <span class="text-red-500">*</span></label>
                                    <input type="text" name="nama_barang" value="{{ old('nama_barang', $produk->nama_barang) }}" required
                                        class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 text-slate-800 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block w-full p-2.5 outline-none transition-all" />
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">Ukuran / Varian <span class="text-red-500">*</span></label>
                                        <select name="ukuran" required class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 text-slate-800 dark:text-white text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block w-full p-2.5 outline-none transition-all">
                                            <option value="330ml" {{ old('ukuran', $produk->ukuran) == '330ml' ? 'selected' : '' }}>330ml</option>
                                            <option value="350ml" {{ old('ukuran', $produk->ukuran) == '350ml' ? 'selected' : '' }}>350ml</option>
                                            <option value="500ml" {{ old('ukuran', $produk->ukuran) == '500ml' ? 'selected' : '' }}>500ml</option>
                                            <option value="900ml" {{ old('ukuran', $produk->ukuran) == '900ml' ? 'selected' : '' }}>900ml</option>
                                            <option value="2 Liter" {{ old('ukuran', $produk->ukuran) == '2 Liter' ? 'selected' : '' }}>2 Liter</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">Kemasan (Satuan) <span class="text-red-500">*</span></label>
                                        <input type="text" name="satuan" value="{{ old('satuan', $produk->satuan) }}" required
                                            class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 text-slate-800 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block w-full p-2.5 outline-none transition-all" />
                                    </div>

                                    <div>
                                        <label class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">Harga Jual (Rp) <span class="text-red-500">*</span></label>
                                        <input type="number" name="harga" value="{{ old('harga', $produk->harga) }}" required
                                            class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 text-slate-800 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block w-full p-2.5 outline-none transition-all" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="border-slate-100 dark:border-slate-700">

                        {{-- Section: Stok & Media --}}
                        <div>
                            <h6 class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-3 flex items-center gap-2">
                                <i class="fas fa-warehouse"></i> Stok & Media
                            </h6>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">Stok Gudang Pusat <span class="text-red-500">*</span></label>
                                    <input type="number" name="stok_pusat" value="{{ old('stok_pusat', $produk->stok_pusat) }}" min="0" required
                                        class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 text-slate-800 dark:text-white text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block w-full p-2.5 outline-none transition-all" />
                                </div>

                                <div>
                                    <label class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">Ganti Foto Produk <span class="text-xs font-normal text-slate-400 dark:text-slate-500">(Kosongkan jika tetap)</span></label>
                                    <input type="file" name="gambar" id="imageInput" accept="image/*"
                                        class="block w-full text-sm text-slate-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-blue-50 dark:file:bg-blue-500/15 file:text-blue-700 dark:file:text-blue-400 hover:file:bg-blue-100 dark:hover:file:bg-blue-500/25 cursor-pointer border border-slate-300 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-900 p-1 transition-colors" />
                                </div>
                            </div>
                        </div>

                        {{-- Preview --}}
                        <div class="border border-dashed border-slate-200 dark:border-slate-600 rounded-xl p-4 flex flex-col items-center justify-center bg-slate-50 dark:bg-slate-900/50 transition-colors">
                            <p class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2" id="previewLabel">Gambar Aktif Saat Ini:</p>
                            @if($produk->gambar)
                                <img id="imagePreview" src="{{ asset('storage/' . $produk->gambar) }}" alt="Foto" class="max-h-40 rounded-lg shadow-sm object-contain">
                            @else
                                <div id="noImageText" class="text-sm font-semibold text-slate-400 dark:text-slate-500 py-4">Belum ada foto diunggah</div>
                                <img id="imagePreview" src="#" alt="Preview" class="hidden max-h-40 rounded-lg shadow-sm object-contain">
                            @endif
                        </div>

                    </div>

                    <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 pt-6 mt-6 border-t border-slate-100 dark:border-slate-700">
                        <a href="{{ route('produk.index') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-bold text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-700 rounded-xl hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-colors shadow-sm">
                            <i class="fas fa-save text-xs"></i>
                            Perbarui Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('imageInput').onchange = function (evt) {
            const [file] = this.files;
            if (file) {
                document.getElementById('previewLabel').innerText = "Pratinjau Gambar Baru:";
                let noImgText = document.getElementById('noImageText');
                if (noImgText) noImgText.remove();

                let previewImg = document.getElementById('imagePreview');
                previewImg.classList.remove('hidden');
                previewImg.src = URL.createObjectURL(file);
            }
        }
    </script>
</x-app-layout>