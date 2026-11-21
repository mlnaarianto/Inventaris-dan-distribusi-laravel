<x-app-layout>
    <x-slot name="title">Reset Password</x-slot>
    <x-slot name="header">Reset Password</x-slot>

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 max-w-xl">
        <p class="text-sm text-slate-500 mb-6">
            Atur password baru untuk <span class="font-bold text-slate-700">{{ $user->name }}</span>
            (<span class="font-mono">{{ $user->username }}</span>). Sampaikan password baru ini langsung kepada pemilik akun.
        </p>

        <form method="POST" action="{{ route('users.password.update', $user) }}" class="space-y-6">
            @csrf @method('PUT')
            <div>
                <x-input-label for="password" value="Password Baru" />
                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required autofocus autocomplete="new-password" />
                <p class="mt-1 text-xs text-slate-400">Minimal 8 karakter.</p>
                <x-input-error class="mt-2" :messages="$errors->get('password')" />
            </div>
            <div>
                <x-input-label for="password_confirmation" value="Ulangi Password Baru" />
                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required autocomplete="new-password" />
            </div>
            <div class="flex items-center gap-3">
                <x-primary-button>Reset Password</x-primary-button>
                <a href="{{ route('users.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>