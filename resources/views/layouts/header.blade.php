<nav class="fixed top-0 z-50 w-full bg-white border-b border-slate-200 shadow-sm">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">

            <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-slate-500 rounded-lg sm:hidden hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-slate-200 transition-colors">
                    <span class="sr-only">Buka sidebar</span>
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                    </svg>
                </button>
                <a href="{{ route('dashboard') }}" class="flex ms-2 md:me-24 items-center gap-2 group">
                    <div class="bg-blue-600 text-white p-1.5 rounded-lg group-hover:bg-blue-700 transition-colors">
                        <i class="fas fa-tint"></i>
                    </div>
                    <span class="self-center text-xl font-extrabold sm:text-2xl whitespace-nowrap text-blue-700 tracking-tight">Pocari System</span>
                </a>
            </div>

            <div class="flex items-center">
                <div class="relative ms-3" x-data="{ open: false }" @keydown.escape.window="open = false">

                    <button type="button" @click="open = !open" :aria-expanded="open" aria-haspopup="true"
                            class="flex items-center gap-3 rounded-xl px-2 py-1.5 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-200 transition-colors">
                        <div class="hidden sm:flex flex-col text-right">
                            <span class="text-sm font-bold text-slate-700 leading-none">{{ Auth::user()->name }}</span>
                            <span class="text-xs font-semibold text-blue-500 uppercase tracking-wider mt-1">{{ Str::headline(Auth::user()->getRoleNames()->first() ?? '-') }}</span>
                        </div>

                        @if (Auth::user()->foto_url)
                            <img src="{{ Auth::user()->foto_url }}" alt="Foto {{ Auth::user()->name }}"
                                 class="w-9 h-9 rounded-full object-cover border border-slate-200 shadow-sm">
                        @else
                            <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-600 border border-blue-200 flex items-center justify-center text-sm font-bold">
                                {{ Auth::user()->inisial }}
                            </div>
                        @endif

                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="{ 'rotate-180': open }"
                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div x-show="open" x-cloak @click.outside="open = false"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-60 origin-top-right bg-white rounded-xl border border-slate-200 shadow-lg py-1 z-50">

                        <div class="px-4 py-3 border-b border-slate-100">
                            <p class="text-sm font-bold text-slate-800 truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email }}</p>
                            <span class="inline-block mt-2 text-[10px] font-bold uppercase tracking-wider text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">
                                {{ Str::headline(Auth::user()->getRoleNames()->first() ?? '-') }}
                            </span>
                        </div>

                        <div class="py-1">
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                                <svg class="w-5 h-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.118a7.5 7.5 0 0115 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.5-1.632z" />
                                </svg>
                                Profil Saya
                            </a>
                        </div>

                        <div class="border-t border-slate-100 py-1">
                            <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-sm font-semibold text-red-600 hover:bg-red-50 transition-colors">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</nav>