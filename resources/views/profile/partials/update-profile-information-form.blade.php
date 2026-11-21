<section>
    <header>
        <h2 class="text-lg font-bold text-slate-800">Informasi Profil</h2>
        <p class="mt-1 text-sm text-slate-500">
            Perbarui nama dan email akun Anda. Username dan peran diatur oleh administrator.
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            {{-- Read-only: diatur admin --}}
            <div>
                <x-input-label for="username" value="Username" />
                <x-text-input id="username" type="text" class="mt-1 block w-full bg-slate-100 text-slate-500 cursor-not-allowed"
                              :value="$user->username" readonly disabled />
                <p class="mt-1 text-xs text-slate-400">Tidak dapat diubah sendiri.</p>
            </div>

            <div>
                <x-input-label for="role" value="Peran" />
                <x-text-input id="role" type="text" class="mt-1 block w-full bg-slate-100 text-slate-500 cursor-not-allowed"
                              :value="ucwords(str_replace('-', ' ', $user->getRoleNames()->first() ?? '-'))" readonly disabled />
                <p class="mt-1 text-xs text-slate-400">Diatur oleh administrator.</p>
            </div>
        </div>

        <div>
            <x-input-label for="name" value="Nama Lengkap" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                          :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                          :value="old('email', $user->email)" required autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>Simpan</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-emerald-600 font-semibold">Tersimpan.</p>
            @endif
        </div>
    </form>
</section>