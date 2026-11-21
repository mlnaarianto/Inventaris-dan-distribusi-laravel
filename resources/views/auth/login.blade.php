<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk | Pocari System</title>

    <link rel="icon" type="image/jpeg" href="{{ asset('assets/123.jpg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

<body class="font-poppins antialiased text-slate-800 dark:text-slate-100 bg-slate-50 dark:bg-slate-950 selection:bg-pocari-500 selection:text-white transition-colors duration-300 overflow-hidden">

    <div class="flex min-h-screen relative">

        {{-- ================= PANEL KIRI (MODERN GRADIENT & BRANDING) ================= --}}
        <div class="hidden lg:flex lg:w-1/2 relative bg-slate-900 overflow-hidden items-center justify-center">
            
            {{-- Efek Mesh Gradient / Orbs --}}
            <div class="absolute top-0 right-0 w-[40rem] h-[40rem] bg-blue-600/30 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/3"></div>
            <div class="absolute bottom-0 left-0 w-[40rem] h-[40rem] bg-indigo-600/20 rounded-full blur-[120px] translate-y-1/3 -translate-x-1/3"></div>
            <div class="absolute top-1/2 left-1/2 w-96 h-96 bg-cyan-500/20 rounded-full blur-[80px] -translate-x-1/2 -translate-y-1/2"></div>

            {{-- Grid Pattern Overlay --}}
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4wNSkiLz48L3N2Zz4=')] opacity-50"></div>

            <div class="relative z-10 px-16 xl:px-24 w-full max-w-2xl">
                
                <div class="mb-12 inline-flex items-center gap-4 bg-white/5 backdrop-blur-xl border border-white/10 px-4 py-3 rounded-2xl shadow-2xl">
                    <div class="w-12 h-12 bg-white rounded-xl p-1.5 shadow-inner flex items-center justify-center">
                        <img src="{{ asset('assets/123.jpg') }}" alt="Logo" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h3 class="text-white font-bold tracking-wide">PT. Amerta Indah Otsuka</h3>
                        <p class="text-blue-200 text-xs font-medium tracking-widest uppercase">Pocari System</p>
                    </div>
                </div>

                <h1 class="text-4xl xl:text-5xl font-extrabold tracking-tight text-white mb-6 leading-[1.15]">
                    Integrasi Supply Chain, <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-400">Lebih Cepat & Akurat.</span>
                </h1>
                
                <p class="text-slate-300 text-lg max-w-lg leading-relaxed font-light mb-10">
                    Sistem pemantauan stok real-time dan manajemen distribusi resmi untuk mitra PT Amerta Indah Otsuka.
                </p>

                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-2 text-sm font-medium text-emerald-400 bg-emerald-400/10 px-4 py-2 rounded-full border border-emerald-400/20">
                        <i class="fas fa-shield-check"></i> Keamanan End-to-End
                    </div>
                    <div class="flex items-center gap-2 text-sm font-medium text-blue-300 bg-blue-400/10 px-4 py-2 rounded-full border border-blue-400/20">
                        <i class="fas fa-bolt"></i> Real-time Data
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= PANEL KANAN (FORM LOGIN) ================= --}}
        <div class="w-full lg:w-1/2 flex flex-col justify-center items-center px-6 sm:px-12 bg-slate-50 dark:bg-slate-950 relative transition-colors duration-300">
            
            {{-- Top Controls (Kembali & Dark Mode) --}}
            <div class="absolute top-6 left-6 right-6 flex justify-between items-center z-20">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-pocari-600 dark:text-slate-400 dark:hover:text-white transition-colors group px-3 py-2 rounded-lg hover:bg-slate-200/50 dark:hover:bg-slate-800/50">
                    <i class="fas fa-arrow-left transform group-hover:-translate-x-1 transition-transform"></i>
                    <span class="hidden sm:inline">Beranda</span>
                </a>

                <button id="theme-toggle" type="button" aria-label="Toggle Dark Mode"
                    class="w-10 h-10 rounded-full flex items-center justify-center bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 shadow-sm border border-slate-200 dark:border-slate-700 hover:scale-105 transition-all">
                    <i id="theme-toggle-icon" class="fas fa-moon text-sm"></i>
                </button>
            </div>

            {{-- Wrapper Form --}}
            <div class="w-full max-w-[420px] relative z-10">
                
                {{-- Logo Mobile --}}
                <div class="flex lg:hidden justify-center items-center gap-3 mb-8">
                    <div class="w-12 h-12 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-1.5 shadow-sm flex items-center justify-center">
                        <img src="{{ asset('assets/123.jpg') }}" alt="Logo" class="w-full h-full object-contain">
                    </div>
                    <span class="font-extrabold text-2xl tracking-tight text-slate-800 dark:text-white">Pocari<span class="text-pocari-600 dark:text-pocari-400"> System</span></span>
                </div>

                {{-- Header Text --}}
                <div class="mb-8 text-center lg:text-left">
                    <h2 class="text-3xl font-extrabold text-slate-800 dark:text-white mb-2 tracking-tight">Selamat Datang 👋</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-sm">Silakan masuk menggunakan akun distributor atau pusat Anda.</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    {{-- Input Username --}}
                    <div>
                        <label for="username" class="block mb-2 text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Username</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-pocari-600 transition-colors">
                                <i class="fas fa-user text-sm"></i>
                            </div>
                            <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus autocomplete="username" placeholder="Masukkan username"
                                class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-800 dark:text-white text-sm rounded-xl focus:ring-4 focus:ring-pocari-500/10 focus:border-pocari-500 block w-full pl-11 p-3.5 outline-none transition-all shadow-sm" />
                        </div>
                    </div>

                    {{-- Input Password --}}
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label for="password" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Kata Sandi</label>
                        </div>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-pocari-600 transition-colors">
                                <i class="fas fa-lock text-sm"></i>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••"
                                class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-800 dark:text-white text-sm rounded-xl focus:ring-4 focus:ring-pocari-500/10 focus:border-pocari-500 block w-full pl-11 pr-11 p-3.5 outline-none transition-all shadow-sm" />

                            <button type="button" id="togglePassword" aria-label="Tampilkan kata sandi"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                                <i class="fas fa-eye text-sm" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Remember Me --}}
                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input id="remember_me" type="checkbox" name="remember" value="1" class="w-4 h-4 text-pocari-600 bg-white dark:bg-slate-900 border-slate-300 dark:border-slate-700 rounded focus:ring-pocari-500 focus:ring-2 cursor-pointer transition-all">
                            <span class="text-sm font-medium text-slate-600 dark:text-slate-400 group-hover:text-slate-800 dark:group-hover:text-slate-200 transition-colors">Ingat saya</span>
                        </label>
                    </div>

                    {{-- Tombol Submit --}}
                    <button type="submit" class="w-full mt-2 flex justify-center items-center gap-2 py-3.5 px-4 rounded-xl shadow-lg shadow-pocari-500/25 text-sm font-bold text-white bg-gradient-to-r from-pocari-600 to-pocari-500 hover:from-pocari-700 hover:to-pocari-600 focus:outline-none focus:ring-4 focus:ring-pocari-500/30 transform hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200">
                        Masuk ke Sistem 
                        <i class="fas fa-arrow-right text-xs"></i>
                    </button>

                </form>

                <p class="mt-8 text-center text-sm text-slate-500 dark:text-slate-400">
                    Lupa kata sandi? <a href="#" class="font-semibold text-pocari-600 hover:underline">Hubungi Admin</a>
                </p>
                
            </div>

            {{-- Footer --}}
            <div class="absolute bottom-6 w-full text-center px-6">
                <p class="text-[11px] font-semibold text-slate-400 dark:text-slate-600 uppercase tracking-wider">
                    &copy; {{ date('Y') }} PT Amerta Indah Otsuka
                </p>
            </div>

        </div>
    </div>

    <script>
        // === Dark mode toggle ===
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

        // Tampilkan / sembunyikan kata sandi
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });

        // Toast pojok kanan atas
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        @if (session('success'))
            Toast.fire({ icon: 'success', title: @json(session('success')) });
        @endif

        @if (session('error'))
            Toast.fire({ icon: 'error', title: @json(session('error')), timer: 6000 });
        @endif

        @if (session('status'))
            Toast.fire({ icon: 'success', title: @json(session('status')) });
        @endif

        @if ($errors->any())
            Toast.fire({ icon: 'error', title: @json($errors->first()), timer: 6000 });
        @endif
    </script>
</body>

</html>