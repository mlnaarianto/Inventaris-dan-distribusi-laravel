<x-app-layout>
    <x-slot name="header">Ubah Akun</x-slot>

    @if (session('error'))
        <div class="mb-4 max-w-3xl rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm font-semibold px-4 py-3">{{ session('error') }}</div>
    @endif

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 max-w-3xl">
        <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-6">
            @csrf @method('PUT')
            @include('users._form')
            <div class="flex items-center gap-3">
                <x-primary-button>Simpan</x-primary-button>
                <a href="{{ route('users.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>