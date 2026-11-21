<x-app-layout>
    <x-slot name="header">Ubah Role</x-slot>

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 max-w-xl">
        <form method="POST" action="{{ route('roles.update', $role) }}" class="space-y-6">
            @csrf @method('PUT')
            <div>
                <x-input-label for="name" value="Nama Role" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $role->name)" required autofocus />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>
            <div class="flex items-center gap-3">
                <x-primary-button>Simpan</x-primary-button>
                <a href="{{ route('roles.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>