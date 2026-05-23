<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Smart Attendance</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">

<div class="min-h-screen bg-gradient-to-br from-sky-50 via-white to-cyan-100 overflow-hidden">

    {{-- NAVBAR --}}
    <nav class="relative z-50 px-4 lg:px-10 py-6">
        <div class="max-w-7xl mx-auto flex items-center justify-between rounded-[2rem] bg-white/80 backdrop-blur-2xl border border-white shadow-xl px-5 py-4">
            <div class="flex items-center gap-3">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-600 to-cyan-400 text-white flex items-center justify-center shadow-xl text-3xl">
                    👁️
                </div>
                <div>
                    <h1 class="text-xl font-black text-slate-950 leading-none">FaceAttend</h1>
                    <p class="text-xs text-slate-400 font-bold mt-1">AI Smart Attendance</p>
                </div>
            </div>

            <div class="hidden md:flex items-center gap-3">
                <a href="#fitur" class="px-4 py-3 rounded-2xl text-slate-600 font-black hover:bg-blue-50 hover:text-blue-600">
                    Fitur
                </a>
                <a href="#preview" class="px-4 py-3 rounded-2xl text-slate-600 font-black hover:bg-blue-50 hover:text-blue-600">
                    Preview
                </a>
                <a href="{{ route('login') }}" class="px-6 py-3 rounded-2xl bg-slate-950 text-white font-black shadow-xl">
                    Login
                </a>
            </div>
        </div>
    </nav>

    {{-- HERO --}}
    <section class="relative px-4 lg:px-10 pt-10 pb-20">
        <div class="absolute -top-40 -right-40 w-[500px] h-[500px] bg-cyan-300/30 rounded-full blur-3xl"></div>
        <div class="absolute top-40 -left-40 w-[500px] h-[500px] bg-blue-300/30 rounded-full blur-3xl"></div>

        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-center relative z-10">

            <div class="hero-animate">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-50 text-blue-600 font-black text-sm mb-6">
                    🤖 Realtime Face Recognition System
                </div>

                <h1 class="text-5xl lg:text-7xl font-black text-slate-950 tracking-tight leading-tight">
                    Absensi Wajah
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-400">
                        Otomatis
                    </span>
                    Restoran Hubaso
                </h1>

                <p class="mt-6 text-lg text-slate-500 font-medium max-w-xl leading-relaxed">
                    Sistem absensi modern dengan scan wajah realtime, geolocation kantor, shift kerja, laporan PDF premium, dan dashboard AI.
                </p>

                <div class="mt-8 flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('login') }}"
                       class="button-animate magnetic-hover inline-flex items-center justify-center px-8 py-5 rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-400 text-white font-black shadow-2xl hover:scale-105 transition">
                        Mulai Sekarang
                    </a>

                    <a href="#fitur"
                       class="button-animate inline-flex items-center justify-center px-8 py-5 rounded-2xl bg-white text-slate-700 font-black shadow-xl border border-white hover:bg-blue-50 transition">
                        Lihat Fitur
                    </a>
                </div>
            </div>

            {{-- MOCKUP --}}
            <div id="preview" class="card-animate premium-card relative rounded-[2.8rem] bg-slate-950 p-5 shadow-[0_40px_120px_rgba(15,23,42,0.35)]">
                <div class="rounded-[2.2rem] bg-gradient-to-br from-blue-950 via-slate-950 to-cyan-900 p-6 text-white overflow-hidden relative">
                    <div class="absolute -top-20 -right-20 w-60 h-60 bg-cyan-400/30 rounded-full blur-3xl"></div>

                    <div class="flex items-center justify-between relative z-10">
                        <div>
                            <p class="text-cyan-300 font-black text-sm">LIVE SCANNER</p>
                            <h2 class="text-2xl font-black mt-1">AI Face Scan</h2>
                        </div>
                        <div class="px-4 py-2 rounded-full bg-green-400/20 text-green-300 font-black text-sm">
                            Online
                        </div>
                    </div>

                    <div class="relative mt-6 aspect-video rounded-[2rem] bg-black overflow-hidden border border-white/10">
                        <div class="absolute inset-0 bg-gradient-to-br from-slate-800 to-slate-950"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-52 h-52 rounded-full border-[5px] border-cyan-300 shadow-[0_0_80px_rgba(34,211,238,0.9)]"></div>
                        </div>
                        <div class="absolute left-5 top-5 px-4 py-2 rounded-full bg-green-500 text-white font-black text-sm">
                            Budi Santoso - 96%
                        </div>
                        <div class="absolute left-5 right-5 bottom-5 rounded-2xl bg-white/15 backdrop-blur-xl p-4">
                            <p class="font-black">Check-in berhasil</p>
                            <p class="text-cyan-100 text-sm mt-1">08:01 · Dalam radius kantor</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4 mt-6">
                        <div class="rounded-2xl bg-white/10 p-4">
                            <p class="text-xs text-cyan-100">Hadir</p>
                            <h3 class="text-2xl font-black">28</h3>
                        </div>
                        <div class="rounded-2xl bg-white/10 p-4">
                            <p class="text-xs text-cyan-100">Telat</p>
                            <h3 class="text-2xl font-black">3</h3>
                        </div>
                        <div class="rounded-2xl bg-white/10 p-4">
                            <p class="text-xs text-cyan-100">Belum</p>
                            <h3 class="text-2xl font-black">7</h3>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- FEATURES --}}
    <section id="fitur" class="px-4 lg:px-10 pb-20">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <div class="inline-flex px-4 py-2 rounded-full bg-cyan-50 text-cyan-600 font-black text-sm mb-4">
                    Fitur Premium
                </div>
                <h2 class="text-4xl lg:text-5xl font-black text-slate-950">
                    Semua kebutuhan absensi dalam satu sistem 
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @php
                    $features = [
                        ['icon' => '📷', 'title' => 'Realtime Face Recognition', 'desc' => 'Scan wajah otomatis tanpa klik tombol manual.'],
                        ['icon' => '📍', 'title' => 'Geolocation Radius', 'desc' => 'Absensi hanya valid dalam radius kantor.'],
                        ['icon' => '🕒', 'title' => 'Shift Management', 'desc' => 'Atur jam masuk, pulang, toleransi telat.'],
                        ['icon' => '📊', 'title' => 'Dashboard Realtime', 'desc' => 'Monitoring hadir, telat, belum hadir, dan pulang.'],
                        ['icon' => '🧾', 'title' => 'PDF Premium Report', 'desc' => 'Export laporan dengan logo, foto, dan tanda tangan.'],
                        ['icon' => '🔊', 'title' => 'Voice AI', 'desc' => 'Suara otomatis saat check-in dan check-out berhasil.'],
                    ];
                @endphp

                @foreach ($features as $feature)
                    <div class="card-animate premium-card rounded-[2rem] bg-white/90 border border-white shadow-xl p-7">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-600 to-cyan-400 text-white flex items-center justify-center text-3xl shadow-xl">
                            {{ $feature['icon'] }}
                        </div>
                        <h3 class="mt-6 text-2xl font-black text-slate-950">
                            {{ $feature['title'] }}
                        </h3>
                        <p class="mt-3 text-slate-500 font-medium leading-relaxed">
                            {{ $feature['desc'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="px-4 lg:px-10 pb-10">
        <div class="max-w-7xl mx-auto rounded-[2.5rem] bg-gradient-to-r from-blue-600 to-cyan-400 p-8 lg:p-12 text-white shadow-2xl text-center">
            <h2 class="text-4xl lg:text-5xl font-black">
                Siap gunakan absensi AI?
            </h2>
            <p class="mt-4 text-blue-50 font-medium">
                Masuk sebagai administrator dan mulai kelola absensi karyawan.
            </p>

            <a href="{{ route('login') }}"
               class="mt-8 inline-flex px-8 py-5 rounded-2xl bg-white text-blue-600 font-black shadow-xl">
                Login Administrator
            </a>
        </div>
    </section>

    <footer class="px-4 lg:px-10 py-8 text-center text-slate-400 font-bold">
        © {{ date('Y') }} HUBASO FaceAttend AI Smart Attendance System
    </footer>

</div>

</body>
</html>