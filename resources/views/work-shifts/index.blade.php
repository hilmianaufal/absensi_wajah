<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-cyan-100 p-4 lg:p-8">
        <div class="max-w-7xl mx-auto">

            @if (session('success'))
                <div class="mb-6 rounded-2xl bg-green-100 text-green-700 px-5 py-4 font-black shadow">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <div class="rounded-[2.5rem] bg-white/80 backdrop-blur-2xl shadow-2xl border border-white p-6 lg:p-10 mb-8 relative overflow-hidden">
                <div class="absolute -top-20 -right-20 w-72 h-72 bg-cyan-300/30 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-blue-300/30 rounded-full blur-3xl"></div>

                <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-50 text-blue-600 font-black text-sm mb-4">
                            🕒 Manajemen Shift
                        </div>

                        <h1 class="text-4xl lg:text-6xl font-black text-slate-900">
                            Jadwal Kerja
                        </h1>

                        <p class="text-slate-500 mt-4">
                            Atur jam masuk, jam pulang, dan toleransi keterlambatan karyawan.
                        </p>
                    </div>

                    <a href="{{ route('work-shifts.create') }}"
                       class="inline-flex items-center justify-center gap-2 px-6 py-4 rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-400 text-white font-black shadow-xl hover:scale-105 transition">
                        ➕ Tambah Shift
                    </a>
                </div>
            </div>

            <div class="rounded-[2.5rem] bg-white/90 backdrop-blur-2xl shadow-xl border border-white overflow-hidden">
                <div class="p-6 border-b border-slate-100">
                    <h2 class="text-2xl font-black text-slate-900">Daftar Shift</h2>
                    <p class="text-slate-400 mt-1">Semua jadwal kerja yang tersedia.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 p-6">
                    @forelse ($workShifts as $shift)
                        <div class="rounded-[2rem] bg-gradient-to-br from-white to-blue-50 border border-white shadow-xl p-6 hover:-translate-y-2 transition duration-300">
                            <div class="flex items-start justify-between gap-4">
                                <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="9"/>
                                        <path d="M12 7v5l3 2"/>
                                    </svg>
                                </div>

                                @if ($shift->status === 'active')
                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-600 text-xs font-black">Aktif</span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-600 text-xs font-black">Nonaktif</span>
                                @endif
                            </div>

                            <h3 class="mt-5 text-2xl font-black text-slate-900">
                                {{ $shift->name }}
                            </h3>

                            <div class="mt-5 grid grid-cols-2 gap-3">
                                <div class="rounded-2xl bg-white p-4 shadow-sm">
                                    <p class="text-xs text-slate-400 font-bold">Masuk</p>
                                    <p class="text-lg font-black text-blue-600">{{ \Carbon\Carbon::parse($shift->start_time)->format('H:i') }}</p>
                                </div>

                                <div class="rounded-2xl bg-white p-4 shadow-sm">
                                    <p class="text-xs text-slate-400 font-bold">Pulang</p>
                                    <p class="text-lg font-black text-cyan-600">{{ \Carbon\Carbon::parse($shift->end_time)->format('H:i') }}</p>
                                </div>
                            </div>

                            <div class="mt-4 rounded-2xl bg-yellow-50 p-4">
                                <p class="text-xs text-yellow-600 font-bold">Toleransi Terlambat</p>
                                <p class="font-black text-slate-800">{{ $shift->late_tolerance }} menit</p>
                            </div>

                            <div class="mt-5 flex gap-2">
                                <a href="{{ route('work-shifts.edit', $shift) }}"
                                   class="flex-1 text-center px-4 py-3 rounded-2xl bg-blue-50 text-blue-600 font-black hover:bg-blue-100 transition">
                                    Edit
                                </a>

                                <form action="{{ route('work-shifts.destroy', $shift) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus shift ini?')"
                                      class="flex-1">
                                    @csrf
                                    @method('DELETE')

                                    <button class="w-full px-4 py-3 rounded-2xl bg-red-50 text-red-600 font-black hover:bg-red-100 transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-20 text-center">
                            <div class="text-6xl mb-4">🕒</div>
                            <h3 class="text-2xl font-black text-slate-800">Belum ada shift</h3>
                            <p class="text-slate-400 mt-2">Tambahkan jadwal kerja pertama.</p>
                        </div>
                    @endforelse
                </div>

                <div class="p-6">
                    {{ $workShifts->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>