<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-cyan-100 p-4 lg:p-8">
        <div class="max-w-7xl mx-auto">

            <div class="rounded-[2.5rem] bg-white/80 backdrop-blur-2xl shadow-2xl border border-white p-6 lg:p-10 mb-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <div class="inline-flex px-4 py-2 rounded-full bg-blue-50 text-blue-600 font-black text-sm mb-4">
                            🕒 Rekap Absensi
                        </div>

                        <h1 class="text-4xl lg:text-6xl font-black text-slate-900">
                            Data Absensi
                        </h1>

                        <p class="text-slate-500 mt-4">
                            Pantau check-in, check-out, keterlambatan, dan status kehadiran.
                        </p>
                    </div>

                    <a href="{{ route('attendances.create') }}"
                       class="px-6 py-4 rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-400 text-white font-black shadow-xl">
                        + Tambah Absensi
                    </a>
                </div>
            </div>

            <div class="rounded-[2.5rem] bg-white/90 backdrop-blur-2xl shadow-xl border border-white overflow-hidden">
                <div class="p-6 border-b border-slate-100">
                    <h2 class="text-2xl font-black text-slate-900">Daftar Absensi</h2>
                    <p class="text-slate-400 mt-1">Riwayat kehadiran karyawan.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 text-slate-500 text-sm">
                            <tr>
                                <th class="px-6 py-4 text-left">Karyawan</th>
                                <th class="px-6 py-4 text-left">Foto Masuk</th>
                                <th class="px-6 py-4 text-left">Foto Pulang</th>
                                <th class="px-6 py-4 text-left">Tanggal</th>
                                <th class="px-6 py-4 text-left">Masuk</th>
                                <th class="px-6 py-4 text-left">Pulang</th>
                                <th class="px-6 py-4 text-left">Terlambat</th>
                                <th class="px-6 py-4 text-left">Status</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse ($attendances as $attendance)
                                <tr class="hover:bg-blue-50/50 transition">
                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="font-black text-slate-800">
                                                {{ $attendance->employee?->name ?? '-' }}
                                            </p>
                                            <p class="text-sm text-slate-400">
                                                {{ $attendance->employee?->employee_code ?? '-' }}
                                            </p>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        @if ($attendance->check_in_photo)
                                            <img src="{{ asset($attendance->check_in_photo) }}" class="w-16 h-16 rounded-2xl object-cover shadow-xl border-2 border-white">
                                        @else
                                            <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400">-</div>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">
                                        @if ($attendance->check_out_photo)
                                            <img src="{{ asset($attendance->check_out_photo) }}" class="w-16 h-16 rounded-2xl object-cover shadow-xl border-2 border-white">
                                        @else
                                            <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400">-</div>
                                        @endif
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

                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('attendances.edit', $attendance) }}"
                                            class="px-4 py-2 rounded-2xl bg-blue-50 text-blue-600 font-black hover:bg-blue-100 transition">
                                                Edit
                                            </a>

                                            <form action="{{ route('attendances.destroy', $attendance) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus absensi ini?')">
                                                @csrf
                                                @method('DELETE')

                                                <button class="px-4 py-2 rounded-2xl bg-red-50 text-red-600 font-black hover:bg-red-100 transition">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-20 text-center">
                                        <div class="text-6xl mb-4">🕒</div>
                                        <h3 class="text-2xl font-black text-slate-800">Belum ada absensi</h3>
                                        <p class="text-slate-400 mt-2">Data absensi akan muncul di sini.</p>
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