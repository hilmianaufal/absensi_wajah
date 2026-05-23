<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-cyan-100 p-4 lg:p-8">
        <div class="max-w-6xl mx-auto">

            <div class="rounded-[2.5rem] bg-white/80 backdrop-blur-2xl shadow-2xl border border-white p-6 lg:p-10 mb-8">
                <a href="{{ route('attendances.index') }}" class="inline-flex text-blue-600 font-black mb-5">
                    ← Kembali
                </a>

                <div class="inline-flex px-4 py-2 rounded-full bg-blue-50 text-blue-600 font-black text-sm mb-4">
                    ➕ Tambah Absensi Manual
                </div>

                <h1 class="text-4xl lg:text-6xl font-black text-slate-900">
                    Tambah Absensi
                </h1>

                <p class="text-slate-500 mt-4">
                    Input absensi manual sebelum fitur scan wajah diaktifkan.
                </p>
            </div>

            <form method="POST"
                  action="{{ route('attendances.store') }}"
                  class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                @csrf

                <div class="xl:col-span-1">
                    <div class="rounded-[2.5rem] bg-white/90 shadow-xl border border-white p-8 text-center xl:sticky xl:top-8">
                        <div class="w-24 h-24 rounded-[2rem] bg-gradient-to-br from-blue-600 to-cyan-400 text-white flex items-center justify-center mx-auto shadow-2xl text-4xl">
                            🕒
                        </div>

                        <h3 class="mt-6 text-2xl font-black text-slate-900">
                            Validasi Otomatis
                        </h3>

                        <p class="text-slate-400 mt-2 text-sm">
                            Sistem akan menghitung keterlambatan berdasarkan shift karyawan.
                        </p>
                    </div>
                </div>

                <div class="xl:col-span-2">
                    <div class="rounded-[2.5rem] bg-white/90 shadow-xl border border-white p-6 lg:p-8">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div class="md:col-span-2">
                                <label class="font-black text-slate-700 mb-2 block">Karyawan</label>
                                <select name="employee_id"
                                        class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 focus:border-blue-400 focus:ring-blue-400">
                                    <option value="">Pilih Karyawan</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}" @selected(old('employee_id') == $employee->id)>
                                            {{ $employee->name }} - {{ $employee->employee_code }}
                                            @if ($employee->workShift)
                                                ({{ $employee->workShift->name }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('employee_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="font-black text-slate-700 mb-2 block">Tanggal</label>
                                <input type="date"
                                       name="date"
                                       value="{{ old('date', date('Y-m-d')) }}"
                                       class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 focus:border-blue-400 focus:ring-blue-400">
                            </div>

                            <div>
                                <label class="font-black text-slate-700 mb-2 block">Status</label>
                                <select name="status"
                                        class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 focus:border-blue-400 focus:ring-blue-400">
                                    <option value="present">Hadir</option>
                                    <option value="late">Terlambat</option>
                                    <option value="leave">Izin</option>
                                    <option value="sick">Sakit</option>
                                    <option value="absent">Alpha</option>
                                </select>
                            </div>

                            <div>
                                <label class="font-black text-slate-700 mb-2 block">Jam Masuk</label>
                                <input type="time"
                                       name="check_in"
                                       value="{{ old('check_in') }}"
                                       class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 focus:border-blue-400 focus:ring-blue-400">
                            </div>

                            <div>
                                <label class="font-black text-slate-700 mb-2 block">Jam Pulang</label>
                                <input type="time"
                                       name="check_out"
                                       value="{{ old('check_out') }}"
                                       class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 focus:border-blue-400 focus:ring-blue-400">
                            </div>

                            <div class="md:col-span-2">
                                <label class="font-black text-slate-700 mb-2 block">Catatan</label>
                                <textarea name="note"
                                          rows="4"
                                          class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 focus:border-blue-400 focus:ring-blue-400"
                                          placeholder="Opsional">{{ old('note') }}</textarea>
                            </div>

                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 pt-10">
                            <button class="px-8 py-4 rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-400 text-white font-black shadow-xl">
                                Simpan Absensi
                            </button>

                            <a href="{{ route('attendances.index') }}"
                               class="px-8 py-4 rounded-2xl bg-slate-100 text-slate-600 font-black text-center">
                                Batal
                            </a>
                        </div>

                    </div>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>