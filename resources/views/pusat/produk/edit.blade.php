<x-app-layout>
    <x-slot name="header">
        Edit Varian Produk
    </x-slot>

    <div class="flex flex-wrap justify-center mb-6">
        <div class="w-full max-w-3xl bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <div>
                    <h5 class="text-lg font-bold text-slate-800">Perbarui Informasi</h5>
                    <p class="text-sm text-slate-500">Ubah spesifikasi, harga, maupun file lampiran foto untuk produk <span class="font-bold text-blue-600">{{ $produk->nama_barang }}</span>.</p>
                </div>
                <a href="{{ route('pusat.produk.index') }}" class="text-sm font-semibold text-slate-500 hover:text-blue-600 transition-colors flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
            </div>

            <div class="p-6">
                <form method="POST" action="{{ route('pusat.produk.update', $produk->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="space-y-5">
                        <div>
                            <label class="block mb-2 text-sm font-bold text-slate-700">Nama Produk / Barang</label>
                            <input type="text" name="nama_barang" value="{{ old('nama_barang', $produk->nama_barang) }}" required
                                   class="bg-white border border-slate-300 text-slate-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none transition-all" />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                            <div>
                                <label class="block mb-2 text-sm font-bold text-slate-700">Ukuran / Varian</label>
                                <select name="ukuran" required class="bg-white border border-slate-300 text-slate-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none transition-all">
                                    <option value="330ml" {{ old('ukuran', $produk->ukuran) == '330ml' ? 'selected' : '' }}>330ml</option>
                                    <option value="350ml" {{ old('ukuran', $produk->ukuran) == '350ml' ? 'selected' : '' }}>350ml</option>
                                    <option value="500ml" {{ old('ukuran', $produk->ukuran) == '500ml' ? 'selected' : '' }}>500ml</option>
                                    <option value="900ml" {{ old('ukuran', $produk->ukuran) == '900ml' ? 'selected' : '' }}>900ml</option>
                                    <option value="2 Liter" {{ old('ukuran', $produk->ukuran) == '2 Liter' ? 'selected' : '' }}>2 Liter</option>
                                </select>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-bold text-slate-700">Jenis Kemasan (Satuan)</label>
                                <input type="text" name="satuan" value="{{ old('satuan', $produk->satuan) }}" required
                                       class="bg-white border border-slate-300 text-slate-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none transition-all" />
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-bold text-slate-700">Harga Jual (Rp)</label>
                                <input type="number" name="harga" value="{{ old('harga', $produk->harga) }}" required
                                       class="bg-white border border-slate-300 text-slate-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none transition-all" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block mb-2 text-sm font-bold text-slate-700">Kuantitas Stok Gudang Pusat</label>
                                <input type="number" name="stok_pusat" value="{{ old('stok_pusat', $produk->stok_pusat) }}" min="0" required
                                       class="bg-white border border-slate-300 text-slate-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none transition-all" />
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-bold text-slate-700">Ganti Foto Produk <span class="text-xs font-normal text-slate-400">(Kosongkan jika tetap)</span></label>
                                <input type="file" name="gambar" id="imageInput" accept="image/*"
                                       class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer border border-slate-300 rounded-xl bg-white p-1" />
                            </div>
                        </div>

                        <div class="border border-dashed border-slate-200 rounded-xl p-4 flex flex-col items-center justify-center bg-slate-50">
                            <p class="text-xs font-bold text-slate-400 uppercase mb-2" id="previewLabel">Gambar Aktif Saat Ini:</p>
                            @if($produk->gambar)
                                <img id="imagePreview" src="{{ asset('storage/' . $produk->gambar) }}" alt="Foto" class="max-h-40 rounded-lg shadow-sm object-contain">
                            @else
                                <div id="noImageText" class="text-sm font-semibold text-slate-400 py-4">Belum ada foto diunggah</div>
                                <img id="imagePreview" src="#" alt="Preview" class="hidden max-h-40 rounded-lg shadow-sm object-contain">
                            @endif
                        </div>
                    </div>

                    <div class="flex justify-end pt-6 mt-6 border-t border-slate-100">
                        <button type="submit" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-colors shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121 12h-4.5"></path></svg>
                            Perbarui Data Varian
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
                if(noImgText) noImgText.remove();

                let previewImg = document.getElementById('imagePreview');
                previewImg.classList.remove('hidden');
                previewImg.src = URL.createObjectURL(file);
            }
        }
    </script>
</x-app-layout>
