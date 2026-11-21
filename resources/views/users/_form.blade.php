@php
    $editing = isset($user);
    $isSelf = $isSelf ?? false;
@endphp

<div class="space-y-6">

    {{-- ================= DATA UTAMA ================= --}}
    <div>
        <h6 class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-3 flex items-center gap-2">
            <i class="fas fa-id-card"></i> Data Akun
        </h6>

        <div class="space-y-4">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- Nama --}}
                <div>
                    <label for="name" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                            <i class="fas fa-user text-sm"></i>
                        </div>
                        <input id="name" name="name" type="text" value="{{ old('name', $user->name ?? '') }}" required autofocus
                            class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 text-slate-800 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block w-full pl-10 p-2.5 outline-none transition-all" />
                    </div>
                    @error('name')
                        <p class="mt-1.5 text-xs font-semibold text-red-600 dark:text-red-400 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle text-[10px]"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Username --}}
                <div>
                    <label for="username" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">
                        Username <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                            <i class="fas fa-at text-sm"></i>
                        </div>
                        <input id="username" name="username" type="text" value="{{ old('username', $user->username ?? '') }}" required autocomplete="off"
                            class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 text-slate-800 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block w-full pl-10 p-2.5 outline-none transition-all" />
                    </div>
                    <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">Huruf kecil, angka, strip (-), dan garis bawah (_). Dipakai untuk login.</p>
                    @error('username')
                        <p class="mt-1.5 text-xs font-semibold text-red-600 dark:text-red-400 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle text-[10px]"></i> {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">
                    Email <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                        <i class="fas fa-envelope text-sm"></i>
                    </div>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email ?? '') }}" required autocomplete="off"
                        class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 text-slate-800 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block w-full pl-10 p-2.5 outline-none transition-all" />
                </div>
                @error('email')
                    <p class="mt-1.5 text-xs font-semibold text-red-600 dark:text-red-400 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle text-[10px]"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Role --}}
            <div>
                <label for="role" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">
                    Role <span class="text-red-500">*</span>
                </label>

                @if ($isSelf)
                    {{-- Readonly: user tidak boleh ubah role sendiri --}}
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                            <i class="fas fa-shield-halved text-sm"></i>
                        </div>
                        <input type="text" value="{{ Str::headline($userRole ?? '-') }}" readonly disabled
                            class="bg-slate-100 dark:bg-slate-900/50 border border-slate-300 dark:border-slate-700 text-slate-500 dark:text-slate-500 text-sm rounded-xl block w-full pl-10 p-2.5 cursor-not-allowed outline-none" />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                            <i class="fas fa-lock text-xs"></i>
                        </div>
                    </div>
                    <p class="mt-1 text-xs text-slate-400 dark:text-slate-500 flex items-center gap-1">
                        <i class="fas fa-lock text-[9px]"></i> Anda tidak dapat mengubah role akun sendiri.
                    </p>
                @else
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                            <i class="fas fa-shield-halved text-sm"></i>
                        </div>
                        <select id="role" name="role" required
                            class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 text-slate-800 dark:text-white text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block w-full pl-10 pr-10 p-2.5 outline-none transition-all appearance-none cursor-pointer">
                            <option value="" disabled @selected(! old('role', $userRole ?? null))>-- Pilih Role --</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" @selected(old('role', $userRole ?? null) === $role->name)>
                                    {{ Str::headline($role->name) }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                    @error('role')
                        <p class="mt-1.5 text-xs font-semibold text-red-600 dark:text-red-400 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle text-[10px]"></i> {{ $message }}
                        </p>
                    @enderror
                @endif
            </div>

        </div>
    </div>

    {{-- ================= PASSWORD (khusus create) ================= --}}
    @unless ($editing)
        <hr class="border-slate-100 dark:border-slate-700">

        <div>
            <h6 class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-3 flex items-center gap-2">
                <i class="fas fa-lock"></i> Keamanan Akun
            </h6>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- Password --}}
                <div>
                    <label for="password" class="block mb-1.5 text-sm font-bold text-slate-700 dark:text-slate-300">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                            <i class="fas fa-key text-sm"></i>
                        </div>
                        <input id="password" name="password" type="password" required autocomplete="new-password"
                            class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 text-slate-800 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block w-full pl-10 pr-10 p-2.5 outline-none transition-all" />
                        <button type="button" data-toggle-password="password"
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
                        Ulangi Password <span class="text-red-500">*</span>
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
        </div>
    @endunless

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