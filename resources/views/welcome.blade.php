<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Distribusi | PT Amerta Indah Otsuka</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Poppins', 'sans-serif'] },
                    colors: {
                        pocari: { 50: '#eff6ff', 100: '#dbeafe', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 900: '#1e3a8a' }
                    }
                }
            }
        }
    </script>

    <style>
        /* Efek latar belakang ombak estetik */
        .bg-wave {
            background-color: #ffffff;
            background-image: radial-gradient(at 40% 20%, hsla(213,100%,92%,1) 0px, transparent 50%),
                              radial-gradient(at 80% 0%, hsla(220,100%,95%,1) 0px, transparent 50%),
                              radial-gradient(at 0% 50%, hsla(215,100%,94%,1) 0px, transparent 50%);
        }
    </style>
</head>
<body class="font-sans antialiased bg-wave text-slate-800 min-h-screen flex flex-col selection:bg-pocari-500 selection:text-white">

    <nav class="fixed w-full z-50 bg-white/80 backdrop-blur-md border-b border-white/20 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-pocari-600 rounded-xl flex items-center justify-center text-white font-black text-xl shadow-lg shadow-pocari-500/30 transform rotate-3 hover:rotate-0 transition-transform">
                        P
                    </div>
                    <div>
                        <span class="font-extrabold text-xl tracking-tight text-slate-800">Otsuka<span class="text-pocari-600">Hub</span></span>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Supply Chain System</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('dashboard') }}" class="font-semibold text-sm text-pocari-600 bg-pocari-50 px-5 py-2.5 rounded-xl hover:bg-pocari-100 transition-colors">
                                Masuk ke Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="font-semibold text-sm text-white bg-pocari-600 px-6 py-2.5 rounded-xl shadow-md shadow-pocari-500/20 hover:bg-pocari-700 hover:-translate-y-0.5 transition-all">
                                Log in Sistem
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow flex items-center pt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full py-12 lg:py-20">
            <div class="flex flex-col-reverse lg:flex-row items-center gap-16">

                <div class="w-full lg:w-1/2 space-y-8 text-center lg:text-left z-10">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-pocari-50 border border-pocari-100 text-pocari-600 text-xs font-bold uppercase tracking-wide">
                        <span class="w-2 h-2 rounded-full bg-pocari-500 animate-pulse"></span>
                        Sistem Terintegrasi V2.0
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-[1.15] text-slate-800">
                        Kelola Distribusi <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-pocari-500 to-indigo-600">Lebih Cerdas & Cepat.</span>
                    </h1>

                    <p class="text-base sm:text-lg text-slate-500 leading-relaxed max-w-xl mx-auto lg:mx-0">
                        OtsukaHub adalah portal resmi untuk manajemen inventaris dan pengajuan barang antara Gudang Pusat Pocari Sweat dengan mitra Distributor secara real-time.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="w-full sm:w-auto text-center font-bold text-white bg-pocari-600 px-8 py-3.5 rounded-xl shadow-lg shadow-pocari-500/30 hover:bg-pocari-700 hover:-translate-y-1 transition-all">
                                Buka Ruang Kerja <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="w-full sm:w-auto text-center font-bold text-white bg-pocari-600 px-8 py-3.5 rounded-xl shadow-lg shadow-pocari-500/30 hover:bg-pocari-700 hover:-translate-y-1 transition-all">
                                Masuk ke Sistem
                            </a>
                        @endauth
                        <a href="#fitur" class="w-full sm:w-auto text-center font-bold text-slate-600 bg-white border-2 border-slate-200 px-8 py-3.5 rounded-xl hover:border-pocari-500 hover:text-pocari-600 hover:-translate-y-1 transition-all">
                            Pelajari Fitur
                        </a>
                    </div>
                </div>

                <div class="w-full lg:w-1/2 relative">
                    <div class="absolute inset-0 bg-gradient-to-tr from-pocari-100 to-indigo-50 rounded-full blur-3xl opacity-70 transform scale-90"></div>

                    <div class="relative w-full aspect-[4/3] rounded-[2rem] overflow-hidden shadow-2xl shadow-pocari-900/10 border-4 border-white transform lg:rotate-2 hover:rotate-0 transition-transform duration-500">
                        <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?q=80&w=2070&auto=format&fit=crop" alt="Warehouse Aesthetic" class="w-full h-full object-cover">

                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 to-transparent"></div>

                        <div class="absolute bottom-6 left-6 right-6 bg-white/90 backdrop-blur-md rounded-2xl p-4 shadow-lg flex items-center gap-4">
                            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600">
                                <i class="fas fa-check-double text-xl"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase">Status Server</p>
                                <p class="text-sm font-extrabold text-slate-800">Online & Sinkron</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <section id="fitur" class="bg-white py-20 border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-slate-800 mb-4">Integrasi Tanpa Batas</h2>
                <p class="text-slate-500 max-w-2xl mx-auto">Dirancang khusus untuk meminimalkan human-error dalam pencatatan stok dan mempercepat proses pengiriman produk ke distributor.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-slate-50 rounded-3xl p-8 hover:-translate-y-2 hover:shadow-xl hover:shadow-pocari-500/10 transition-all duration-300 border border-slate-100">
                    <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 mb-6">
                        <i class="fas fa-cubes text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Live Inventory</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Pemantauan stok gudang pusat secara real-time. Dilengkapi fitur multi-kemasan untuk keakuratan data.</p>
                </div>

                <div class="bg-slate-50 rounded-3xl p-8 hover:-translate-y-2 hover:shadow-xl hover:shadow-pocari-500/10 transition-all duration-300 border border-slate-100">
                    <div class="w-14 h-14 bg-indigo-100 rounded-2xl flex items-center justify-center text-indigo-600 mb-6">
                        <i class="fas fa-truck-fast text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Sistem Pengajuan</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Distributor dapat memesan barang dengan mudah. Pusat melakukan validasi dan mencetak surat jalan otomatis.</p>
                </div>

                <div class="bg-slate-50 rounded-3xl p-8 hover:-translate-y-2 hover:shadow-xl hover:shadow-pocari-500/10 transition-all duration-300 border border-slate-100">
                    <div class="w-14 h-14 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 mb-6">
                        <i class="fas fa-file-invoice text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Audit & Mutasi</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Pencatatan riwayat barang masuk dan keluar yang transparan untuk kebutuhan pelaporan dan audit akhir bulan.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-slate-900 text-slate-400 py-8 text-center border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 flex flex-col items-center">
            <div class="flex items-center gap-2 mb-4 opacity-50 grayscale hover:grayscale-0 hover:opacity-100 transition-all">
                <div class="w-6 h-6 bg-white rounded-md flex items-center justify-center text-pocari-600 font-black text-xs">P</div>
                <span class="font-bold text-white text-sm">OtsukaHub</span>
            </div>
            <p class="text-sm">
                &copy; {{ date('Y') }} PT Amerta Indah Otsuka. Sistem Informasi Pengelolaan Gudang & Distribusi.
            </p>
        </div>
    </footer>

</body>
</html>
