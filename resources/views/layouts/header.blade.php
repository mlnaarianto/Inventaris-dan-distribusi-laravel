<nav class="fixed top-0 z-50 w-full bg-white border-b border-slate-200 shadow-sm">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">

            <div class="flex items-center justify-start rtl:justify-end">
                <!-- Smaller screens: toggle sidebar reliably with a simple DOM toggle -->
                <button aria-controls="logo-sidebar" type="button" onclick="document.getElementById('logo-sidebar').classList.toggle('-translate-x-full')" class="inline-flex items-center p-2 text-sm text-slate-500 rounded-lg sm:hidden hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-slate-200 transition-colors">
                    <span class="sr-only">Buka sidebar</span>
                    <i class="fas fa-bars text-lg w-6 h-6 flex items-center justify-center"></i>
                </button>

                <a href="{{ route('dashboard') }}" class="flex ms-2 md:me-24 items-center gap-2 group">
                    <div class="bg-blue-600 text-white p-1.5 rounded-lg group-hover:bg-blue-700 transition-colors">
                        <i class="fas fa-tint"></i>
                    </div>
                    <span class="self-center text-lg font-extrabold sm:text-2xl whitespace-nowrap text-blue-700 tracking-tight">Pocari System</span>
                </a>
            </div>

            <!-- Middle: Search (helps discoverability) -->
            <div class="hidden md:flex flex-1 mx-4">
                <form action="{{ route('search') ?? '#' }}" method="GET" class="w-full">
                    <div class="relative">
                        <input type="search" name="q" placeholder="Cari pesanan, produk, kode..." class="w-full rounded-lg border border-slate-200 bg-white pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200" />
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-search"></i></span>
                    </div>
                </form>
            </div>

            <div class="flex items-center">
                <div class="flex items-center ms-3 gap-4">

                    <!-- Notification icon -->
                    <button class="relative p-2 rounded-lg hover:bg-slate-50 focus:outline-none">
                        <i class="fas fa-bell text-slate-600"></i>
                        <span class="absolute -top-1 -right-1 inline-flex items-center justify-center w-4 h-4 rounded-full bg-red-500 text-white text-[10px]">3</span>
                    </button>

                    <div class="hidden sm:flex flex-col text-right">
                        <span class="text-sm font-bold text-slate-700 leading-none">{{ Auth::user()->name }}</span>
                        <span class="text-xs font-semibold text-blue-500 uppercase tracking-wider mt-1">{{ Auth::user()->role }}</span>
                    </div>

                    <div class="w-9 h-9 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-500">
                        <i class="fas fa-user"></i>
                    </div>

                    <div class="border-l border-slate-200 pl-4 ml-1">
                        <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                            @csrf
                            <button type="submit" class="text-sm font-bold text-red-500 hover:text-red-700 hover:bg-red-50 px-3 py-1.5 rounded-lg transition-all flex items-center gap-2">
                                <i class="fas fa-sign-out-alt"></i> <span class="hidden sm:inline">Keluar</span>
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</nav>
