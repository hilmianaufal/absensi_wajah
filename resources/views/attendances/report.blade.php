<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-cyan-100 p-4 lg:p-8">
        <div class="max-w-7xl mx-auto">

            {{-- HERO --}}
            <div class="rounded-[2.5rem] bg-white/80 backdrop-blur-2xl shadow-2xl border border-white p-6 lg:p-10 mb-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <div class="inline-flex px-4 py-2 rounded-full bg-blue-50 text-blue-600 font-black text-sm mb-4">
                            📊 Laporan Absensi
                        </div>

                        <h1 class="text-4xl lg:text-6xl font-black text-slate-900">
                            Rekap Kehadiran
                        </h1>

                        <p class="text-slate-500 mt-4">
                            Filter dan pantau data absensi karyawan.
                        </p>
                    </div>

                    <a href="{{ route('attendances.index') }}"
                       class="px-6 py-4 rounded-2xl bg-slate-900 text-white font-black shadow-xl text-center">
                        Data Absensi
                    </a>
                </div>
            </div>

            {{-- SUMMARY --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-5 mb-8">
                <div class="rounded-[2rem] bg-white/90 shadow-xl border border-white p-6">
                    <p class="text-slate-400 font-bold">Hadir</p>
                    <h2 class="text-4xl font-black text-green-600 mt-2">{{ $summary['present'] }}</h2>
                </div>

                <div class="rounded-[2rem] bg-white/90 shadow-xl border border-white p-6">
                    <p class="text-slate-400 font-bold">Terlambat</p>
                    <h2 class="text-4xl font-black text-yellow-600 mt-2">{{ $summary['late'] }}</h2>
                </div>

                <div class="rounded-[2rem] bg-white/90 shadow-xl border border-white p-6">
                    <p class="text-slate-400 font-bold">Izin</p>
                    <h2 class="text-4xl font-black text-blue-600 mt-2">{{ $summary['leave'] }}</h2>
                </div>

                <div class="rounded-[2rem] bg-white/90 shadow-xl border border-white p-6">
                    <p class="text-slate-400 font-bold">Sakit</p>
                    <h2 class="text-4xl font-black text-purple-600 mt-2">{{ $summary['sick'] }}</h2>
                </div>

                <div class="rounded-[2rem] bg-white/90 shadow-xl border border-white p-6">
                    <p class="text-slate-400 font-bold">Alpha</p>
                    <h2 class="text-4xl font-black text-red-600 mt-2">{{ $summary['absent'] }}</h2>
                </div>
            </div>

            {{-- FILTER --}}
            <div class="rounded-[2.5rem] bg-white/90 shadow-xl border border-white p-6 lg:p-8 mb-8">
                <form method="GET" action="{{ route('attendance-reports.index') }}"
                      class="grid grid-cols-1 md:grid-cols-4 gap-5">

                    <div>
                        <label class="font-black text-slate-700 mb-2 block">Tanggal Mulai</label>
                        <input type="date"
                               name="start_date"
                               value="{{ request('start_date') }}"
                               class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 focus:border-blue-400 focus:ring-blue-400">
                    </div>

                    <div>
                        <label class="font-black text-slate-700 mb-2 block">Tanggal Akhir</label>
                        <input type="date"
                               name="end_date"
                               value="{{ request('end_date') }}"
                               class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 focus:border-blue-400 focus:ring-blue-400">
                    </div>

                    <div>
                        <label class="font-black text-slate-700 mb-2 block">Status</label>
                        <select name="status"
                                class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 focus:border-blue-400 focus:ring-blue-400">
                            <option value="">Semua Status</option>
                            <option value="present" @selected(request('status') === 'present')>Hadir</option>
                            <option value="late" @selected(request('status') === 'late')>Terlambat</option>
                            <option value="leave" @selected(request('status') === 'leave')>Izin</option>
                            <option value="sick" @selected(request('status') === 'sick')>Sakit</option>
                            <option value="absent" @selected(request('status') === 'absent')>Alpha</option>
                        </select>
                    </div>

                    <div class="flex items-end gap-3">
                        <button class="flex-1 px-6 py-4 rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-400 text-white font-black shadow-xl">
                            Filter
                        </button>
                        <a href="{{ route('attendance-reports.export', request()->query()) }}"
                        class="px-6 py-4 rounded-2xl bg-gradient-to-r from-green-500 to-emerald-400 text-white font-black shadow-xl text-center">
                            CSV
                        </a>
                        <a href="{{ route('attendance-reports.export-pdf', request()->query()) }}"
                            class="px-6 py-4 rounded-2xl bg-gradient-to-r from-red-600 to-orange-400 text-white font-black shadow-xl text-center">
                                PDF
                            </a>
                        <a href="{{ route('attendance-reports.index') }}"
                           class="px-6 py-4 rounded-2xl bg-slate-100 text-slate-600 font-black">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            {{-- TABLE --}}
            <div class="rounded-[2.5rem] bg-white/90 shadow-xl border border-white overflow-hidden">
                <div class="p-6 border-b border-slate-100">
                    <h2 class="text-2xl font-black text-slate-900">
                        Detail Laporan
                    </h2>
                    <p class="text-slate-400 mt-1">
                        Data absensi sesuai filter.
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 text-slate-500 text-sm">
                            <tr>
                                <th class="px-6 py-4 text-left">Karyawan</th>
                                <th class="px-6 py-4 text-left">Tanggal</th>
                                <th class="px-6 py-4 text-left">Masuk</th>
                                <th class="px-6 py-4 text-left">Pulang</th>
                                <th class="px-6 py-4 text-left">Terlambat</th>
                                <th class="px-6 py-4 text-left">Status</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse ($attendances as $attendance)
                                <tr class="hover:bg-blue-50/50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $attendance->employee?->photo ? asset($attendance->employee->photo) : 'https://ui-avatars.com/api/?name='.urlencode($attendance->employee?->name ?? 'Employee').'&background=0ea5e9&color=fff' }}"
                                                 class="w-12 h-12 rounded-2xl object-cover shadow border-2 border-white">

                                            <div>
                                                <p class="font-black text-slate-800">
                                                    {{ $attendance->employee?->name ?? '-' }}
                                                </p>
                                                <p class="text-sm text-slate-400">
                                                    {{ $attendance->employee?->employee_code ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 font-bold text-slate-600">
                                        {{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}
                                    </td>

                                    <td class="px-6 py-4 text-blue-600 font-black">
                                        {{ $attendance->check_in ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-cyan-600 font-black">
                                        {{ $attendance->check_out ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $attendance->late_minutes }} menit
                                    </td>

                                    <td class="px-6 py-4">
                                        @if ($attendance->status === 'present')
                                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-600 text-xs font-black">Hadir</span>
                                        @elseif ($attendance->status === 'late')
                                            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-600 text-xs font-black">Terlambat</span>
                                        @elseif ($attendance->status === 'sick')
                                            <span class="px-3 py-1 rounded-full bg-purple-100 text-purple-600 text-xs font-black">Sakit</span>
                                        @elseif ($attendance->status === 'leave')
                                            <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-600 text-xs font-black">Izin</span>
                                        @else
                                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-600 text-xs font-black">Alpha</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-20 text-center">
                                        <div class="text-6xl mb-4">📊</div>
                                        <h3 class="text-2xl font-black text-slate-800">
                                            Data tidak ditemukan
                                        </h3>
                                        <p class="text-slate-400 mt-2">
                                            Coba ubah filter laporan.
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-6">
                    {{ $attendances->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>