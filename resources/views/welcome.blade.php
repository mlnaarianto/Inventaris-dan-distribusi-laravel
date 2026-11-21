<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Distribusi | PT Amerta Indah Otsuka</title>

    <link rel="icon" type="image/jpeg" href="{{ asset('assets/123.jpg') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Anti-flash: set tema SEBELUM render --}}
    <script>
        if (localStorage.theme === 'dark' ||
            (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="font-poppins antialiased text-slate-800 dark:text-slate-100 min-h-screen flex flex-col selection:bg-pocari-500 selection:text-white transition-colors duration-300 relative overflow-x-hidden bg-slate-50 dark:bg-slate-950">

    {{-- ================= BACKGROUND EFFECTS (MESH GRADIENT) ================= --}}
    <div class="fixed top-[-10%] left-[-10%] w-[40rem] h-[40rem] bg-pocari-400/20 dark:bg-pocari-600/10 rounded-full blur-[120px] pointer-events-none -z-10"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-[40rem] h-[40rem] bg-indigo-400/20 dark:bg-indigo-600/10 rounded-full blur-[120px] pointer-events-none -z-10"></div>
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[30rem] h-[30rem] bg-cyan-400/10 dark:bg-cyan-600/5 rounded-full blur-[100px] pointer-events-none -z-10"></div>

    {{-- ================= NAVBAR (FULL WIDTH STYLE) ================= --}}
    <nav class="fixed w-full z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-b border-slate-200/50 dark:border-slate-800 shadow-sm transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                {{-- Logo --}}
                <div class="flex items-center gap-3 group cursor-pointer">
                    <div class="w-10 h-10 bg-white dark:bg-slate-800 rounded-xl p-1 shadow-sm border border-slate-200 dark:border-slate-700 flex items-center justify-center overflow-hidden group-hover:scale-105 transition-transform">
                        <img src="{{ asset('assets/123.jpg') }}" alt="Logo Pocari" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <span class="font-extrabold text-xl tracking-tight text-slate-800 dark:text-white group-hover:text-pocari-600 dark:group-hover:text-pocari-400 transition-colors">Pocari<span class="text-pocari-600 dark:text-pocari-500"> System</span></span>
                        <p class="text-[9px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest leading-none mt-0.5">Supply Chain Portal</p>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-2 sm:gap-4">
                    @if (Route::has('login'))
                        @auth
                        <a href="{{ route('dashboard') }}" class="hidden sm:inline-flex font-bold text-sm text-pocari-700 bg-pocari-50 px-5 py-2.5 rounded-xl hover:bg-pocari-100 transition-colors dark:bg-pocari-500/10 dark:text-pocari-400 dark:hover:bg-pocari-500/20">
                            Dashboard <i class="fas fa-arrow-right ml-1.5 text-xs"></i>
                        </a>
                        @else
                        <a href="{{ route('login') }}" class="hidden sm:inline-flex font-bold text-sm text-white bg-gradient-to-r from-pocari-600 to-pocari-500 px-6 py-2.5 rounded-xl shadow-lg shadow-pocari-500/30 hover:shadow-pocari-500/50 hover:-translate-y-0.5 transition-all">
                            Log in Sistem
                        </a>
                        @endauth
                    @endif

                    {{-- Tombol Dark Mode --}}
                    <button id="theme-toggle" type="button" aria-label="Toggle Dark Mode"
                        class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl flex items-center justify-center bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700 transition-all border border-slate-200/50 dark:border-slate-700/50">
                        <i id="theme-toggle-icon" class="fas fa-moon text-sm sm:text-base"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    {{-- ================= HERO SECTION ================= --}}
    <main class="flex-grow flex items-center pt-32 sm:pt-40 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">

                {{-- Teks Kiri --}}
                <div class="w-full lg:w-1/2 space-y-8 text-center lg:text-left z-10">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm text-pocari-600 dark:text-pocari-400 text-xs font-bold uppercase tracking-wide">
                        <span class="relative flex h-2.5 w-2.5">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-pocari-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-pocari-500"></span>
                        </span>
                        Sistem Terintegrasi V2.0
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-[3.5rem] font-extrabold leading-[1.15] text-slate-900 dark:text-white tracking-tight">
                        Kelola Distribusi <br class="hidden sm:block">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-pocari-600 via-blue-500 to-indigo-600 dark:from-pocari-400 dark:via-blue-400 dark:to-indigo-400">Lebih Cerdas & Cepat.</span>
                    </h1>

                    <p class="text-base sm:text-lg text-slate-600 dark:text-slate-400 leading-relaxed max-w-xl mx-auto lg:mx-0 font-light">
                        Portal resmi manajemen inventaris dan pengajuan barang antara Gudang Pusat Pocari Sweat dengan mitra Distributor. Pantau ketersediaan stok secara <i>real-time</i> dari mana saja.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-4">
                        @auth
                        <a href="{{ route('dashboard') }}" class="w-full sm:w-auto text-center font-bold text-white bg-gradient-to-r from-pocari-600 to-pocari-500 px-8 py-4 rounded-xl shadow-xl shadow-pocari-500/30 hover:shadow-pocari-500/50 hover:-translate-y-1 transition-all duration-300">
                            Buka Ruang Kerja <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                        @else
                        <a href="{{ route('login') }}" class="w-full sm:w-auto text-center font-bold text-white bg-gradient-to-r from-pocari-600 to-pocari-500 px-8 py-4 rounded-xl shadow-xl shadow-pocari-500/30 hover:shadow-pocari-500/50 hover:-translate-y-1 transition-all duration-300">
                            Mulai Masuk Sistem
                        </a>
                        @endauth
                        <a href="#fitur" class="w-full sm:w-auto text-center font-bold text-slate-700 bg-white border border-slate-200 px-8 py-4 rounded-xl hover:bg-slate-50 hover:-translate-y-1 transition-all duration-300 dark:bg-slate-900 dark:text-slate-200 dark:border-slate-700 dark:hover:bg-slate-800 shadow-sm">
                            Pelajari Fitur
                        </a>
                    </div>
                </div>

                {{-- Gambar Kanan dengan Efek UI Mockup --}}
                <div class="w-full lg:w-1/2 relative perspective-1000">
                    <div class="relative w-full aspect-[4/3] rounded-[2rem] overflow-visible">
                        {{-- Bingkai Gambar --}}
                        <div class="absolute inset-0 rounded-[2rem] overflow-hidden shadow-2xl shadow-indigo-900/20 dark:shadow-black/50 border-4 border-white dark:border-slate-800 transform lg:rotate-y-[-5deg] lg:rotate-x-[5deg] hover:rotate-0 transition-transform duration-700 ease-out z-10">
                            <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?q=80&w=2070&auto=format&fit=crop" alt="Warehouse" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-tr from-slate-900/60 via-transparent to-transparent"></div>
                        </div>

                        {{-- Floating Card 1 (Kiri Bawah) --}}
                        <div class="absolute -bottom-6 -left-6 sm:-left-10 bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl border border-white/50 dark:border-slate-700 rounded-2xl p-4 shadow-xl z-20 animate-[bounce_4s_infinite]">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-500/20 rounded-xl flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                                    <i class="fas fa-box-open"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Stok Gudang</p>
                                    <p class="text-lg font-black text-slate-800 dark:text-white leading-none mt-1">14,250 <span class="text-xs font-medium text-slate-500">Pcs</span></p>
                                </div>
                            </div>
                        </div>

                        {{-- Floating Card 2 (Kanan Atas) --}}
                        <div class="absolute -top-6 -right-4 sm:-right-8 bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl border border-white/50 dark:border-slate-700 rounded-2xl p-4 shadow-xl z-20 animate-[bounce_5s_infinite]">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-pocari-100 dark:bg-pocari-500/20 rounded-xl flex items-center justify-center text-pocari-600 dark:text-pocari-400">
                                    <i class="fas fa-truck-fast"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Dalam Perjalanan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    {{-- ================= FITUR SECTION (BENTO GRID STYLE) ================= --}}
    <section id="fitur" class="py-24 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white mb-4 tracking-tight">Dirancang Untuk Efisiensi</h2>
                <p class="text-slate-500 dark:text-slate-400 text-base sm:text-lg">Meminimalkan <i>human-error</i> dalam pencatatan stok dan mempercepat proses pengiriman produk ke seluruh mitra distributor.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                
                {{-- Card 1 --}}
                <div class="group bg-white dark:bg-slate-900 rounded-3xl p-8 hover:-translate-y-2 hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-300 border border-slate-200 dark:border-slate-800 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 rounded-full blur-2xl group-hover:bg-blue-500/10 transition-colors"></div>
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-500/30 mb-6 group-hover:scale-110 transition-transform">
                        <i class="fas fa-cubes text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-3">Live Inventory</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed relative z-10">Pemantauan stok gudang pusat secara <i>real-time</i>. Dilengkapi fitur multi-kemasan untuk keakuratan data harian.</p>
                </div>

                {{-- Card 2 --}}
                <div class="group bg-white dark:bg-slate-900 rounded-3xl p-8 hover:-translate-y-2 hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-300 border border-slate-200 dark:border-slate-800 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/5 rounded-full blur-2xl group-hover:bg-indigo-500/10 transition-colors"></div>
                    <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-indigo-500/30 mb-6 group-hover:scale-110 transition-transform">
                        <i class="fas fa-file-signature text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-3">Sistem Pengajuan</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed relative z-10">Distributor dapat memesan barang dengan mudah. Pusat melakukan validasi dan mencetak surat jalan secara otomatis.</p>
                </div>

                {{-- Card 3 --}}
                <div class="group bg-white dark:bg-slate-900 rounded-3xl p-8 hover:-translate-y-2 hover:shadow-2xl hover:shadow-emerald-500/10 transition-all duration-300 border border-slate-200 dark:border-slate-800 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 rounded-full blur-2xl group-hover:bg-emerald-500/10 transition-colors"></div>
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-400 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-500/30 mb-6 group-hover:scale-110 transition-transform">
                        <i class="fas fa-chart-line text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-3">Audit & Mutasi</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed relative z-10">Pencatatan riwayat barang masuk dan keluar yang transparan untuk kebutuhan pelaporan dan audit akhir bulan.</p>
                </div>

            </div>
        </div>
    </section>

    {{-- ================= FOOTER ================= --}}
    <footer class="bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 py-10 transition-colors duration-300 mt-auto relative z-10">
        <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-white dark:bg-slate-800 rounded-lg p-1 border border-slate-200 dark:border-slate-700 shadow-sm flex items-center justify-center">
                    <img src="{{ asset('assets/123.jpg') }}" alt="Logo" class="w-full h-full object-contain">
                </div>
                <span class="font-extrabold text-slate-800 dark:text-white tracking-tight">Pocari System</span>
            </div>
            
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400 text-center md:text-right">
                &copy; {{ date('Y') }} PT Amerta Indah Otsuka. All rights reserved.
            </p>
        </div>
    </footer>

    {{-- Script Dark Mode Toggle --}}
    <script>
        (function () {
            const toggle = document.getElementById('theme-toggle');
            const icon   = document.getElementById('theme-toggle-icon');

            const renderIcon = () => {
                const isDark = document.documentElement.classList.contains('dark');
                icon.classList.toggle('fa-moon', !isDark);
                icon.classList.toggle('fa-sun',  isDark);
            };

            renderIcon();

            toggle.addEventListener('click', () => {
                document.documentElement.classList.toggle('dark');
                localStorage.theme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
                renderIcon();
            });
        })();
    </script>

</body>

</html>