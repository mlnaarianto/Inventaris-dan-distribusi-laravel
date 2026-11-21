<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @isset($title){{ $title }} | @endisset{{ config('app.name', 'Pocari System') }}
    </title>

    <link rel="icon" type="image/jpeg" href="{{ asset('assets/123.jpg') }}">

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />

    {{-- Anti-flash: set tema SEBELUM render --}}
    <script>
        if (localStorage.theme === 'dark' ||
            (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>

{{-- State sidebarOpen: true di desktop (>= 1024px), false di mobile --}}
<body class="font-sans antialiased bg-gray-50 dark:bg-slate-950 text-gray-900 dark:text-slate-100 transition-colors duration-300" x-data="{ sidebarOpen: window.innerWidth >= 1024 }">

    @include('layouts.header')

    @include('layouts.sidebar')

    {{-- Wrapper Utama: margin kiri 64 (16rem) HANYA saat sidebar terbuka di DESKTOP --}}
    <div class="p-4 pt-6 mt-16 flex flex-col min-h-[calc(100vh-4rem)] transition-all duration-300 ease-in-out"
         :class="sidebarOpen ? 'lg:ml-64' : 'ml-0'">

        <main class="flex-grow">

            <div class="w-full max-w-7xl mx-auto">

                @if(isset($header))
                <div class="mb-6">
                    <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-4 shadow-sm transition-colors">
                        <h1 class="text-xl font-semibold text-slate-900 dark:text-white">{{ $header }}</h1>
                    </div>
                </div>
                @endif

                {{ $slot }}

            </div>

        </main>

        @include('layouts.footer')

    </div>

    <script>
        // === Dark mode toggle ===
        (function () {
            const toggle = document.getElementById('theme-toggle');
            const icon   = document.getElementById('theme-toggle-icon');
            if (!toggle || !icon) return;

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

        // Konfirmasi: tambahkan data-confirm="Pesan..." pada <form>
        document.addEventListener('submit', function (e) {
            const form = e.target;
            const pesan = form.dataset.confirm;
            if (!pesan || form.dataset.confirmed) return;

            e.preventDefault();
            Swal.fire({
                title: 'Yakin?',
                text: pesan,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.dataset.confirmed = '1';
                    form.submit();
                }
            });
        }, true);
    </script>

</body>

</html>