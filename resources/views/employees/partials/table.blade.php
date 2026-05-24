<div class="overflow-x-auto">
    <table class="w-full min-w-[1100px]">
        <thead>
            <tr class="bg-slate-50 text-slate-400 text-xs uppercase tracking-widest">
                <th class="px-7 py-5 text-left">Karyawan</th>
                <th class="px-7 py-5 text-left">Kode</th>
                <th class="px-7 py-5 text-left">Divisi</th>
                <th class="px-7 py-5 text-left">Shift</th>
                <th class="px-7 py-5 text-left">Jabatan</th>
                <th class="px-7 py-5 text-left">Status</th>
                <th class="px-7 py-5 text-right">Aksi</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-slate-100">
            @forelse ($employees as $employee)
                <tr class="group hover:bg-gradient-to-r hover:from-cyan-50/80 hover:to-blue-50/60 transition">
                    <td class="px-7 py-5">
                        <div class="flex items-center gap-4">
                            <img src="{{ $employee->photo && file_exists(public_path($employee->photo))
                                    ? asset($employee->photo)
                                    : 'https://ui-avatars.com/api/?name='.urlencode($employee->name).'&background=0ea5e9&color=fff' }}"
                                 class="w-16 h-16 rounded-[1.5rem] object-cover shadow-xl border-4 border-white group-hover:scale-105 transition">

                            <div>
                                <p class="font-black text-slate-950">
                                    {{ $employee->name }}
                                </p>
                                <p class="text-sm text-slate-400 font-bold">
                                    {{ $employee->email ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </td>

                    <td class="px-7 py-5">
                        <span class="px-4 py-2 rounded-2xl bg-slate-100 text-slate-700 font-black text-sm">
                            {{ $employee->employee_code }}
                        </span>
                    </td>

                    <td class="px-7 py-5 text-slate-500 font-bold">
                        {{ $employee->department ?? '-' }}
                    </td>

                    <td class="px-7 py-5 text-slate-500 font-bold">
                        {{ $employee->workShift?->name ?? '-' }}
                    </td>

                    <td class="px-7 py-5 text-slate-500 font-bold">
                        {{ $employee->position ?? '-' }}
                    </td>

                    <td class="px-7 py-5">
                        @if ($employee->status === 'active')
                            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-100 text-emerald-700 text-xs font-black">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-red-100 text-red-700 text-xs font-black">
                                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                Nonaktif
                            </span>
                        @endif
                    </td>

                    <td class="px-7 py-5">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('employees.show', $employee) }}"
                               class="px-4 py-2 rounded-2xl bg-cyan-50 text-cyan-600 font-black hover:bg-cyan-100 hover:scale-105 transition">
                                Detail
                            </a>

                            <a href="{{ route('employees.edit', $employee) }}"
                               class="px-4 py-2 rounded-2xl bg-blue-50 text-blue-600 font-black hover:bg-blue-100 hover:scale-105 transition">
                                Edit
                            </a>

                            <a href="{{ route('employees.face-register', $employee) }}"
                               class="px-4 py-2 rounded-2xl bg-purple-50 text-purple-600 font-black hover:bg-purple-100 hover:scale-105 transition">
                                Scan
                            </a>

                            <form action="{{ route('employees.destroy', $employee) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus karyawan ini?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="px-4 py-2 rounded-2xl bg-red-50 text-red-600 font-black hover:bg-red-100 hover:scale-105 transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-24 text-center">
                        <div class="text-7xl mb-5">🔍</div>
                        <h3 class="text-2xl font-black text-slate-800">
                            Data tidak ditemukan
                        </h3>
                        <p class="text-slate-400 mt-2 font-bold">
                            Coba ubah kata pencarian atau filter.
                        </p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if ($employees->hasPages())
    <div class="p-6 border-t border-slate-100 bg-white">
        {{ $employees->links() }}
    </div>
@endif