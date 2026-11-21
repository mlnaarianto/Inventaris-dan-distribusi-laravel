<section>
    <header>
        <h2 class="text-lg font-bold text-slate-800">Informasi Profil</h2>
        <p class="mt-1 text-sm text-slate-500">
            @php
                $bisaEmail = auth()->user()->can('profile.update-email');
                $bisaUsername = auth()->user()->can('profile.update-username');
            @endphp

            @if ($bisaEmail && $bisaUsername)
                Perbarui foto, nama, username, dan email akun Anda. Peran diatur oleh administrator.
            @elseif ($bisaEmail)
                Perbarui foto, nama, dan email akun Anda. Username dan peran diatur oleh administrator.
            @elseif ($bisaUsername)
                Perbarui foto, nama, dan username akun Anda. Email dan peran diatur oleh administrator.
            @else
                Perbarui foto dan nama akun Anda. Username, email, dan peran diatur oleh administrator.
            @endif
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- Foto profil --}}
        <div>
            <x-input-label for="foto" value="Foto Profil" />
            <div class="mt-2 flex items-center gap-5">
                <div class="relative w-20 h-20 shrink-0">
                    <img id="fotoPreview" src="{{ $user->foto_url }}" alt="Foto profil"
                         class="w-20 h-20 rounded-full object-cover border border-slate-200 shadow-sm {{ $user->foto_url ? '' : 'hidden' }}">
                    <div id="fotoInisial"
                         class="w-20 h-20 rounded-full bg-blue-100 text-blue-600 font-bold text-2xl flex items-center justify-center border border-blue-200 {{ $user->foto_url ? 'hidden' : '' }}">
                        {{ $user->inisial }}
                    </div>
                </div>

                <div class="space-y-2">
                    <input type="file" id="foto" name="foto" accept="image/png,image/jpeg,image/webp"
                           class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                    <p class="text-xs text-slate-400">JPG, PNG, atau WEBP. Maksimal 2 MB. Foto lama otomatis diganti.</p>

                    @if ($user->foto)
                        <label class="inline-flex items-center gap-2 text-sm text-red-600 cursor-pointer">
                            <input type="checkbox" name="hapus_foto" id="hapusFoto" value="1" class="rounded border-slate-300 text-red-600 focus:ring-red-500">
                            Hapus foto saat ini
                        </label>
                    @endif
                </div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('foto')" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            {{-- Username: bisa diubah jika punya permission profile.update-username --}}
            <div>
                <x-input-label for="username" value="Username" />
                @if ($bisaUsername)
                    <x-text-input id="username" name="username" type="text" class="mt-1 block w-full"
                                  :value="old('username', $user->username)" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('username')" />
                    <p class="mt-1 text-xs text-slate-400">Huruf kecil, angka, strip (-), dan garis bawah (_). Dipakai untuk login.</p>
                @else
                    <x-text-input id="username" type="text" class="mt-1 block w-full bg-slate-100 text-slate-500 cursor-not-allowed"
                                  :value="$user->username" readonly disabled />
                    <p class="mt-1 text-xs text-slate-400">Diatur oleh administrator.</p>
                @endif
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
                          :value="old('name', $user->name)" required autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Email: hanya bisa diubah jika punya permission profile.update-email --}}
        <div>
            <x-input-label for="email" value="Email" />
            @if ($bisaEmail)
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                              :value="old('email', $user->email)" required autocomplete="email" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            @else
                <x-text-input id="email" type="email" class="mt-1 block w-full bg-slate-100 text-slate-500 cursor-not-allowed"
                              :value="$user->email" readonly disabled />
                <p class="mt-1 text-xs text-slate-400">Diatur oleh administrator.</p>
            @endif
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

    <script>
        (function () {
            var input = document.getElementById('foto');
            var preview = document.getElementById('fotoPreview');
            var inisial = document.getElementById('fotoInisial');
            var hapus = document.getElementById('hapusFoto');

            input.addEventListener('change', function () {
                var file = input.files[0];
                if (!file) return;
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
                inisial.classList.add('hidden');
                if (hapus) hapus.checked = false; // pilih foto baru = batal hapus
            });
        })();
    </script>
</section>