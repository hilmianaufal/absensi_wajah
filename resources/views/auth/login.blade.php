<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FaceAttend AI</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased">

<div class="min-h-screen bg-gradient-to-br from-sky-50 via-white to-cyan-100 flex items-center justify-center p-4 relative overflow-hidden">

    <div class="absolute -top-40 -right-40 w-[500px] h-[500px] bg-cyan-300/30 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-40 -left-40 w-[500px] h-[500px] bg-blue-300/30 rounded-full blur-3xl"></div>

    <div class="w-full max-w-7xl grid grid-cols-1 lg:grid-cols-2 gap-8 relative z-10">

        {{-- LEFT --}}
        <div class="hidden lg:flex rounded-[2.8rem] bg-slate-950 text-white p-12 shadow-[0_40px_120px_rgba(15,23,42,0.45)] overflow-hidden relative">

            <div class="absolute -top-24 -right-24 w-80 h-80 bg-cyan-400/30 rounded-full blur-3xl"></div>

            <div class="relative z-10 flex flex-col justify-between w-full">

                <div>
                    <div class="w-24 h-24 rounded-[2rem] bg-gradient-to-br from-blue-600 to-cyan-400 flex items-center justify-center text-5xl shadow-2xl">
                        👁️
                    </div>

                    <h1 class="mt-10 text-6xl font-black leading-tight">
                        AI Smart <br>
                        Attendance Restoran Hubaso
                    </h1>

                    <p class="mt-6 text-cyan-100/80 text-xl leading-relaxed max-w-lg">
                        Login ke dashboard untuk mengelola karyawan,
                        scan wajah realtime, laporan premium,
                        shift kerja, dan geolocation kantor.
                    </p>
                </div>

                <div class="rounded-[2rem] bg-white/10 backdrop-blur-xl border border-white/10 p-6 mt-10">
                    <p class="text-cyan-300 font-black text-sm">
                        LIVE SYSTEM
                    </p>

                    <div class="mt-5 space-y-4">

                        <div class="flex items-center justify-between">
                            <span class="text-white/70">
                                Face Recognition
                            </span>

                            <span class="font-black text-green-300">
                                Online
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-white/70">
                                Geolocation
                            </span>

                            <span class="font-black text-green-300">
                                Active
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-white/70">
                                Dashboard AI
                            </span>

                            <span class="font-black text-green-300">
                                Ready
                            </span>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        {{-- RIGHT --}}
        <div class="rounded-[2.8rem] bg-white/90 backdrop-blur-2xl border border-white shadow-[0_30px_100px_rgba(15,23,42,0.12)] p-8 lg:p-12">

            <div class="text-center mb-10">

                <a href="/" class="inline-flex items-center justify-center">

                    <div class="w-20 h-20 rounded-[2rem] bg-gradient-to-br from-blue-600 to-cyan-400 text-white flex items-center justify-center text-4xl shadow-2xl">
                        👁️
                    </div>

                </a>

                <h2 class="mt-8 text-5xl font-black text-slate-950">
                    Selamat Datang
                </h2>

                <p class="mt-3 text-slate-400 font-bold text-lg">
                    Masuk ke panel administrator
                </p>

            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST"
                  action="{{ route('login') }}"
                  class="space-y-6">

                @csrf

                {{-- EMAIL --}}
                <div>

                    <label class="flex items-center gap-2 text-slate-700 font-black mb-3">
                        📧 Email
                    </label>

                    <input id="email"
                           type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autofocus
                           autocomplete="username"
                           placeholder="admin@email.com"
                           class="w-full rounded-2xl border-slate-200 bg-slate-50 px-6 py-5 text-lg font-bold text-slate-700 focus:bg-white focus:border-blue-400 focus:ring-blue-400">

                    <x-input-error :messages="$errors->get('email')" class="mt-2" />

                </div>

                {{-- PASSWORD --}}
                <div>

                    <label class="flex items-center gap-2 text-slate-700 font-black mb-3">
                        🔒 Password
                    </label>

                    <input id="password"
                           type="password"
                           name="password"
                           required
                           autocomplete="current-password"
                           placeholder="••••••••"
                           class="w-full rounded-2xl border-slate-200 bg-slate-50 px-6 py-5 text-lg font-bold text-slate-700 focus:bg-white focus:border-blue-400 focus:ring-blue-400">

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />

                </div>

                {{-- REMEMBER --}}
                <div class="flex items-center justify-between gap-4">

                    <label class="flex items-center gap-3">

                        <input id="remember_me"
                               type="checkbox"
                               name="remember"
                               class="rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500">

                        <span class="text-sm font-bold text-slate-500">
                            Ingat saya
                        </span>

                    </label>

                    @if (Route::has('password.request'))

                        <a href="{{ route('password.request') }}"
                           class="text-sm font-black text-blue-600 hover:text-blue-800">
                            Lupa password?
                        </a>

                    @endif

                </div>

                {{-- BUTTON --}}
                <button type="submit"
                        class="w-full py-5 rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-400 text-white text-lg font-black shadow-2xl hover:scale-[1.02] transition">

                    Masuk Dashboard

                </button>

            </form>

            <div class="mt-8 rounded-[2rem] bg-gradient-to-br from-blue-50 to-cyan-50 border border-blue-100 p-6">

                <p class="font-black text-slate-800">
                    🔐 Secure Login
                </p>

                <p class="text-sm text-slate-500 mt-2 leading-relaxed">
                    Sistem dilindungi autentikasi administrator untuk mengakses dashboard AI attendance.
                </p>

            </div>

            <p class="mt-10 text-center text-sm text-slate-400 font-bold">
                © {{ date('Y') }} Hubaso FaceAttend AI Smart Attendance
            </p>

        </div>

    </div>

</div>

</body>
</html>