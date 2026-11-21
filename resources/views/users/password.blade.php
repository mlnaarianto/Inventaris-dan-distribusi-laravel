<x-app-layout>
    <x-slot name="title">Reset Password</x-slot>
    <x-slot name="header">Reset Password</x-slot>

    <div class="space-y-5 mb-6">

        {{-- ================= HEADER CARD ================= --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-5 sm:p-6 flex items-start justify-between gap-4 transition-colors">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-50 dark:bg-amber-500/15 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
                    <i class="fas fa-key text-xl"></i>
                </div>
                <div>
                    <h5 class="text-lg font-bold text-slate-800 dark:text-white">Reset Password Akun</h5>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                        Atur ulang password untuk
                        <span class="font-bold text-slate-700 dark:text-slate-200">{{ $user->name }}</span>
                        <span class="font-mono text-xs text-slate-400 dark:text-slate-500">({{ $user->username }})</span>.
                    </p>
                </div>
            </div>

            <a href="{{ route('users.index') }}"
               class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors shrink-0">
                <i class="fas fa-arrow-left text-xs"></i>
                <span class="hidden sm:inline">Kembali</span>
            </a>
        </div>

        {{-- ================= INFO BANNER ================= --}}
        <div class="flex items-start gap-3 p-3.5 rounded-xl bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/30">
            <div class="w-8 h-8 rounded-lg bg-amber-100 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
                <i class="fas fa-shield-halved text-sm"></i>
            </div>
            <p class="text-xs sm:text-sm text-amber-800 dark:text-amber-300 leading-relaxed">
                Sampaikan password baru ini <span class="font-bold">langsung kepada pemilik akun</span>. Jangan bagikan melalui saluran publik.
            </p>
        </div>

        {{-- ================= FORM CARD ================= --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden transition-colors">
            <form method="POST" action="{{ route('users.password.update', $user) }}">
                @csrf @method('PUT')

                <div class="p-5 sm:p-6 space-y-4">

                    {{-- Password Baru --}}
                    <div>
                        <label for="password" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">
                            Password Baru <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                                <i class="fas fa-key text-sm"></i>
                            </div>
                            <input id="password" name="password" type="password" required autofocus autocomplete="new-password"
                                class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 text-slate-800 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block w-full pl-10 pr-10 p-2.5 outline-none transition-all" />
                            <button type="button" data-toggle-password="password" aria-label="Tampilkan atau sembunyikan kata sandi"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 dark:text-slate-500 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                <i class="fas fa-eye text-sm" data-eye></i>
                                <i class="fas fa-eye-slash text-sm hidden" data-eye-off></i>
                            </button>
                        </div>
                        <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">Minimal 8 karakter.</p>
                        @error('password')
                            <p class="mt-1.5 text-xs font-semibold text-red-600 dark:text-red-400 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle text-[10px]"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div>
                        <label for="password_confirmation" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">
                            Ulangi Password Baru <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                                <i class="fas fa-key text-sm"></i>
                            </div>
                            <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                                class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 text-slate-800 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block w-full pl-10 p-2.5 outline-none transition-all" />
                        </div>
                    </div>

                </div>

                {{-- Footer --}}
                <div class="px-5 sm:px-6 py-4 bg-slate-50 dark:bg-slate-900/40 border-t border-slate-100 dark:border-slate-700 flex flex-col-reverse sm:flex-row sm:justify-end gap-2.5">
                    <a href="{{ route('users.index') }}"
                       class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-bold text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-amber-600 rounded-xl hover:bg-amber-700 transition-colors shadow-sm">
                        <i class="fas fa-key text-xs"></i>
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll('[data-toggle-password]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var input = document.getElementById(btn.dataset.togglePassword);
                var tampil = input.type === 'password';
                input.type = tampil ? 'text' : 'password';
                btn.querySelector('[data-eye]').classList.toggle('hidden', tampil);
                btn.querySelector('[data-eye-off]').classList.toggle('hidden', !tampil);
            });
        });
    </script>
</x-app-layout>