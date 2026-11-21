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
</head>

<body class="font-poppins antialiased text-slate-800 bg-white selection:bg-pocari-500 selection:text-white">

    <div class="flex min-h-screen">

        {{-- Panel kiri (dekoratif) --}}
        <div class="hidden lg:flex lg:w-1/2 relative bg-pocari-900 overflow-hidden items-center justify-center">
            <img src="https://images.unsplash.com/photo-1550684848-fac1c5b4e853?q=80&w=2070&auto=format&fit=crop"
                alt="Otsuka Logistics"
                class="absolute inset-0 w-full h-full object-cover opacity-30 mix-blend-overlay scale-105">

            <div class="absolute inset-0 bg-gradient-to-br from-pocari-600/90 to-pocari-900/90"></div>
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-full h-64 bg-gradient-to-t from-pocari-900 to-transparent"></div>

            <div class="relative z-10 px-16 xl:px-24 text-white">
                <div class="w-24 h-24 bg-white rounded-2xl p-2 shadow-2xl mb-8 transform -rotate-3 flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('assets/123.jpg') }}" alt="Logo PT. Amerta Indah Otsuka" class="w-full h-full object-contain">
                </div>
                <h1 class="text-4xl xl:text-5xl font-extrabold tracking-tight mb-4 leading-tight">
                    Portal Integrasi<br>Supply Chain.
                </h1>
                <p class="text-pocari-100 text-lg max-w-md leading-relaxed">
                    Sistem pemantauan stok real-time dan manajemen distribusi resmi untuk mitra PT Amerta Indah Otsuka.
                </p>

                <div class="mt-12 flex items-center gap-4 text-sm font-semibold text-pocari-100 bg-white/10 w-fit px-5 py-3 rounded-2xl backdrop-blur-sm border border-white/10">
                    <i class="fas fa-shield-alt text-emerald-400 text-lg"></i>
                    Akses Sistem Terenkripsi (End-to-End)
                </div>
            </div>
        </div>

        {{-- Panel kanan (form login) --}}
        <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 sm:px-16 xl:px-32 bg-white relative">

            <div class="max-w-md w-full mx-auto">

                <div class="flex lg:hidden items-center gap-3 mb-10">
                    <div class="w-12 h-12 bg-white border border-slate-200 rounded-xl p-1 shadow-lg flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('assets/123.jpg') }}" alt="Logo PT. Amerta Indah Otsuka" class="w-full h-full object-contain">
                    </div>
                    <span class="font-extrabold text-xl tracking-tight">Pocari<span class="text-pocari-600"> System</span></span>
                </div>

                <div class="mb-10 text-center sm:text-left">
                    <h2 class="text-3xl font-extrabold text-slate-800 mb-2">Selamat Datang</h2>
                    <p class="text-slate-500 text-sm">Silakan masukkan username dan kata sandi Anda untuk mengakses ruang kerja sistem.</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="username" class="block mb-2 text-sm font-bold text-slate-700">Username</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="fas fa-user"></i>
                            </div>
                            <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus autocomplete="username" placeholder="contoh: distributor"
                                class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-pocari-500/20 focus:border-pocari-500 block w-full pl-11 p-3.5 outline-none transition-all" />
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block mb-2 text-sm font-bold text-slate-700">Kata Sandi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="fas fa-lock"></i>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••"
                                class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-pocari-500/20 focus:border-pocari-500 block w-full pl-11 pr-11 p-3.5 outline-none transition-all" />

                            <button type="button" id="togglePassword" aria-label="Tampilkan atau sembunyikan kata sandi"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-pocari-600 transition-colors">
                                <i class="fas fa-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                        <p class="mt-2 text-xs text-slate-400">Lupa kata sandi? Hubungi administrator untuk mereset akun Anda.</p>
                    </div>

                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" value="1" class="w-4 h-4 text-pocari-600 bg-slate-50 border-slate-300 rounded focus:ring-pocari-500 focus:ring-2 cursor-pointer">
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