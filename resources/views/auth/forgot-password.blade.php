<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Sandi | OtsukaHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Poppins', 'sans-serif'] }, colors: { pocari: { 50: '#eff6ff', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8' } } } }
        }
    </script>
</head>
<body class="font-sans antialiased text-slate-800 bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl shadow-slate-200/50 p-8 sm:p-10 border border-slate-100 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-2 bg-pocari-600"></div>

        <div class="flex justify-center mb-6">
            <div class="w-14 h-14 bg-pocari-50 rounded-2xl flex items-center justify-center text-pocari-600 text-2xl">
                <i class="fas fa-unlock-keyhole"></i>
            </div>
        </div>

        <h2 class="text-2xl font-extrabold text-center text-slate-800 mb-2">Lupa Kata Sandi?</h2>
        <p class="text-sm text-center text-slate-500 mb-8 leading-relaxed">
            Tidak masalah. Masukkan alamat email Anda yang terdaftar pada sistem, dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.
        </p>

        @if (session('status'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-sm font-semibold text-emerald-600 text-center">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf
            <div>
                <label for="email" class="block mb-2 text-sm font-bold text-slate-700">Alamat Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-pocari-500/20 focus:border-pocari-500 block w-full pl-11 p-3.5 outline-none transition-all" />
                </div>
                @error('email') <span class="text-xs font-bold text-red-500 mt-2 block">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="w-full flex justify-center items-center gap-2 py-3.5 px-4 rounded-xl shadow-lg shadow-pocari-500/30 text-sm font-bold text-white bg-pocari-600 hover:bg-pocari-700 focus:outline-none transition-all hover:-translate-y-0.5">
                Kirim Tautan Reset <i class="fas fa-paper-plane"></i>
            </button>

            <div class="text-center mt-6">
                <a href="{{ route('login') }}" class="text-sm font-bold text-slate-400 hover:text-pocari-600 transition-colors">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali ke Login
                </a>
            </div>
        </form>
    </div>

</body>
</html>
