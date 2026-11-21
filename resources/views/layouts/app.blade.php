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
    <!-- Fallback for when Vite dev server isn't running: use compiled CSS from public/css/app.css -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-900">

    @include('layouts.header')

    @include('layouts.sidebar')

    <div class="p-4 pt-6 sm:ml-64 mt-16 flex flex-col min-h-[calc(100vh-4rem)]">

        <main class="flex-grow">
            @if(isset($header))
            <div class="mb-6 max-w-7xl">
                <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
                    <h1 class="text-xl font-semibold text-slate-900">{{ $header }}</h1>
                </div>
            </div>
            @endif

            {{ $slot }}
        </main>

        @include('layouts.footer')

    </div>

    <script>
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