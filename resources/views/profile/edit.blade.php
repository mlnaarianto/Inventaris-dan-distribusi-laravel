<x-app-layout>
    <x-slot name="title">Profil Saya</x-slot>
    <x-slot name="header">Profil Saya</x-slot>

    <div class="space-y-5 mb-6">

        {{-- ================= HERO USER CARD ================= --}}
        <div class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 dark:from-blue-700 dark:via-indigo-800 dark:to-slate-900 rounded-2xl p-5 sm:p-7 overflow-hidden shadow-lg shadow-blue-500/20 dark:shadow-black/40">
            <div class="absolute -top-20 -right-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-32 w-32 h-32 bg-indigo-400/20 rounded-full blur-2xl"></div>

            <div class="relative z-10 flex items-center gap-4 sm:gap-5">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-white/20 backdrop-blur-md border-2 border-white/40 flex items-center justify-center text-white font-black text-xl sm:text-2xl shrink-0 overflow-hidden shadow-lg">
                    @if($user->foto_url)
                        <img src="{{ $user->foto_url }}" class="w-full h-full object-cover" alt="Foto">
                    @else
                        {{ $user->inisial }}
                    @endif
                </div>

                <div class="min-w-0 flex-1">
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-white/10 border border-white/20 text-blue-50 text-[9px] font-bold uppercase tracking-widest mb-1.5 backdrop-blur-md">
                        <i class="fas fa-user-circle text-[9px]"></i>
                        Akun Saya
                    </div>

                    <h2 class="text-xl sm:text-2xl font-extrabold text-white truncate leading-tight">{{ $user->name }}</h2>
                    <p class="text-blue-100/80 text-sm truncate">{{ $user->email }}</p>

                    <span class="inline-flex items-center gap-1 mt-2 text-[10px] font-bold uppercase tracking-wider text-white bg-white/20 border border-white/30 px-2.5 py-0.5 rounded-full">
                        <i class="fas fa-shield-halved text-[8px]"></i>
                        {{ ucwords(str_replace('-', ' ', $user->getRoleNames()->first() ?? '-')) }}
                    </span>
                </div>
            </div>
        </div>

        {{-- ================= FORM PROFIL ================= --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-5 sm:p-8 transition-colors">
            @include('profile.partials.update-profile-information-form')
        </div>

        {{-- ================= FORM PASSWORD ================= --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-5 sm:p-8 transition-colors">
            @include('profile.partials.update-password-form')
        </div>
    </div>
</x-app-layout>