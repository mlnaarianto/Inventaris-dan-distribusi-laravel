<x-app-layout>
    <x-slot name="title">Edit Akun</x-slot>
    <x-slot name="header">Ubah Akun</x-slot>

    <div class="space-y-5 mb-6">

        @if (session('error'))
            <div class="flex items-start gap-2 rounded-xl bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/30 text-red-700 dark:text-red-400 text-sm font-semibold px-4 py-3">
                <i class="fas fa-exclamation-circle mt-0.5"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-5 sm:p-6 flex items-start justify-between gap-4 transition-colors">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-50 dark:bg-amber-500/15 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
                    <i class="fas fa-user-pen text-xl"></i>
                </div>
                <div>
                    <h5 class="text-lg font-bold text-slate-800 dark:text-white">Ubah Data Akun</h5>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                        Perbarui profil, role, atau foto untuk <span class="font-bold text-blue-600 dark:text-blue-400">{{ $user->name }}</span>.
                    </p>
                </div>
            </div>

            <a href="{{ route('users.index') }}"
               class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors shrink-0">
                <i class="fas fa-arrow-left text-xs"></i>
                <span class="hidden sm:inline">Kembali</span>
            </a>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden transition-colors">
            <form method="POST" action="{{ route('users.update', $user) }}">
                @csrf @method('PUT')

                <div class="p-5 sm:p-6">
                    @include('users._form')
                </div>

                <div class="px-5 sm:px-6 py-4 bg-slate-50 dark:bg-slate-900/40 border-t border-slate-100 dark:border-slate-700 flex flex-col-reverse sm:flex-row sm:justify-end gap-2.5">
                    <a href="{{ route('users.index') }}"
                       class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-bold text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-colors shadow-sm">
                        <i class="fas fa-save text-xs"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>