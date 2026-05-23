<nav x-data="{ open: false }"
     class="sticky top-0 z-50 bg-white/85 backdrop-blur-2xl border-b border-white/70 shadow-[0_10px_40px_rgba(15,23,42,0.08)]">

    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="flex justify-between items-center h-20">

            {{-- LOGO --}}
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                <div class="w-14 h-14 rounded-[1.3rem] overflow-hidden shadow-xl group-hover:scale-110 transition bg-white">
                    <img src="{{ asset('images/logo-company.jpeg') }}"
                        alt="Logo"
                        class="w-full h-full object-cover">
                </div>
                                <div class="hidden sm:block">
                    <h1 class="text-xl font-black text-slate-950 leading-none">
                        HubasoApp
                    </h1>
                    <p class="text-xs text-slate-400 font-bold mt-1">
                        Smart Attandance
                    </p>
                </div>
            </a>

            {{-- DESKTOP MENU --}}
            <div class="hidden xl:flex items-center gap-2">

                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-2 px-4 py-3 rounded-2xl font-black transition
                   {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-blue-600 to-cyan-400 text-white shadow-xl' : 'text-slate-500 hover:bg-blue-50 hover:text-blue-600' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                        <path d="M3 13h8V3H3v10zM13 21h8V3h-8v18zM3 21h8v-6H3v6z"/>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('employees.index') }}"
                   class="flex items-center gap-2 px-4 py-3 rounded-2xl font-black transition
                   {{ request()->routeIs('employees.*') ? 'bg-gradient-to-r from-blue-600 to-cyan-400 text-white shadow-xl' : 'text-slate-500 hover:bg-blue-50 hover:text-blue-600' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    Karyawan
                </a>

                <a href="{{ route('work-shifts.index') }}"
                   class="flex items-center gap-2 px-4 py-3 rounded-2xl font-black transition
                   {{ request()->routeIs('work-shifts.*') ? 'bg-gradient-to-r from-blue-600 to-cyan-400 text-white shadow-xl' : 'text-slate-500 hover:bg-blue-50 hover:text-blue-600' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M12 7v5l3 2"/>
                    </svg>
                    Shift
                </a>

                <a href="{{ route('attendances.index') }}"
                   class="flex items-center gap-2 px-4 py-3 rounded-2xl font-black transition
                   {{ request()->routeIs('attendances.*') ? 'bg-gradient-to-r from-blue-600 to-cyan-400 text-white shadow-xl' : 'text-slate-500 hover:bg-blue-50 hover:text-blue-600' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                        <path d="M8 2v4M16 2v4M3 10h18"/>
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                    </svg>
                    Absensi
                </a>

                <a href="{{ route('face-scan') }}"
                   class="flex items-center gap-2 px-4 py-3 rounded-2xl font-black transition
                   {{ request()->routeIs('face-scan') ? 'bg-gradient-to-r from-purple-600 to-fuchsia-500 text-white shadow-xl' : 'text-slate-500 hover:bg-purple-50 hover:text-purple-600' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                        <path d="M3 7V5a2 2 0 0 1 2-2h2"/>
                        <path d="M17 3h2a2 2 0 0 1 2 2v2"/>
                        <path d="M21 17v2a2 2 0 0 1-2 2h-2"/>
                        <path d="M7 21H5a2 2 0 0 1-2-2v-2"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                    Scan
                </a>

                <a href="{{ route('attendance-reports.index') }}"
                   class="flex items-center gap-2 px-4 py-3 rounded-2xl font-black transition
                   {{ request()->routeIs('attendance-reports.*') ? 'bg-gradient-to-r from-blue-600 to-cyan-400 text-white shadow-xl' : 'text-slate-500 hover:bg-blue-50 hover:text-blue-600' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                        <path d="M3 3v18h18"/>
                        <path d="M7 15l4-4 3 3 5-7"/>
                    </svg>
                    Laporan
                </a>

            </div>
            <a href="{{ route('users.index') }}"
                class="flex items-center gap-2 px-4 py-3 rounded-2xl font-black transition
                {{ request()->routeIs('users.*') ? 'bg-gradient-to-r from-blue-600 to-cyan-400 text-white shadow-xl' : 'text-slate-500 hover:bg-blue-50 hover:text-blue-600' }}">

                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    </svg>

                    User
                </a>
            {{-- RIGHT --}}
            <div class="hidden xl:flex items-center gap-3">
                <div class="flex items-center gap-3 px-4 py-3 rounded-2xl bg-slate-50 border border-slate-100">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-blue-600 to-cyan-400 text-white flex items-center justify-center font-black shadow-lg">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>

                    <div>
                        <p class="font-black text-slate-800 leading-none">
                            {{ Auth::user()->name }}
                        </p>
                        <p class="text-xs text-slate-400 mt-1 font-bold">
                            Administrator
                        </p>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-100 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                            <path d="M16 17l5-5-5-5"/>
                            <path d="M21 12H9"/>
                        </svg>
                    </button>
                </form>
            </div>

            {{-- MOBILE BUTTON --}}
            <button @click="open = !open"
                    class="xl:hidden w-14 h-14 rounded-2xl bg-slate-100 text-slate-700 flex items-center justify-center">
                <svg x-show="!open" class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                    <path d="M4 6h16M4 12h16M4 18h16"/>
                </svg>

                <svg x-show="open" class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

        </div>
    </div>

    {{-- MOBILE MENU --}}
    <div x-show="open"
         x-transition
         class="xl:hidden bg-white/95 backdrop-blur-2xl border-t border-slate-100 shadow-2xl">

        <div class="px-4 py-5 space-y-3">

            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-5 py-4 rounded-2xl font-black
               {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-blue-600 to-cyan-400 text-white shadow-xl' : 'bg-slate-50 text-slate-700' }}">
                📊 Dashboard
            </a>

            <a href="{{ route('employees.index') }}"
               class="flex items-center gap-3 px-5 py-4 rounded-2xl font-black
               {{ request()->routeIs('employees.*') ? 'bg-gradient-to-r from-blue-600 to-cyan-400 text-white shadow-xl' : 'bg-slate-50 text-slate-700' }}">
                👥 Karyawan
            </a>

            <a href="{{ route('work-shifts.index') }}"
               class="flex items-center gap-3 px-5 py-4 rounded-2xl font-black
               {{ request()->routeIs('work-shifts.*') ? 'bg-gradient-to-r from-blue-600 to-cyan-400 text-white shadow-xl' : 'bg-slate-50 text-slate-700' }}">
                🕒 Shift
            </a>

            <a href="{{ route('attendances.index') }}"
               class="flex items-center gap-3 px-5 py-4 rounded-2xl font-black
               {{ request()->routeIs('attendances.*') ? 'bg-gradient-to-r from-blue-600 to-cyan-400 text-white shadow-xl' : 'bg-slate-50 text-slate-700' }}">
                ✅ Absensi
            </a>

            <a href="{{ route('face-scan') }}"
               class="flex items-center gap-3 px-5 py-4 rounded-2xl font-black
               {{ request()->routeIs('face-scan') ? 'bg-gradient-to-r from-purple-600 to-fuchsia-500 text-white shadow-xl' : 'bg-slate-50 text-slate-700' }}">
                📷 Scan Wajah
            </a>

            <a href="{{ route('attendance-reports.index') }}"
               class="flex items-center gap-3 px-5 py-4 rounded-2xl font-black
               {{ request()->routeIs('attendance-reports.*') ? 'bg-gradient-to-r from-blue-600 to-cyan-400 text-white shadow-xl' : 'bg-slate-50 text-slate-700' }}">
                📈 Laporan
            </a>

          <a href="{{ route('users.index') }}"
                  class="px-5 py-3 rounded-2xl font-black transition
                       {{ request()->routeIs('users.*') ? 'bg-gradient-to-r from-blue-600 to-cyan-400 text-white shadow-xl' : 'text-slate-600 hover:bg-slate-100' }}">
                   👤 User
            </a>
            <div class="pt-4 border-t border-slate-100">
                <div class="flex items-center gap-3 px-3 py-3">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-600 to-cyan-400 text-white flex items-center justify-center font-black">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>

                    <div>
                        <p class="font-black text-slate-800">{{ Auth::user()->name }}</p>
                        <p class="text-sm text-slate-400">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button class="w-full flex items-center justify-center gap-2 px-5 py-4 rounded-2xl bg-red-50 text-red-600 font-black">
                        Logout
                    </button>
                </form>
            </div>

        </div>
    </div>
</nav>