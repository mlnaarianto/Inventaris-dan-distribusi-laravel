<section>
    <header class="flex items-start gap-3">
        <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-500/15 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
            <i class="fas fa-lock text-base"></i>
        </div>
        <div class="min-w-0">
            <h2 class="text-lg font-bold text-slate-800 dark:text-white">Ubah Kata Sandi</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">
                Gunakan kata sandi yang panjang dan acak (minimal 8 karakter) agar akun Anda tetap aman.
            </p>
        </div>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('put')

        @php
            $fields = [
                ['id' => 'update_password_current_password', 'name' => 'current_password', 'label' => 'Kata Sandi Saat Ini', 'auto' => 'current-password'],
                ['id' => 'update_password_password', 'name' => 'password', 'label' => 'Kata Sandi Baru', 'auto' => 'new-password'],
                ['id' => 'update_password_password_confirmation', 'name' => 'password_confirmation', 'label' => 'Ulangi Kata Sandi Baru', 'auto' => 'new-password'],
            ];
        @endphp

        @foreach ($fields as $f)
            <div>
                <label for="{{ $f['id'] }}" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">
                    {{ $f['label'] }} <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input id="{{ $f['id'] }}" name="{{ $f['name'] }}" type="password" autocomplete="{{ $f['auto'] }}" required
                        class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 text-slate-800 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block w-full p-2.5 pr-12 outline-none transition-all" />
                    <button type="button" data-toggle-password="{{ $f['id'] }}" aria-label="Tampilkan atau sembunyikan kata sandi"
                            class="absolute inset-y-0 right-0 px-3 flex items-center text-slate-400 dark:text-slate-500 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                        <svg data-eye class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg data-eye-off class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                    </button>
                </div>
                @if ($errors->updatePassword->has($f['name']))
                    <p class="mt-1.5 text-xs font-semibold text-red-600 dark:text-red-400 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle text-[10px]"></i>
                        {{ $errors->updatePassword->first($f['name']) }}
                    </p>
                @endif
            </div>
        @endforeach

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="inline-flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-amber-600 rounded-xl hover:bg-amber-700 transition-colors shadow-sm">
                <i class="fas fa-key text-xs"></i>
                Perbarui Kata Sandi
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-emerald-600 dark:text-emerald-400 font-semibold flex items-center gap-1">
                    <i class="fas fa-check-circle"></i>
                    Kata sandi berhasil diperbarui.
                </p>
            @endif
        </div>
    </form>

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
</section>