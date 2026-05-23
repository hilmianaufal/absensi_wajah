<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-red-50 via-white to-yellow-100 p-4 lg:p-8">
        <div class="max-w-6xl mx-auto">

            {{-- HEADER --}}
            <div class="mb-8 rounded-[2.5rem] bg-white/90 backdrop-blur-2xl shadow-2xl border border-white p-6 lg:p-8">

                <a href="{{ route('employees.index') }}"
                   class="inline-flex text-red-700 font-black mb-5">
                    ← Kembali
                </a>

                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

                    <div>
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-red-50 text-red-700 font-black text-sm mb-4">
                            🪪 ID Card HUBASO
                        </div>

                        <h1 class="text-4xl lg:text-6xl font-black tracking-tight text-slate-950">
                            Kartu Identitas
                        </h1>

                        <p class="text-slate-500 mt-3 font-medium">
                            ID Card premium dengan tema merah gold perusahaan.
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">

                        <button onclick="downloadCard()"
                                class="px-6 py-4 rounded-2xl bg-gradient-to-r from-red-700 to-yellow-500 text-white font-black shadow-xl hover:scale-105 transition">
                            Download PNG
                        </button>

                        <button onclick="window.print()"
                                class="px-6 py-4 rounded-2xl bg-slate-950 text-white font-black shadow-xl hover:scale-105 transition">
                            Print ID Card
                        </button>

                    </div>

                </div>

            </div>

            {{-- CARD --}}
            <div class="flex justify-center">

                <div id="idCard"
                     class="relative w-[360px] h-[600px] rounded-[2.2rem] shadow-[0_35px_100px_rgba(127,29,29,0.45)] overflow-hidden bg-red-950">

                    {{-- Background --}}
                    <div class="absolute inset-0 bg-gradient-to-br from-red-950 via-red-800 to-yellow-600"></div>

                    {{-- Glow --}}
                    <div class="absolute -top-28 -right-24 w-72 h-72 bg-yellow-300/45 rounded-full blur-3xl"></div>
                    <div class="absolute top-20 -left-28 w-72 h-72 bg-red-500/35 rounded-full blur-3xl"></div>

                    {{-- Overlay --}}
                    <div class="absolute bottom-0 left-0 right-0 h-52 bg-gradient-to-t from-black/55 to-transparent"></div>

                    {{-- Pattern --}}
                    <div class="absolute inset-0 opacity-15"
                         style="background-image: radial-gradient(circle at 1px 1px, #fff 1px, transparent 0); background-size: 22px 22px;">
                    </div>

                    {{-- Gold Border --}}
                    <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-yellow-300 via-yellow-500 to-yellow-200"></div>
                    <div class="absolute bottom-0 left-0 right-0 h-2 bg-gradient-to-r from-yellow-200 via-yellow-500 to-yellow-300"></div>

                    {{-- CONTENT --}}
                    <div class="relative z-10 h-full p-7 text-white flex flex-col">

                        {{-- HEADER --}}
                        <div class="flex items-center justify-between">

                            {{-- LEFT --}}
                            <div class="flex items-center gap-3">

                                <img src="{{ asset('images/logo-company.jpeg') }}"
                                     class="w-16 h-16 rounded-2xl object-cover bg-white p-1 shadow-xl border border-yellow-300">

                                <div>
                                    <h2 class="font-black text-xl leading-tight tracking-tight text-yellow-100">
                                        HUBASO
                                    </h2>

                                    <p class="text-xs font-bold text-yellow-100/80">
                                        Smart Attendance System
                                    </p>
                                </div>

                            </div>

                            {{-- QR --}}
                            <div class="w-16 h-16 rounded-2xl bg-white p-1.5 shadow-xl border border-yellow-300">

                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=160x160&data={{ urlencode(route('employees.show', $employee)) }}"
                                     class="w-full h-full rounded-xl object-cover"
                                     crossorigin="anonymous">

                            </div>

                        </div>

                        {{-- PHOTO --}}
                        <div class="mt-10 flex justify-center">

                            <div class="relative">

                                <div class="absolute inset-0 rounded-full bg-yellow-300 blur-2xl opacity-45 scale-110"></div>

                                <div class="relative w-40 h-40 rounded-full bg-gradient-to-br from-yellow-200 to-yellow-500 p-2 shadow-2xl">

                                    <img src="{{ $employee->photo ? asset($employee->photo) : 'https://ui-avatars.com/api/?name='.urlencode($employee->name).'&background=7f1d1d&color=fff' }}"
                                         class="w-full h-full rounded-full object-cover border-4 border-white">

                                </div>

                            </div>

                        </div>

                        {{-- NAME --}}
                        <div class="text-center mt-7">

                            <h1 class="text-3xl font-black uppercase tracking-wide leading-tight drop-shadow-lg text-white">
                                {{ $employee->name }}
                            </h1>

                            <p class="mt-2 text-yellow-200 text-lg font-black uppercase tracking-widest">
                                {{ $employee->position ?? 'Karyawan' }}
                            </p>

                        </div>

                        {{-- INFO --}}
                        <div class="mt-8 rounded-[2rem] bg-white/15 backdrop-blur-xl border border-yellow-200/30 p-5 space-y-4 shadow-xl">

                            <div class="flex items-center justify-between gap-4">

                                <span class="text-yellow-100 text-sm font-bold">
                                    ID
                                </span>

                                <span class="text-white font-black text-base">
                                    {{ $employee->employee_code }}
                                </span>

                            </div>

                            <div class="flex items-center justify-between gap-4">

                                <span class="text-yellow-100 text-sm font-bold">
                                    Divisi
                                </span>

                                <span class="text-white font-black text-base">
                                    {{ $employee->department ?? '-' }}
                                </span>

                            </div>

                            <div class="flex items-center justify-between gap-4">

                                <span class="text-yellow-100 text-sm font-bold">
                                    Status
                                </span>

                                <span class="px-3 py-1 rounded-full bg-yellow-300 text-red-950 font-black text-xs">
                                    {{ $employee->status === 'active' ? 'AKTIF' : 'NONAKTIF' }}
                                </span>

                            </div>

                        </div>

                        {{-- FOOTER --}}
                        <div class="mt-auto pt-6 text-center">

                            <p class="text-xs tracking-[0.3em] text-yellow-100/70 font-black uppercase">
                                Valid Employee
                            </p>

                            <h2 class="text-3xl font-black text-yellow-200 leading-none mt-2">
                                2026
                            </h2>

                            <div class="mt-3 inline-flex items-center gap-2 px-3 py-2 rounded-full bg-white/10 backdrop-blur-xl border border-white/10">

                                <div class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></div>

                                <span class="text-xs font-bold text-yellow-50">
                                    Active Card
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

<script>
    function downloadCard() {
        const card = document.getElementById('idCard');

        html2canvas(card, {
            scale: 3,
            backgroundColor: null,
            useCORS: true,
            allowTaint: true
        }).then(canvas => {
            const link = document.createElement('a');
            link.download = 'id-card-{{ $employee->employee_code }}.png';
            link.href = canvas.toDataURL('image/png');
            link.click();
        });
    }
</script>


    {{-- PRINT --}}
    <style>

        @media print {

            body * {
                visibility: hidden;
            }

            #idCard,
            #idCard * {
                visibility: visible;
            }

            #idCard {
                position: absolute;
                left: 50%;
                top: 20px;
                transform: translateX(-50%);
                box-shadow: none !important;
            }

        }

    </style>

</x-app-layout>