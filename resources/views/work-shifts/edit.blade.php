<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-cyan-100 p-4 lg:p-8">
        <div class="max-w-6xl mx-auto">

            <div class="rounded-[2.5rem] bg-white/80 backdrop-blur-2xl shadow-2xl border border-white p-6 lg:p-10 mb-8 relative overflow-hidden">
                <div class="absolute -top-20 -right-20 w-72 h-72 bg-cyan-300/30 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-blue-300/30 rounded-full blur-3xl"></div>

                <div class="relative z-10">
                    <a href="{{ route('work-shifts.index') }}" class="inline-flex text-blue-600 font-black mb-5">
                        ← Kembali
                    </a>

                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-orange-50 text-orange-600 font-black text-sm mb-4">
                        ✏️ Edit Jadwal Kerja
                    </div>

                    <h1 class="text-4xl lg:text-6xl font-black text-slate-900">
                        Edit Shift
                    </h1>

                    <p class="text-slate-500 mt-4 max-w-xl">
                        Perbarui jam kerja dan toleransi keterlambatan.
                    </p>
                </div>
            </div>

            <form method="POST"
                  action="{{ route('work-shifts.update', $workShift) }}"
                  class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                @csrf
                @method('PUT')

                <div class="xl:col-span-1">
                    <div class="rounded-[2.5rem] bg-white/90 backdrop-blur-2xl shadow-xl border border-white p-8 xl:sticky xl:top-8 text-center">

                        <div class="w-20 h-20 rounded-[2rem] bg-gradient-to-br from-orange-500 to-yellow-400 text-white flex items-center justify-center shadow-2xl mx-auto">
                            🕒
                        </div>

                        <h3 class="mt-6 text-2xl font-black text-slate-900">
                            {{ $workShift->name }}
                        </h3>

                        <p class="text-slate-400 mt-2 text-sm">
                            {{ \Carbon\Carbon::parse($workShift->start_time)->format('H:i') }}
                            -
                            {{ \Carbon\Carbon::parse($workShift->end_time)->format('H:i') }}
                        </p>

                        <div class="mt-8 rounded-2xl bg-yellow-50 p-5">
                            <p class="text-xs text-yellow-600 font-black">Toleransi</p>
                            <p class="text-2xl font-black text-slate-900 mt-1">
                                {{ $workShift->late_tolerance }} Menit
                            </p>
                        </div>

                    </div>
                </div>

                <div class="xl:col-span-2">
                    <div class="rounded-[2.5rem] bg-white/90 backdrop-blur-2xl shadow-xl border border-white p-6 lg:p-8">

                        <div class="mb-8">
                            <h2 class="text-2xl font-black text-slate-900">
                                Informasi Shift
                            </h2>
                            <p class="text-slate-400 mt-1">
                                Ubah nama shift, jam masuk, jam pulang, dan status.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div class="md:col-span-2">
                                <label class="font-black text-slate-700 mb-2 block">Nama Shift</label>
                                <input name="name"
                                       value="{{ old('name', $workShift->name) }}"
                                       class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 focus:bg-white focus:border-blue-400 focus:ring-blue-400">
                            </div>

                            <div>
                                <label class="font-black text-slate-700 mb-2 block">Jam Masuk</label>
                                <input type="time"
                                       name="start_time"
                                       value="{{ old('start_time', \Carbon\Carbon::parse($workShift->start_time)->format('H:i')) }}"
                                       class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 focus:bg-white focus:border-blue-400 focus:ring-blue-400">
                            </div>

                            <div>
                                <label class="font-black text-slate-700 mb-2 block">Jam Pulang</label>
                                <input type="time"
                                       name="end_time"
                                       value="{{ old('end_time', \Carbon\Carbon::parse($workShift->end_time)->format('H:i')) }}"
                                       class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 focus:bg-white focus:border-blue-400 focus:ring-blue-400">
                            </div>

                            <div>
                                <label class="font-black text-slate-700 mb-2 block">Toleransi Terlambat</label>
                                <input type="number"
                                       name="late_tolerance"
                                       value="{{ old('late_tolerance', $workShift->late_tolerance) }}"
                                       class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 focus:bg-white focus:border-blue-400 focus:ring-blue-400">
                            </div>

                            <div>
                                <label class="font-black text-slate-700 mb-2 block">Status</label>
                                <select name="status"
                                        class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 focus:bg-white focus:border-blue-400 focus:ring-blue-400">
                                    <option value="active" @selected($workShift->status === 'active')>Aktif</option>
                                    <option value="inactive" @selected($workShift->status === 'inactive')>Nonaktif</option>
                                </select>
                            </div>

                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 pt-10">
                            <button class="px-8 py-4 rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-400 text-white font-black shadow-xl hover:scale-105 transition">
                                Simpan Perubahan
                            </button>

                            <a href="{{ route('work-shifts.index') }}"
                               class="px-8 py-4 rounded-2xl bg-slate-100 text-slate-600 font-black text-center hover:bg-slate-200 transition">
                                Batal
                            </a>
                        </div>

                    </div>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>