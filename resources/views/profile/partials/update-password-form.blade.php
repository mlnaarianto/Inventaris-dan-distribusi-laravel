<section>
    <header>
        <h2 class="text-lg font-bold text-slate-800">Ubah Kata Sandi</h2>
        <p class="mt-1 text-sm text-slate-500">
            Gunakan kata sandi yang panjang dan acak (minimal 8 karakter) agar akun Anda tetap aman.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
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
                <x-input-label :for="$f['id']" :value="$f['label']" />
                <div class="relative mt-1">
                    <x-text-input :id="$f['id']" :name="$f['name']" type="password" class="block w-full pr-12" :autocomplete="$f['auto']" />
                    <button type="button" data-toggle-password="{{ $f['id'] }}" aria-label="Tampilkan atau sembunyikan kata sandi"
                            class="absolute inset-y-0 right-0 px-3 flex items-center text-slate-400 hover:text-blue-600 transition-colors">
                        <svg data-eye class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg data-eye-off class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->updatePassword->get($f['name'])" class="mt-2" />
            </div>
        @endforeach

        <div class="flex items-center gap-4">
            <x-primary-button>Simpan</x-primary-button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-emerald-600 font-semibold">Kata sandi berhasil diperbarui.</p>
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