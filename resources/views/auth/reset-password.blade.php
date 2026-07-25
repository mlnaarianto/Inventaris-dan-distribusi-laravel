<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Atur Ulang Sandi | OtsukaHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Poppins', 'sans-serif'] }, colors: { pocari: { 50: '#eff6ff', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8' } } } } }
    </script>
</head>
<body class="font-sans antialiased text-slate-800 bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl shadow-slate-200/50 p-8 sm:p-10 border border-slate-100 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-2 bg-pocari-600"></div>

        <div class="flex justify-center mb-6">
            <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500 text-2xl">
                <i class="fas fa-shield-check"></i>
            </div>
        </div>

        <h2 class="text-2xl font-extrabold text-center text-slate-800 mb-8">Buat Sandi Baru</h2>

        <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div>
                <label for="email" class="block mb-2 text-sm font-bold text-slate-700">Email Validasi</label>
                <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required readonly
                    class="bg-slate-100 border border-slate-200 text-slate-500 font-medium text-sm rounded-xl block w-full p-3.5 outline-none cursor-not-allowed" />
                @error('email') <span class="text-xs font-bold text-red-500 mt-2 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="password" class="block mb-2 text-sm font-bold text-slate-700">Kata Sandi Baru</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400"><i class="fas fa-lock"></i></div>
                    <input id="password" type="password" name="password" required autofocus
                        class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-pocari-500/20 focus:border-pocari-500 block w-full pl-11 p-3.5 outline-none" />
                </div>
                @error('password') <span class="text-xs font-bold text-red-500 mt-2 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block mb-2 text-sm font-bold text-slate-700">Ulangi Sandi Baru</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400"><i class="fas fa-check-circle"></i></div>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-pocari-500/20 focus:border-pocari-500 block w-full pl-11 p-3.5 outline-none" />
                </div>
                @error('password_confirmation') <span class="text-xs font-bold text-red-500 mt-2 block">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="w-full flex justify-center items-center py-3.5 px-4 rounded-xl shadow-lg shadow-pocari-500/30 text-sm font-bold text-white bg-pocari-600 hover:bg-pocari-700 transition-all hover:-translate-y-0.5 mt-4">
                Simpan Kata Sandi
            </button>
        </form>
    </div>

</body>
</html>
