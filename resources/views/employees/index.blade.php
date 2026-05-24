<x-app-layout>
    <div class="min-h-screen bg-[radial-gradient(circle_at_top_left,#dff7ff,transparent_35%),linear-gradient(135deg,#f8fafc,#eef9ff,#ecfeff)] p-4 lg:p-8">
        <div class="max-w-7xl mx-auto">

            @if (session('success'))
                <div class="mb-6 rounded-3xl bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 font-black shadow-xl">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <div class="relative overflow-hidden rounded-[2.5rem] bg-white/80 backdrop-blur-2xl border border-white shadow-2xl p-6 lg:p-10 mb-8">
                <div class="absolute -top-24 -right-24 w-80 h-80 bg-cyan-200/70 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-28 -left-28 w-96 h-96 bg-blue-200/70 rounded-full blur-3xl"></div>

                <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">
                    <div>
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-cyan-50 text-cyan-600 border border-cyan-100 font-black text-sm mb-5 shadow-sm">
                            👥 Premium Employee Management
                        </div>

                        <h1 class="text-4xl lg:text-6xl font-black text-slate-950 tracking-tight">
                            Data Karyawan
                        </h1>

                        <p class="text-slate-500 mt-4 max-w-2xl font-semibold">
                            Kelola data karyawan, divisi, shift, status akun, dan registrasi wajah secara realtime.
                        </p>
                    </div>

                    <a href="{{ route('employees.create') }}"
                       class="inline-flex items-center justify-center gap-3 px-7 py-4 rounded-3xl bg-gradient-to-r from-blue-600 to-cyan-400 text-white font-black shadow-2xl shadow-cyan-300/40 hover:scale-105 transition">
                        <span class="text-xl">＋</span>
                        Tambah Karyawan
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
                <div class="rounded-[2rem] bg-white/85 backdrop-blur-xl border border-white shadow-xl p-6">
                    <p class="text-slate-400 font-black text-sm uppercase tracking-widest">Total Karyawan</p>
                    <h3 class="text-4xl font-black text-slate-950 mt-3">{{ $employees->total() }}</h3>
                </div>

                <div class="rounded-[2rem] bg-white/85 backdrop-blur-xl border border-white shadow-xl p-6">
                    <p class="text-slate-400 font-black text-sm uppercase tracking-widest">Filter Realtime</p>
                    <h3 class="text-4xl font-black text-blue-600 mt-3">Aktif</h3>
                </div>

                <div class="rounded-[2rem] bg-white/85 backdrop-blur-xl border border-white shadow-xl p-6">
                    <p class="text-slate-400 font-black text-sm uppercase tracking-widest">Face Scan</p>
                    <h3 class="text-4xl font-black text-cyan-600 mt-3">Ready</h3>
                </div>
            </div>

            <div class="rounded-[2.5rem] bg-white/90 backdrop-blur-2xl border border-white shadow-2xl overflow-hidden">
                <div class="p-6 lg:p-8 border-b border-slate-100">
                    <div class="flex flex-col xl:flex-row xl:items-end xl:justify-between gap-6">
                        <div>
                            <h2 class="text-2xl lg:text-3xl font-black text-slate-950">
                                Daftar Karyawan
                            </h2>
                            <p class="text-slate-400 font-semibold mt-1">
                                Cari dan filter data tanpa reload halaman.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 w-full xl:max-w-4xl">
                            <div>
                                <label class="text-xs font-black text-slate-400 uppercase tracking-widest">
                                    Pencarian
                                </label>
                                <input type="text"
                                       id="searchInput"
                                       placeholder="Nama, kode, email..."
                                       class="mt-2 w-full rounded-3xl border-slate-200 bg-slate-50 px-5 py-4 font-bold text-slate-700 shadow-inner focus:border-cyan-400 focus:ring-cyan-400">
                            </div>

                            <div>
                                <label class="text-xs font-black text-slate-400 uppercase tracking-widest">
                                    Status
                                </label>
                                <select id="statusFilter"
                                        class="mt-2 w-full rounded-3xl border-slate-200 bg-slate-50 px-5 py-4 font-bold text-slate-700 shadow-inner focus:border-cyan-400 focus:ring-cyan-400">
                                    <option value="">Semua Status</option>
                                    <option value="active">Aktif</option>
                                    <option value="inactive">Nonaktif</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-xs font-black text-slate-400 uppercase tracking-widest">
                                    Departemen
                                </label>
                                <select id="departmentFilter"
                                        class="mt-2 w-full rounded-3xl border-slate-200 bg-slate-50 px-5 py-4 font-bold text-slate-700 shadow-inner focus:border-cyan-400 focus:ring-cyan-400">
                                    <option value="">Semua Departemen</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department }}">{{ $department }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="employeeTable">
                    @include('employees.partials.table', ['employees' => $employees])
                </div>
            </div>
        </div>
    </div>
<script>
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const departmentFilter = document.getElementById('departmentFilter');
    const employeeTable = document.getElementById('employeeTable');

    let typingTimer = null;

    function fetchEmployees(pageUrl = null) {
        let url = pageUrl || "{{ route('employees.index') }}";

        const params = new URLSearchParams({
            search: searchInput.value,
            status: statusFilter.value,
            department: departmentFilter.value
        });

        if (pageUrl) {
            url = pageUrl.split('?')[0];
        }

        employeeTable.innerHTML = `
            <div class="p-12 text-center">
                <div class="inline-flex items-center gap-3 px-6 py-4 rounded-3xl bg-blue-50 text-blue-600 font-black shadow">
                    <span class="animate-spin">⏳</span>
                    Memuat data...
                </div>
            </div>
        `;

        fetch(url + '?' + params.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            employeeTable.innerHTML = html;
        })
        .catch(error => {
            console.error(error);

            employeeTable.innerHTML = `
                <div class="p-12 text-center text-red-600 font-black">
                    Gagal memuat data karyawan.
                </div>
            `;
        });
    }

    searchInput.addEventListener('keyup', function () {
        clearTimeout(typingTimer);

        typingTimer = setTimeout(function () {
            fetchEmployees();
        }, 300);
    });

    statusFilter.addEventListener('change', function () {
        fetchEmployees();
    });

    departmentFilter.addEventListener('change', function () {
        fetchEmployees();
    });

    document.addEventListener('click', function (event) {
        const link = event.target.closest('#employeeTable .pagination a');

        if (link) {
            event.preventDefault();
            fetchEmployees(link.href);
        }
    });
</script>
</x-app-layout>