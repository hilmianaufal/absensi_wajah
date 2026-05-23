<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-cyan-100 p-4 lg:p-8">
        <div class="max-w-6xl mx-auto">

            {{-- HERO --}}
            <div class="rounded-[2.5rem] bg-white/80 backdrop-blur-2xl shadow-2xl border border-white p-6 lg:p-10 mb-8 relative overflow-hidden">
                <div class="absolute -top-20 -right-20 w-72 h-72 bg-cyan-300/30 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-blue-300/30 rounded-full blur-3xl"></div>

                <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <a href="{{ route('work-shifts.index') }}" class="inline-flex text-blue-600 font-black mb-5">
                            ← Kembali
                        </a>

                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-50 text-blue-600 font-black text-sm mb-4">
                            ➕ Tambah Jadwal Kerja
                        </div>

                        <h1 class="text-4xl lg:text-6xl font-black text-slate-900">
                            Tambah Shift
                        </h1>

                        <p class="text-slate-500 mt-4 max-w-xl">
                            Buat jadwal kerja untuk absensi karyawan dan hitung keterlambatan otomatis.
                        </p>
                    </div>

                    <div class="hidden lg:flex w-28 h-28 rounded-[2rem] bg-gradient-to-br from-blue-600 to-cyan-400 items-center justify-center text-white shadow-2xl">
                        <svg class="w-14 h-14" fill="none" stroke="currentColor" stroke-width="2.3" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M12 7v5l3 2"/>
                        </svg>
                    </div>
                </div>
            </div>

            <form method="POST"
                  action="{{ route('work-shifts.store') }}"
                  class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                @csrf

                {{-- LEFT PREVIEW --}}
                <div class="xl:col-span-1">
                    <div class="rounded-[2.5rem] bg-white/90 backdrop-blur-2xl shadow-xl border border-white p-8 xl:sticky xl:top-8">

                        <div class="w-20 h-20 rounded-[2rem] bg-gradient-to-br from-blue-600 to-cyan-400 text-white flex items-center justify-center shadow-2xl mx-auto">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M12 7v5l3 2"/>
                            </svg>
                        </div>

                        <h3 class="mt-6 text-center text-2xl font-black text-slate-900">
                            Preview Shift
                        </h3>

                        <p class="text-center text-slate-400 mt-2 text-sm">
                            Jadwal ini akan dipakai untuk validasi jam masuk dan pulang.
                        </p>

                        <div class="mt-8 space-y-4">
                            <div class="rounded-2xl bg-blue-50 p-5">
                                <p class="text-xs text-blue-500 font-black">Jam Masuk</p>
                                <p class="text-2xl font-black text-slate-900 mt-1">08:00</p>
                            </div>

                            <div class="rounded-2xl bg-cyan-50 p-5">
                                <p class="text-xs text-cyan-500 font-black">Jam Pulang</p>
                                <p class="text-2xl font-black text-slate-900 mt-1">17:00</p>
                            </div>

                            <div class="rounded-2xl bg-yellow-50 p-5">
                                <p class="text-xs text-yellow-600 font-black">Toleransi</p>
                                <p class="text-2xl font-black text-slate-900 mt-1">15 Menit</p>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- RIGHT FORM --}}
                <div class="xl:col-span-2">
                    <div class="rounded-[2.5rem] bg-white/90 backdrop-blur-2xl shadow-xl border border-white p-6 lg:p-8">

                        <div class="mb-8">
                            <h2 class="text-2xl font-black text-slate-900">
                                Informasi Shift
                            </h2>
                            <p class="text-slate-400 mt-1">
                                Masukkan nama shift, jam masuk, jam pulang, dan toleransi terlambat.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div class="md:col-span-2">
                                <label class="flex items-center gap-2 font-black text-slate-700 mb-2">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="9"/>
                                        <path d="M12 7v5l3 2"/>
                                    </svg>
                                    Nama Shift
                                </label>
                                <input name="name"
                                       value="{{ old('name') }}"
                                       class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 focus:bg-white focus:border-blue-400 focus:ring-blue-400"
                                       placeholder="Shift Pagi">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="flex items-center gap-2 font-black text-slate-700 mb-2">
                                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                                        <path d="M12 2v2"/>
                                        <path d="M12 20v2"/>
                                        <path d="m4.93 4.93 1.41 1.41"/>
                                        <path d="m17.66 17.66 1.41 1.41"/>
                                        <path d="M2 12h2"/>
                                        <path d="M20 12h2"/>
                                        <circle cx="12" cy="12" r="4"/>
                                    </svg>
                                    Jam Masuk
                                </label>
                                <input type="time"
                                       name="start_time"
                                       value="{{ old('start_time') }}"
                                       class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 focus:bg-white focus:border-blue-400 focus:ring-blue-400">
                                @error('start_time')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="flex items-center gap-2 font-black text-slate-700 mb-2">
                                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                                        <path d="M21 12.8A9 9 0 1 1 11.2 3 7 7 0 0 0 21 12.8z"/>
                                    </svg>
                                    Jam Pulang
                                </label>
                                <input type="time"
                                       name="end_time"
                                       value="{{ old('end_time') }}"
                                       class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 focus:bg-white focus:border-blue-400 focus:ring-blue-400">
                                @error('end_time')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="flex items-center gap-2 font-black text-slate-700 mb-2">
                                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                                        <path d="M10 2h4"/>
                                        <path d="M12 14v-4"/>
                                        <circle cx="12" cy="14" r="8"/>
                                    </svg>
                                    Toleransi Terlambat
                                </label>
                                <input type="number"
                                       name="late_tolerance"
                                       value="{{ old('late_tolerance', 15) }}"
                                       class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 focus:bg-white focus:border-blue-400 focus:ring-blue-400"
                                       placeholder="15">
                                @error('late_tolerance')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="flex items-center gap-2 font-black text-slate-700 mb-2">
                                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                                        <path d="M9 12l2 2 4-4"/>
                                        <path d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/>
                                    </svg>
                                    Status
                                </label>
                                <select name="status"
                                        class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 focus:bg-white focus:border-blue-400 focus:ring-blue-400">
                                    <option value="active">Aktif</option>
                                    <option value="inactive">Nonaktif</option>
                                </select>
                            </div>

                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 pt-10">
                            <button class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-400 text-white font-black shadow-xl hover:scale-105 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                                    <path d="M17 21v-8H7v8"/>
                                    <path d="M7 3v5h8"/>
                                </svg>
                                Simpan Shift
                            </button>

                            <a href="{{ route('work-shifts.index') }}"
                               class="inline-flex items-center justify-center px-8 py-4 rounded-2xl bg-slate-100 text-slate-600 font-black hover:bg-slate-200 transition">
                                Batal
                            </a>
                        </div>

                    </div>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>