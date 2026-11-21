@php
    $editing = isset($user);
    $isSelf = $isSelf ?? false;
@endphp

<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
    <div>
        <x-input-label for="name" value="Nama Lengkap" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name ?? '')" required autofocus />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>

    <div>
        <x-input-label for="username" value="Username" />
        <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username', $user->username ?? '')" required autocomplete="off" />
        <p class="mt-1 text-xs text-slate-400">Huruf kecil, angka, strip (-), dan garis bawah (_). Dipakai untuk login.</p>
        <x-input-error class="mt-2" :messages="$errors->get('username')" />
    </div>
</div>

<div>
    <x-input-label for="email" value="Email" />
    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email ?? '')" required autocomplete="off" />
    <x-input-error class="mt-2" :messages="$errors->get('email')" />
</div>

<div>
    <x-input-label for="role" value="Role" />
    @if ($isSelf)
        <x-text-input type="text" class="mt-1 block w-full bg-slate-100 text-slate-500 cursor-not-allowed"
                      :value="Str::headline($userRole ?? '-')" readonly disabled />
        <p class="mt-1 text-xs text-slate-400">Anda tidak dapat mengubah role akun sendiri.</p>
    @else
        <select id="role" name="role" required
                class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
            <option value="" disabled @selected(! old('role', $userRole ?? null))>Pilih role...</option>
            @foreach ($roles as $role)
                <option value="{{ $role->name }}" @selected(old('role', $userRole ?? null) === $role->name)>{{ Str::headline($role->name) }}</option>
            @endforeach
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('role')" />
    @endif
</div>

@unless ($editing)
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div>
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required autocomplete="new-password" />
            <p class="mt-1 text-xs text-slate-400">Minimal 8 karakter.</p>
            <x-input-error class="mt-2" :messages="$errors->get('password')" />
        </div>
        <div>
            <x-input-label for="password_confirmation" value="Ulangi Password" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required autocomplete="new-password" />
        </div>
    </div>
@endunless