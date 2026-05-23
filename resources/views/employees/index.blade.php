<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-sky-50 via-white to-indigo-100 p-4 lg:p-8">
        <div class="max-w-7xl mx-auto">
            @if (session('success'))
                <div class="mb-6 rounded-2xl bg-green-100 text-green-700 px-5 py-4 font-bold shadow">
                    ✅ {{ session('success') }}
                </div>
            @endif
            <div class="employee-hero rounded-[2rem] bg-white/80 backdrop-blur-2xl shadow-2xl border border-white p-6 lg:p-8 mb-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">
                    <div>
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-50 text-blue-600 font-bold text-sm mb-4">
                            👥 Manajemen Karyawan
                        </div>

                        <h1 class="text-3xl lg:text-5xl font-black text-slate-800">
                            Data Karyawan
                        </h1>

                        <p class="text-slate-500 mt-3">
                            Kelola data karyawan, jabatan, divisi, dan status akun.
                        </p>
                    </div>

                    <a href="{{ route('employees.create') }}"
                       class="inline-flex items-center justify-center gap-2 px-6 py-4 rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-400 text-white font-bold shadow-xl hover:scale-105 transition">
                        ➕ Tambah Karyawan
                    </a>
                </div>
            </div>

            <div class="employee-table rounded-[2rem] bg-white/90 backdrop-blur-2xl shadow-xl border border-white overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h2 class="font-black text-xl text-slate-800">Daftar Karyawan</h2>
                        <p class="text-sm text-slate-400">Semua data karyawan terdaftar.</p>
                    </div>

                    <div class="relative">
                        <input type="text"
                               placeholder="Cari karyawan..."
                               class="w-full md:w-72 rounded-2xl border-slate-200 focus:border-blue-400 focus:ring-blue-400">
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 text-slate-500 text-sm">
                            <tr>
                                <th class="px-6 py-4 text-left">Karyawan</th>
                                <th class="px-6 py-4 text-left">Kode</th>
                                <th class="px-6 py-4 text-left">Divisi</th>
                                <th class="px-6 py-4 text-left">Shift</th>
                                <th class="px-6 py-4 text-left">Jabatan</th>
                                <th class="px-6 py-4 text-left">Status</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse ($employees as $employee)
                                <tr class="hover:bg-blue-50/50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                        <img src="{{ $employee->photo && file_exists(public_path($employee->photo)) 
                                                ? asset($employee->photo) 
                                                : 'https://ui-avatars.com/api/?name='.urlencode($employee->name).'&background=0ea5e9&color=fff' }}"
                                            class="w-12 h-12 rounded-2xl object-cover shadow-lg border-2 border-white">
                                            <div>
                                                <p class="font-bold text-slate-800">{{ $employee->name }}</p>
                                                <p class="text-sm text-slate-400">{{ $employee->email ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 font-semibold text-slate-600">
                                        {{ $employee->employee_code }}
                                    </td>

                                    <td class="px-6 py-4 text-slate-500">
                                        {{ $employee->department ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-slate-500">
                                        {{ $employee->workShift?->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-slate-500">
                                        {{ $employee->position ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4">
                                        @if ($employee->status === 'active')
                                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-600 text-xs font-bold">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-600 text-xs font-bold">
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>

                                        <td class="px-6 py-4 text-right">

                                            <div class="flex items-center justify-end gap-2">

                                                {{-- DETAIL --}}
                                                <a href="{{ route('employees.show', $employee) }}"
                                                class="group inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-cyan-50 text-cyan-600 font-bold hover:bg-cyan-100 transition shadow-sm">

                                                    <svg class="w-5 h-5 group-hover:scale-110 transition"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2.4"
                                                        viewBox="0 0 24 24">

                                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/>
                                                        <circle cx="12" cy="12" r="3"/>

                                                    </svg>

                                                    Detail

                                                </a>

                                                {{-- EDIT --}}
                                                <a href="{{ route('employees.edit', $employee) }}"
                                                class="group inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-blue-50 text-blue-600 font-bold hover:bg-blue-100 transition shadow-sm">

                                                    <svg class="w-5 h-5 group-hover:rotate-12 transition"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2.4"
                                                        viewBox="0 0 24 24">

                                                        <path d="M12 20h9"/>
                                                        <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/>

                                                    </svg>

                                                    Edit

                                                </a>

                                                {{-- DELETE --}}
                                                <form action="{{ route('employees.destroy', $employee) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus karyawan ini?')">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            class="group inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-red-50 text-red-600 font-bold hover:bg-red-100 transition shadow-sm">

                                                        <svg class="w-5 h-5 group-hover:scale-110 transition"
                                                            fill="none"
                                                            stroke="currentColor"
                                                            stroke-width="2.4"
                                                            viewBox="0 0 24 24">

                                                            <path d="M3 6h18"/>
                                                            <path d="M8 6V4h8v2"/>
                                                            <path d="M19 6l-1 14H6L5 6"/>

                                                        </svg>

                                                        Hapus

                                                    </button>

                                                </form>
                                                <a href="{{ route('employees.face-register', $employee) }}"
                                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-purple-50 text-purple-600 font-bold hover:bg-purple-100 transition shadow-sm">
                                                            Scan Wajah
    </a>

                                            </div>

                                        </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="text-5xl mb-4">👤</div>
                                        <h3 class="font-black text-xl text-slate-700">Belum ada karyawan</h3>
                                        <p class="text-slate-400 mt-2">Tambahkan karyawan pertama kamu.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-5">
                    {{ $employees->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>