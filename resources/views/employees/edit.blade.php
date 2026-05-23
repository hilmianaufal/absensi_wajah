<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-cyan-100 p-4 lg:p-8">
        <div class="max-w-7xl mx-auto">

            {{-- HERO --}}
            <div class="form-hero rounded-[2.5rem] bg-white/80 backdrop-blur-2xl shadow-2xl border border-white p-6 lg:p-10 mb-8 overflow-hidden relative">
                <div class="absolute -top-20 -right-20 w-72 h-72 bg-blue-300/30 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-cyan-300/30 rounded-full blur-3xl"></div>

                <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <a href="{{ route('employees.index') }}"
                           class="inline-flex items-center gap-2 text-blue-600 font-black mb-5">
                            ← Kembali
                        </a>

                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-orange-50 text-orange-600 font-black text-sm mb-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path d="M12 20h9"/>
                                <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/>
                            </svg>
                            Edit Data Karyawan
                        </div>

                        <h1 class="text-4xl lg:text-6xl font-black text-slate-900 leading-tight">
                            Edit
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-400">
                                Karyawan
                            </span>
                        </h1>

                        <p class="text-slate-500 mt-4 max-w-2xl">
                            Perbarui profil karyawan untuk kebutuhan absensi, data HR, dan scan wajah.
                        </p>
                    </div>

                    <div class="hidden lg:flex w-28 h-28 rounded-[2rem] bg-gradient-to-br from-orange-500 to-yellow-400 items-center justify-center text-white shadow-2xl">
                        <svg class="w-14 h-14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path d="M12 20h9"/>
                            <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- FORM --}}
            <form method="POST"
                  action="{{ route('employees.update', $employee) }}"
                  enctype="multipart/form-data"
                  class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                @csrf
                @method('PUT')

                {{-- LEFT CARD --}}
                <div class="xl:col-span-1">
                    <div class="employee-form rounded-[2.5rem] bg-white/90 backdrop-blur-2xl shadow-xl border border-white p-8 xl:sticky xl:top-8">

                        <div class="flex flex-col items-center text-center">

                            <div class="relative group cursor-pointer">
                                <input type="file"
                                       name="photo"
                                       id="photoInput"
                                       accept="image/*"
                                       class="hidden">

                                <div class="relative w-44 h-44">
                                    <div class="absolute inset-0 rounded-full bg-gradient-to-br from-blue-400 to-cyan-300 blur-2xl opacity-30 scale-110"></div>

                                    <img id="previewImage"
                                         src="{{ $employee->photo ? asset($employee->photo) : 'https://ui-avatars.com/api/?name='.urlencode($employee->name).'&background=0ea5e9&color=fff' }}"
                                         class="relative z-10 w-44 h-44 rounded-full object-cover object-center border-[6px] border-white shadow-[0_20px_60px_rgba(0,0,0,0.15)] transition duration-500 group-hover:scale-[1.03] bg-white">

                                    {{-- Overlay Hover --}}
                                    <div id="uploadTrigger"
                                         class="absolute inset-0 z-20 rounded-full bg-black/30 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                                        <div class="w-16 h-16 rounded-2xl bg-white text-blue-600 flex items-center justify-center shadow-2xl">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                                                <circle cx="12" cy="13" r="4"/>
                                            </svg>
                                        </div>
                                    </div>

                                    {{-- Icon Kamera Tetap Ada --}}
                                    <div class="absolute -right-2 bottom-4 z-30 w-12 h-12 rounded-2xl bg-white text-blue-600 flex items-center justify-center shadow-2xl border border-blue-100 group-hover:scale-110 transition">
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                                            <circle cx="12" cy="13" r="4"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <h3 class="mt-6 text-2xl font-black text-slate-900">
                                {{ $employee->name }}
                            </h3>

                            <p class="text-slate-400 mt-1 text-sm">
                                {{ $employee->employee_code }}
                            </p>

                            <p class="text-sm text-slate-400 mt-3">
                                Klik foto untuk mengganti gambar
                            </p>

                            @error('photo')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-8 space-y-4">
                            <div class="flex items-center gap-3 p-4 rounded-2xl bg-slate-50">
                                <div class="w-11 h-11 rounded-2xl bg-green-100 text-green-600 flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                                        <path d="M20 6 9 17l-5-5"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-black text-slate-800 text-sm">Data aman</p>
                                    <p class="text-xs text-slate-400">Tersimpan di database</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 p-4 rounded-2xl bg-slate-50">
                                <div class="w-11 h-11 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                                        <path d="M12 3v18"/>
                                        <path d="M3 12h18"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-black text-slate-800 text-sm">Siap scan</p>
                                    <p class="text-xs text-slate-400">Untuk absensi wajah</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- RIGHT FORM --}}
                <div class="xl:col-span-2">
                    <div class="employee-form rounded-[2.5rem] bg-white/90 backdrop-blur-2xl shadow-xl border border-white p-6 lg:p-8">

                        <div class="mb-8">
                            <h2 class="text-2xl font-black text-slate-900">Informasi Karyawan</h2>
                            <p class="text-slate-400 mt-1">Ubah data identitas karyawan.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <label class="flex items-center gap-2 font-black text-slate-700 mb-2">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                                        <path d="M4 7V4h16v3"/>
                                        <path d="M9 20h6"/>
                                        <path d="M12 4v16"/>
                                    </svg>
                                    Kode Karyawan
                                </label>
                                <input name="employee_code"
                                       value="{{ old('employee_code', $employee->employee_code) }}"
                                       class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 focus:bg-white focus:border-blue-400 focus:ring-blue-400"
                                       placeholder="EMP001">
                                @error('employee_code')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="flex items-center gap-2 font-black text-slate-700 mb-2">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                                        <path d="M20 21a8 8 0 1 0-16 0"/>
                                        <circle cx="12" cy="7" r="4"/>
                                    </svg>
                                    Nama Lengkap
                                </label>
                                <input name="name"
                                       value="{{ old('name', $employee->name) }}"
                                       class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 focus:bg-white focus:border-blue-400 focus:ring-blue-400"
                                       placeholder="Nama karyawan">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="flex items-center gap-2 font-black text-slate-700 mb-2">
                                    <svg class="w-5 h-5 text-cyan-500" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                                        <path d="M4 4h16v16H4z"/>
                                        <path d="m22 6-10 7L2 6"/>
                                    </svg>
                                    Email
                                </label>
                                <input type="email"
                                       name="email"
                                       value="{{ old('email', $employee->email) }}"
                                       class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 focus:bg-white focus:border-blue-400 focus:ring-blue-400"
                                       placeholder="email@contoh.com">
                            </div>

                            <div>
                                <label class="flex items-center gap-2 font-black text-slate-700 mb-2">
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.8 19.8 0 0 1 3.08 5.18 2 2 0 0 1 5.06 3h3a2 2 0 0 1 2 1.72c.12.9.33 1.77.63 2.61a2 2 0 0 1-.45 2.11L9 10.69a16 16 0 0 0 4.31 4.31l1.25-1.25a2 2 0 0 1 2.11-.45c.84.3 1.71.51 2.61.63A2 2 0 0 1 22 16.92z"/>
                                    </svg>
                                    No. HP
                                </label>
                                <input name="phone"
                                       value="{{ old('phone', $employee->phone) }}"
                                       class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 focus:bg-white focus:border-blue-400 focus:ring-blue-400"
                                       placeholder="08xxxxxxxxxx">
                            </div>

                            <div>
                                <label class="flex items-center gap-2 font-black text-slate-700 mb-2">
                                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                                        <path d="M3 21h18"/>
                                        <path d="M5 21V7l8-4v18"/>
                                        <path d="M19 21V11l-6-4"/>
                                    </svg>
                                    Divisi
                                </label>
                                <input name="department"
                                       value="{{ old('department', $employee->department) }}"
                                       class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 focus:bg-white focus:border-blue-400 focus:ring-blue-400"
                                       placeholder="IT / HR / Finance">
                            </div>
                                <div>
                                    <label class="flex items-center gap-2 font-black text-slate-700 mb-2">
                                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="9"/>
                                            <path d="M12 7v5l3 2"/>
                                        </svg>
                                        Shift Kerja
                                    </label>

                                    <select name="work_shift_id"
                                            class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 focus:bg-white focus:border-blue-400 focus:ring-blue-400">
                                        <option value="">Pilih Shift</option>

                                        @foreach ($workShifts as $shift)
                                            <option value="{{ $shift->id }}" @selected(old('work_shift_id', $employee->work_shift_id) == $shift->id)>
                                                {{ $shift->name }} - {{ \Carbon\Carbon::parse($shift->start_time)->format('H:i') }} s/d {{ \Carbon\Carbon::parse($shift->end_time)->format('H:i') }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('work_shift_id')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            <div>
                                <label class="flex items-center gap-2 font-black text-slate-700 mb-2">
                                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                                        <rect x="2" y="7" width="20" height="14" rx="2"/>
                                        <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/>
                                    </svg>
                                    Jabatan
                                </label>
                                <input name="position"
                                       value="{{ old('position', $employee->position) }}"
                                       class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 focus:bg-white focus:border-blue-400 focus:ring-blue-400"
                                       placeholder="Staff / Manager">
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
                                    <option value="active" @selected($employee->status === 'active')>Aktif</option>
                                    <option value="inactive" @selected($employee->status === 'inactive')>Nonaktif</option>
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
                                Simpan Perubahan
                            </button>

                            <button type="button"
                                    onclick="confirm('Yakin ingin menghapus karyawan ini?') && document.getElementById('delete-form').submit()"
                                    class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl bg-red-50 text-red-600 font-black hover:bg-red-100 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path d="M3 6h18"/>
                                    <path d="M8 6V4h8v2"/>
                                    <path d="M19 6l-1 14H6L5 6"/>
                                </svg>
                                Hapus Karyawan
                            </button>
                        </div>

                    </div>
                </div>
            </form>

            {{-- DELETE FORM --}}
            <form id="delete-form" method="POST" action="{{ route('employees.destroy', $employee) }}">
                @csrf
                @method('DELETE')
            </form>

        </div>
    </div>

    <script>
        const photoInput = document.getElementById('photoInput');
        const previewImage = document.getElementById('previewImage');
        const uploadTrigger = document.getElementById('uploadTrigger');

        const openFilePicker = () => {
            photoInput.click();
        };

        previewImage.addEventListener('click', openFilePicker);
        uploadTrigger.addEventListener('click', openFilePicker);

        photoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(event) {
                    previewImage.src = event.target.result;

                    previewImage.classList.add('scale-95');

                    setTimeout(() => {
                        previewImage.classList.remove('scale-95');
                    }, 150);
                };

                reader.readAsDataURL(file);
            }
        });
    </script>
</x-app-layout>