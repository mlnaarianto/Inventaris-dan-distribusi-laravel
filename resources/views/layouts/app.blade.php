<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Pocari Distribusi') }}</title>

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">

    @include('layouts.header')

    @include('layouts.sidebar')

    <div class="p-4 sm:ml-64 mt-14 flex flex-col min-h-[calc(100vh-3.5rem)]">

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
