<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-cyan-100 p-4 lg:p-8">
        <div class="max-w-6xl mx-auto">

            <div class="form-hero rounded-[2.5rem] bg-white/80 backdrop-blur-2xl shadow-2xl border border-white p-6 lg:p-10 mb-8">
                <a href="{{ route('attendances.index') }}" class="inline-flex text-blue-600 font-black mb-5">
                    ← Kembali
                </a>

                <div class="inline-flex px-4 py-2 rounded-full bg-orange-50 text-orange-600 font-black text-sm mb-4">
                    ✏️ Edit Absensi
                </div>

                <h1 class="text-4xl lg:text-6xl font-black text-slate-900">
                    Edit Absensi
                </h1>

                <p class="text-slate-500 mt-4">
                    Perbarui data kehadiran karyawan.
                </p>
            </div>

            <form method="POST"
                  action="{{ route('attendances.update', $attendance) }}"
                  class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                @csrf
                @method('PUT')

                <div class="xl:col-span-1">
                    <div class="employee-form rounded-[2.5rem] bg-white/90 shadow-xl border border-white p-8 text-center xl:sticky xl:top-8">
                        <div class="w-24 h-24 rounded-[2rem] bg-gradient-to-br from-orange-500 to-yellow-400 text-white flex items-center justify-center mx-auto shadow-2xl text-4xl">
                            🕒
                        </div>

                        <h3 class="mt-6 text-2xl font-black text-slate-900">
                            Edit Kehadiran
                        </h3>

                        <p class="text-slate-400 mt-2 text-sm">
                            Keterlambatan akan dihitung ulang berdasarkan shift karyawan.
                        </p>
                    </div>
                </div>

                <div class="xl:col-span-2">
                    <div class="employee-form rounded-[2.5rem] bg-white/90 shadow-xl border border-white p-6 lg:p-8">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div class="md:col-span-2">
                                <label class="font-black text-slate-700 mb-2 block">Karyawan</label>
                                <select name="employee_id"
                                        class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 focus:border-blue-400 focus:ring-blue-400">
                                    <option value="">Pilih Karyawan</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"
                                            @selected(old('employee_id', $attendance->employee_id) == $employee->id)>
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
                                       value="{{ old('date', $attendance->date) }}"
                                       class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 focus:border-blue-400 focus:ring-blue-400">
                            </div>

                            <div>
                                <label class="font-black text-slate-700 mb-2 block">Status</label>
                                <select name="status"
                                        class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 focus:border-blue-400 focus:ring-blue-400">
                                    <option value="present" @selected(old('status', $attendance->status) === 'present')>Hadir</option>
                                    <option value="late" @selected(old('status', $attendance->status) === 'late')>Terlambat</option>
                                    <option value="leave" @selected(old('status', $attendance->status) === 'leave')>Izin</option>
                                    <option value="sick" @selected(old('status', $attendance->status) === 'sick')>Sakit</option>
                                    <option value="absent" @selected(old('status', $attendance->status) === 'absent')>Alpha</option>
                                </select>
                            </div>

                            <div>
                                <label class="font-black text-slate-700 mb-2 block">Jam Masuk</label>
                                <input type="time"
                                       name="check_in"
                                       value="{{ old('check_in', $attendance->check_in) }}"
                                       class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 focus:border-blue-400 focus:ring-blue-400">
                            </div>

                            <div>
                                <label class="font-black text-slate-700 mb-2 block">Jam Pulang</label>
                                <input type="time"
                                       name="check_out"
                                       value="{{ old('check_out', $attendance->check_out) }}"
                                       class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 focus:border-blue-400 focus:ring-blue-400">
                            </div>

                            <div class="md:col-span-2">
                                <label class="font-black text-slate-700 mb-2 block">Catatan</label>
                                <textarea name="note"
                                          rows="4"
                                          class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 focus:border-blue-400 focus:ring-blue-400"
                                          placeholder="Opsional">{{ old('note', $attendance->note) }}</textarea>
                            </div>

                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 pt-10">
                            <button class="px-8 py-4 rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-400 text-white font-black shadow-xl">
                                Simpan Perubahan
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