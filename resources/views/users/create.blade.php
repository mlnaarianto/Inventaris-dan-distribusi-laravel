<x-app-layout>
    <x-slot name="header">Tambah Akun</x-slot>

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 max-w-3xl">
        <form method="POST" action="{{ route('users.store') }}" class="space-y-6">
            @csrf
            @include('users._form')
            <div class="flex items-center gap-3">
                <x-primary-button>Simpan</x-primary-button>
                <a href="{{ route('users.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>