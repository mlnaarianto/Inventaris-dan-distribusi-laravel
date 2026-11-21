<x-app-layout>
    <x-slot name="title">Tambah Role</x-slot>
    <x-slot name="header">Tambah Role</x-slot>

    <div class="space-y-5 mb-6">

        {{-- Header Card --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-5 sm:p-6 flex items-start justify-between gap-4 transition-colors">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-500/15 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                    <i class="fas fa-plus-circle text-xl"></i>
                </div>
                <div>
                    <h5 class="text-lg font-bold text-slate-800 dark:text-white">Formulir Role Baru</h5>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                        Tentukan nama role. Permission dapat diatur setelah role disimpan.
                    </p>
                </div>
            </div>

            <a href="{{ route('roles.index') }}"
               class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors shrink-0">
                <i class="fas fa-arrow-left text-xs"></i>
                <span class="hidden sm:inline">Kembali</span>
            </a>
        </div>

        {{-- Form Card --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden transition-colors">
            <form method="POST" action="{{ route('roles.store') }}">
                @csrf

                <div class="p-5 sm:p-6 space-y-5">
                    <div>
                        <label for="name" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">
                            Nama Role <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                                <i class="fas fa-tag text-sm"></i>
                            </div>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                                placeholder="contoh: gudang-pusat"
                                class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 text-slate-800 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block w-full pl-10 p-2.5 outline-none transition-all" />
                        </div>
                        <p class="mt-1.5 text-xs text-slate-400 dark:text-slate-500">
                            Huruf kecil, angka, strip (-), dan garis bawah (_). Contoh: <span class="font-mono text-slate-500 dark:text-slate-400">gudang-pusat</span>
                        </p>
                        @error('name')
                            <p class="mt-1.5 text-xs font-semibold text-red-600 dark:text-red-400 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle text-[10px]"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                {{-- Footer --}}
                <div class="px-5 sm:px-6 py-4 bg-slate-50 dark:bg-slate-900/40 border-t border-slate-100 dark:border-slate-700 flex flex-col-reverse sm:flex-row sm:justify-end gap-2.5">
                    <a href="{{ route('roles.index') }}"
                       class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-bold text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-colors shadow-sm">
                        <i class="fas fa-save text-xs"></i>
                        Simpan Role
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>