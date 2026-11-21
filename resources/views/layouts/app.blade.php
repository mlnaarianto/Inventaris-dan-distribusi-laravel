<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Pocari Distribusi') }}</title>

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

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

</body>

</html>