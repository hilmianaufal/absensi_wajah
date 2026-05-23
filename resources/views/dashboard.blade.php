<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-sky-50 via-white to-cyan-100 p-4 lg:p-8">
        <div class="max-w-7xl mx-auto">

            {{-- HERO --}}
            <div class="hero-animate dashboard-card rounded-[2.5rem] bg-white/80 backdrop-blur-2xl shadow-2xl border border-white p-6 lg:p-10 mb-8 overflow-hidden relative">
                <div class="absolute -top-24 -right-24 w-80 h-80 bg-cyan-300/30 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-blue-300/30 rounded-full blur-3xl"></div>

                <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-50 text-blue-600 font-black text-sm mb-4">
                            🤖 AI Smart Attendance
                        </div>

                        <h1 class="text-4xl lg:text-6xl font-black text-slate-950 tracking-tight">
                            Dashboard Realtime
                        </h1>

                        <p class="text-slate-500 mt-4 max-w-xl font-medium">
                            Pantau karyawan, absensi realtime, scan wajah AI, shift kerja, dan laporan dalam satu tampilan premium.
                        </p>
                    </div>

                    <a href="{{ route('face-scan') }}"
                       class="inline-flex items-center justify-center gap-3 px-7 py-5 rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-400 text-white font-black shadow-xl hover:scale-105 transition">
                        📷 Mulai Scan Wajah
                    </a>
                </div>
            </div>

            {{-- STATS --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

                <div class="dashboard-card rounded-[2rem] bg-white/90 shadow-xl border border-white p-6">
                    <div class="flex items-center justify-between">
                        <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-3xl">👥</div>
                        <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-xs font-black">TOTAL</span>
                    </div>
                    <p class="text-slate-400 font-bold mt-6">Total Karyawan</p>
                    <h2 class="text-4xl font-black text-slate-950 mt-2" id="totalEmployees">
                        {{ \App\Models\Employee::count() }}
                    </h2>
                </div>

                <div class="dashboard-card rounded-[2rem] bg-white/90 shadow-xl border border-white p-6">
                    <div class="flex items-center justify-between">
                        <div class="w-14 h-14 rounded-2xl bg-green-100 text-green-600 flex items-center justify-center text-3xl">✅</div>
                        <span class="px-3 py-1 rounded-full bg-green-50 text-green-600 text-xs font-black">HARI INI</span>
                    </div>
                    <p class="text-slate-400 font-bold mt-6">Hadir</p>
                    <h2 class="text-4xl font-black text-green-600 mt-2" id="presentToday">
                        {{ \App\Models\Attendance::whereDate('date', today())->whereIn('status', ['present','late'])->count() }}
                    </h2>
                </div>

                <div class="dashboard-card rounded-[2rem] bg-white/90 shadow-xl border border-white p-6">
                    <div class="flex items-center justify-between">
                        <div class="w-14 h-14 rounded-2xl bg-yellow-100 text-yellow-600 flex items-center justify-center text-3xl">⏰</div>
                        <span class="px-3 py-1 rounded-full bg-yellow-50 text-yellow-600 text-xs font-black">TELAT</span>
                    </div>
                    <p class="text-slate-400 font-bold mt-6">Terlambat</p>
                    <h2 class="text-4xl font-black text-yellow-600 mt-2" id="lateToday">
                        {{ \App\Models\Attendance::whereDate('date', today())->where('status', 'late')->count() }}
                    </h2>
                </div>

                <div class="dashboard-card rounded-[2rem] bg-white/90 shadow-xl border border-white p-6">
                    <div class="flex items-center justify-between">
                        <div class="w-14 h-14 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center text-3xl">🚫</div>
                        <span class="px-3 py-1 rounded-full bg-red-50 text-red-600 text-xs font-black">BELUM</span>
                    </div>
                    <p class="text-slate-400 font-bold mt-6">Belum Hadir</p>
                    <h2 class="text-4xl font-black text-red-600 mt-2" id="notPresent">
                        {{ max(\App\Models\Employee::count() - \App\Models\Attendance::whereDate('date', today())->whereIn('status', ['present','late'])->count(), 0) }}
                    </h2>
                </div>

            </div>

            {{-- MAIN GRID --}}
            <div class="card-animate premium-card grid grid-cols-1 xl:grid-cols-3 gap-8">

                {{-- QUICK MENU --}}
                <div class="xl:col-span-2 rounded-[2.5rem] bg-white/90 shadow-xl border border-white p-6 lg:p-8">
                    <div class="mb-7">
                        <h2 class="text-2xl font-black text-slate-950">Menu Cepat</h2>
                        <p class="text-slate-400 font-medium mt-1">Akses fitur utama aplikasi.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <a href="{{ route('employees.index') }}" class="group rounded-[2rem] bg-blue-50 p-6 hover:bg-gradient-to-r hover:from-blue-600 hover:to-cyan-400 transition">
                            <div class="w-14 h-14 rounded-2xl bg-white text-blue-600 flex items-center justify-center shadow-lg text-3xl">👥</div>
                            <h3 class="mt-5 text-xl font-black text-slate-900 group-hover:text-white">Data Karyawan</h3>
                            <p class="text-slate-500 group-hover:text-white/80 mt-2 text-sm font-medium">Kelola profil, foto, shift, dan registrasi wajah.</p>
                        </a>

                        <a href="{{ route('face-scan') }}" class="group rounded-[2rem] bg-purple-50 p-6 hover:bg-gradient-to-r hover:from-purple-600 hover:to-fuchsia-500 transition">
                            <div class="w-14 h-14 rounded-2xl bg-white text-purple-600 flex items-center justify-center shadow-lg text-3xl">📷</div>
                            <h3 class="mt-5 text-xl font-black text-slate-900 group-hover:text-white">Scan Wajah</h3>
                            <p class="text-slate-500 group-hover:text-white/80 mt-2 text-sm font-medium">Absensi otomatis realtime berbasis AI.</p>
                        </a>

                        <a href="{{ route('work-shifts.index') }}" class="group rounded-[2rem] bg-cyan-50 p-6 hover:bg-gradient-to-r hover:from-cyan-500 hover:to-blue-500 transition">
                            <div class="w-14 h-14 rounded-2xl bg-white text-cyan-600 flex items-center justify-center shadow-lg text-3xl">🕒</div>
                            <h3 class="mt-5 text-xl font-black text-slate-900 group-hover:text-white">Jadwal Shift</h3>
                            <p class="text-slate-500 group-hover:text-white/80 mt-2 text-sm font-medium">Atur jam masuk, pulang, dan toleransi telat.</p>
                        </a>

                        <a href="{{ route('attendance-reports.index') }}" class="group rounded-[2rem] bg-green-50 p-6 hover:bg-gradient-to-r hover:from-green-500 hover:to-emerald-400 transition">
                            <div class="w-14 h-14 rounded-2xl bg-white text-green-600 flex items-center justify-center shadow-lg text-3xl">📊</div>
                            <h3 class="mt-5 text-xl font-black text-slate-900 group-hover:text-white">Laporan</h3>
                            <p class="text-slate-500 group-hover:text-white/80 mt-2 text-sm font-medium">Filter, rekap, dan export laporan absensi.</p>
                        </a>
                    </div>
                </div>

                {{-- RECENT ACTIVITY --}}
                <div class="rounded-[2.5rem] bg-slate-950 text-white shadow-2xl p-6 lg:p-8">
                    <div class="mb-7">
                        <h2 class="text-2xl font-black">Aktivitas Hari Ini</h2>
                        <p class="text-slate-400 font-medium mt-1">Update otomatis setiap 5 detik.</p>
                    </div>

                    <div id="activityList" class="space-y-4">
                        @forelse (\App\Models\Attendance::with('employee')->whereDate('date', today())->latest()->take(8)->get() as $attendance)
                            <div class="flex items-center gap-4 rounded-2xl bg-white/10 p-4">
                                <img src="{{ $attendance->employee?->photo ? asset($attendance->employee->photo) : 'https://ui-avatars.com/api/?name='.urlencode($attendance->employee?->name ?? 'Employee').'&background=0ea5e9&color=fff' }}"
                                     class="w-12 h-12 rounded-2xl object-cover">

                                <div class="flex-1">
                                    <p class="font-black">{{ $attendance->employee?->name ?? '-' }}</p>
                                    <p class="text-sm text-slate-400">
                                        Masuk: {{ $attendance->check_in ?? '-' }} · Pulang: {{ $attendance->check_out ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-2xl bg-white/10 p-6 text-center">
                                <div class="text-4xl mb-3">🕒</div>
                                <p class="font-black">Belum ada aktivitas</p>
                                <p class="text-slate-400 text-sm mt-1">Data absensi hari ini akan muncul di sini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script>
        async function loadDashboardRealtime() {
            try {
                const response = await fetch('{{ route('dashboard.realtime-data') }}');
                const data = await response.json();

                document.getElementById('totalEmployees').innerText = data.totalEmployees;
                document.getElementById('presentToday').innerText = data.presentToday;
                document.getElementById('lateToday').innerText = data.lateToday;
                document.getElementById('notPresent').innerText = data.notPresent;

                const activityList = document.getElementById('activityList');

                if (data.activities.length === 0) {
                    activityList.innerHTML = `
                        <div class="rounded-2xl bg-white/10 p-6 text-center">
                            <div class="text-4xl mb-3">🕒</div>
                            <p class="font-black">Belum ada aktivitas</p>
                            <p class="text-slate-400 text-sm mt-1">Data absensi hari ini akan muncul di sini.</p>
                        </div>
                    `;
                    return;
                }

                activityList.innerHTML = data.activities.map(item => {
                    const photo = item.photo
                        ? item.photo
                        : `https://ui-avatars.com/api/?name=${encodeURIComponent(item.name)}&background=0ea5e9&color=fff`;

                    return `
                        <div class="flex items-center gap-4 rounded-2xl bg-white/10 p-4">
                            <img src="${photo}" class="w-12 h-12 rounded-2xl object-cover">

                            <div class="flex-1">
                                <p class="font-black">${item.name}</p>
                                <p class="text-sm text-slate-400">
                                    Masuk: ${item.check_in ?? '-'} · Pulang: ${item.check_out ?? '-'}
                                </p>
                            </div>
                        </div>
                    `;
                }).join('');

            } catch (error) {
                console.error('Realtime dashboard error:', error);
            }
        }

        loadDashboardRealtime();
        setInterval(loadDashboardRealtime, 5000);
    </script>
</x-app-layout>