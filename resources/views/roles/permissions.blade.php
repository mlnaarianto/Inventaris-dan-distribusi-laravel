<x-app-layout>
    <x-slot name="header">Permission Role: {{ Str::headline($role->name) }}</x-slot>

    <form method="POST" action="{{ route('roles.permissions.update', $role) }}" class="space-y-5">
        @csrf @method('PUT')

        @foreach ($permissions as $label => $items)
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6"
            x-data="{
                    toggle(e) { $root.querySelectorAll('input[type=checkbox][name=\'permissions[]\']').forEach(c => c.checked = e.target.checked) }
                 }">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-slate-800">{{ $label }}</h3>
                <label class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 cursor-pointer">
                    <input type="checkbox" @change="toggle($event)"
                        class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    Pilih semua
                </label>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach ($items as $permission)
                <label class="flex items-start gap-3 rounded-xl border border-slate-200 px-3 py-2.5 hover:bg-slate-50 cursor-pointer">
                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                        @checked(in_array($permission->name, old('permissions', $rolePermissions)))
                    class="mt-0.5 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <span>
                        <span class="block text-sm font-semibold text-slate-700">{{ $labels[$permission->name] ?? $permission->name }}</span>
                        <span class="block text-[11px] font-mono text-slate-400">{{ $permission->name }}</span>
                    </span>
                </label>
                @endforeach
            </div>
        </div>
        @endforeach

        <div class="flex items-center gap-3">
            <x-primary-button>Simpan Permission</x-primary-button>
            <a href="{{ route('roles.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Batal</a>
        </div>
    </form>
</x-app-layout>