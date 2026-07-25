<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log in | OtsukaHub System</title>

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
</head>
<body class="font-sans antialiased text-slate-800 bg-white selection:bg-pocari-500 selection:text-white">

    <div class="flex min-h-screen">

        <div class="hidden lg:flex lg:w-1/2 relative bg-pocari-900 overflow-hidden items-center justify-center">
            <img src="https://images.unsplash.com/photo-1550684848-fac1c5b4e853?q=80&w=2070&auto=format&fit=crop"
                 alt="Otsuka Logistics"
                 class="absolute inset-0 w-full h-full object-cover opacity-30 mix-blend-overlay scale-105">

            <div class="absolute inset-0 bg-gradient-to-br from-pocari-600/90 to-pocari-900/90"></div>
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-full h-64 bg-gradient-to-t from-pocari-900 to-transparent"></div>

            <div class="relative z-10 px-16 xl:px-24 text-white">
                <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-pocari-600 font-black text-3xl shadow-2xl mb-8 transform -rotate-3">
                    P
                </div>
                <h1 class="text-4xl xl:text-5xl font-extrabold tracking-tight mb-4 leading-tight">
                    Portal Integrasi<br>Supply Chain.
                </h1>
                <p class="text-pocari-100 text-lg max-w-md leading-relaxed">
                    Sistem pemantauan stok real-time dan manajemen distribusi resmi untuk mitra PT Amerta Indah Otsuka.
                </p>

                <div class="mt-12 flex items-center gap-4 text-sm font-semibold text-pocari-200 bg-white/10 w-fit px-5 py-3 rounded-2xl backdrop-blur-sm border border-white/10">
                    <i class="fas fa-shield-alt text-emerald-400 text-lg"></i>
                    Akses Sistem Terenkripsi (End-to-End)
                </div>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 sm:px-16 xl:px-32 bg-white relative">

            <a href="{{ url('/') }}" class="absolute top-8 left-8 sm:left-16 xl:left-32 text-sm font-bold text-slate-400 hover:text-pocari-600 transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>

            <div class="max-w-md w-full mx-auto">

                <div class="flex lg:hidden items-center gap-3 mb-10">
                    <div class="w-10 h-10 bg-pocari-600 rounded-xl flex items-center justify-center text-white font-black text-xl shadow-lg">P</div>
                    <span class="font-extrabold text-xl tracking-tight">Otsuka<span class="text-pocari-600">Hub</span></span>
                </div>

                <div class="mb-10 text-center sm:text-left">
                    <h2 class="text-3xl font-extrabold text-slate-800 mb-2">Selamat Datang</h2>
                    <p class="text-slate-500 text-sm">Silakan masukkan email dan kata sandi Anda untuk mengakses ruang kerja sistem.</p>
                </div>

                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 flex items-start gap-3 text-red-600">
                        <i class="fas fa-exclamation-circle mt-0.5"></i>
                        <ul class="text-sm font-medium">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block mb-2 text-sm font-bold text-slate-700">Alamat Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="contoh@distributor.com"
                                class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-pocari-500/20 focus:border-pocari-500 block w-full pl-11 p-3.5 outline-none transition-all" />
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="block text-sm font-bold text-slate-700">Kata Sandi</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs font-bold text-pocari-600 hover:text-pocari-700 transition-colors">
                                    Lupa sandi?
                                </a>
                            @endif
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="fas fa-lock"></i>
                            </div>
                            <input id="password" type="password" name="password" required placeholder="••••••••"
                                class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-pocari-500/20 focus:border-pocari-500 block w-full pl-11 pr-11 p-3.5 outline-none transition-all" />

                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center cursor-pointer text-slate-400 hover:text-pocari-600 transition-colors" id="togglePassword">
                                <i class="fas fa-eye" id="eyeIcon"></i>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 text-pocari-600 bg-slate-50 border-slate-300 rounded focus:ring-pocari-500 focus:ring-2 cursor-pointer">
                        <label for="remember_me" class="ml-2 text-sm font-medium text-slate-600 cursor-pointer">Ingat sesi saya</label>
                    </div>

                    <button type="submit" class="w-full flex justify-center items-center gap-2 py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-pocari-500/30 text-sm font-bold text-white bg-pocari-600 hover:bg-pocari-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pocari-500 transform hover:-translate-y-0.5 transition-all">
                        Masuk ke Sistem <i class="fas fa-sign-in-alt"></i>
                    </button>

                </form>
            </div>

            <div class="absolute bottom-8 left-0 w-full text-center lg:text-left lg:px-16 xl:px-32">
                <p class="text-xs font-semibold text-slate-400">
                    &copy; {{ date('Y') }} PT Amerta Indah Otsuka. All rights reserved.
                </p>
            </div>

        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function (e) {
            // Ubah tipe input
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // Ubah ikon mata
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
