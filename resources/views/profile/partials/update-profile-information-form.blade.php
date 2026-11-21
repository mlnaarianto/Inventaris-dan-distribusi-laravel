@php
    $bisaEmail = auth()->user()->can('profile.update-email');
    $bisaUsername = auth()->user()->can('profile.update-username');
@endphp

<section>
    <header class="flex items-start gap-3">
        <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-500/15 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
            <i class="fas fa-user-pen text-base"></i>
        </div>
        <div class="min-w-0">
            <h2 class="text-lg font-bold text-slate-800 dark:text-white">Informasi Profil</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">
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
        </div>
    </header>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-5">
        @csrf
        @method('patch')

        {{-- ================= FOTO ================= --}}
        <div>
            <label class="block mb-1.5 text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Foto Profil</label>
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-5">
                <div class="relative w-20 h-20 shrink-0">
                    <img id="fotoPreview" src="{{ $user->foto_url }}" alt="Foto profil"
                         class="w-20 h-20 rounded-full object-cover border-2 border-slate-200 dark:border-slate-600 shadow-sm {{ $user->foto_url ? '' : 'hidden' }}">
                    <div id="fotoInisial"
                         class="w-20 h-20 rounded-full bg-blue-100 dark:bg-blue-500/15 text-blue-600 dark:text-blue-400 font-black text-2xl flex items-center justify-center border-2 border-blue-200 dark:border-blue-500/30 {{ $user->foto_url ? 'hidden' : '' }}">
                        {{ $user->inisial }}
                    </div>
                </div>

                <div class="space-y-2 min-w-0 flex-1">
                    <input type="file" id="foto" name="foto" accept="image/png,image/jpeg,image/webp"
                           class="block w-full text-sm text-slate-500 dark:text-slate-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 dark:file:bg-blue-500/15 file:text-blue-700 dark:file:text-blue-400 hover:file:bg-blue-100 dark:hover:file:bg-blue-500/25 cursor-pointer border border-slate-300 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-900 p-1 transition-colors" />
                    <p class="text-xs text-slate-400 dark:text-slate-500">JPG, PNG, atau WEBP. Maksimal 2 MB. Foto lama otomatis diganti.</p>

                    @if ($user->foto)
                        <label class="inline-flex items-center gap-2 text-xs font-semibold text-red-600 dark:text-red-400 cursor-pointer hover:text-red-700 dark:hover:text-red-300 transition-colors">
                            <input type="checkbox" name="hapus_foto" id="hapusFoto" value="1" class="w-4 h-4 rounded border-slate-300 dark:border-slate-600 text-red-600 focus:ring-red-500 dark:bg-slate-900">
                            Hapus foto saat ini
                        </label>
                    @endif
                </div>
            </div>
            @error('foto')
                <p class="mt-2 text-xs font-semibold text-red-600 dark:text-red-400 flex items-center gap-1">
                    <i class="fas fa-exclamation-circle text-[10px]"></i> {{ $message }}
                </p>
            @enderror
        </div>

        <hr class="border-slate-100 dark:border-slate-700">

        {{-- ================= USERNAME & ROLE ================= --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="username" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">Username</label>
                @if ($bisaUsername)
                    <input id="username" name="username" type="text" value="{{ old('username', $user->username) }}" required autocomplete="username"
                        class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 text-slate-800 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block w-full p-2.5 outline-none transition-all" />
                    @error('username')
                        <p class="mt-1.5 text-xs font-semibold text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">Huruf kecil, angka, strip (-), dan garis bawah (_). Dipakai untuk login.</p>
                @else
                    <input id="username" type="text" value="{{ $user->username }}" readonly disabled
                        class="bg-slate-100 dark:bg-slate-900/50 border border-slate-300 dark:border-slate-700 text-slate-500 dark:text-slate-500 text-sm rounded-xl block w-full p-2.5 cursor-not-allowed outline-none" />
                    <p class="mt-1 text-xs text-slate-400 dark:text-slate-500 flex items-center gap-1">
                        <i class="fas fa-lock text-[9px]"></i> Diatur oleh administrator.
                    </p>
                @endif
            </div>

            <div>
                <label for="role" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">Peran</label>
                <input id="role" type="text" value="{{ ucwords(str_replace('-', ' ', $user->getRoleNames()->first() ?? '-')) }}" readonly disabled
                    class="bg-slate-100 dark:bg-slate-900/50 border border-slate-300 dark:border-slate-700 text-slate-500 dark:text-slate-500 text-sm rounded-xl block w-full p-2.5 cursor-not-allowed outline-none" />
                <p class="mt-1 text-xs text-slate-400 dark:text-slate-500 flex items-center gap-1">
                    <i class="fas fa-lock text-[9px]"></i> Diatur oleh administrator.
                </p>
            </div>
        </div>

        <hr class="border-slate-100 dark:border-slate-700">

        {{-- ================= NAMA ================= --}}
        <div>
            <label for="name" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">
                Nama Lengkap <span class="text-red-500">*</span>
            </label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autocomplete="name"
                class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 text-slate-800 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block w-full p-2.5 outline-none transition-all" />
            @error('name')
                <p class="mt-1.5 text-xs font-semibold text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- ================= EMAIL ================= --}}
        <div>
            <label for="email" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">Email</label>
            @if ($bisaEmail)
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="email"
                    class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 text-slate-800 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block w-full p-2.5 outline-none transition-all" />
                @error('email')
                    <p class="mt-1.5 text-xs font-semibold text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            @else
                <input id="email" type="email" value="{{ $user->email }}" readonly disabled
                    class="bg-slate-100 dark:bg-slate-900/50 border border-slate-300 dark:border-slate-700 text-slate-500 dark:text-slate-500 text-sm rounded-xl block w-full p-2.5 cursor-not-allowed outline-none" />
                <p class="mt-1 text-xs text-slate-400 dark:text-slate-500 flex items-center gap-1">
                    <i class="fas fa-lock text-[9px]"></i> Diatur oleh administrator.
                </p>
            @endif
        </div>

        {{-- ================= SUBMIT ================= --}}
        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="inline-flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-colors shadow-sm">
                <i class="fas fa-save text-xs"></i>
                Simpan
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-emerald-600 dark:text-emerald-400 font-semibold flex items-center gap-1">
                    <i class="fas fa-check-circle"></i>
                    Tersimpan.
                </p>
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