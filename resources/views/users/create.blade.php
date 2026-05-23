<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-sky-50 via-white to-cyan-100 p-4 lg:p-8">
        <div class="max-w-3xl mx-auto">

            <div class="hero-animate rounded-[2.5rem] bg-white/90 backdrop-blur-2xl shadow-2xl border border-white p-6 lg:p-10 mb-8">

                <div class="mb-8">
                    <div class="inline-flex px-4 py-2 rounded-full bg-blue-50 text-blue-600 font-black text-sm mb-4">
                        ➕ Tambah User
                    </div>

                    <h1 class="text-4xl lg:text-5xl font-black text-slate-950">
                        Buat Akun Baru
                    </h1>

                    <p class="text-slate-500 mt-3">
                        Tambahkan akun administrator atau operator.
                    </p>
                </div>

                <form action="{{ route('users.store') }}"
                      method="POST"
                      class="space-y-6">

                    @csrf

                    {{-- NAME --}}
                    <div class="input-animate">
                        <label class="block text-slate-700 font-black mb-3">
                            👤 Nama User
                        </label>

                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               placeholder="Masukkan nama user"
                               class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 font-bold text-slate-700 focus:bg-white focus:border-blue-400 focus:ring-blue-400">

                        @error('name')
                            <p class="mt-2 text-red-500 text-sm font-bold">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- EMAIL --}}
                    <div class="input-animate">
                        <label class="block text-slate-700 font-black mb-3">
                            📧 Email
                        </label>

                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               placeholder="admin@email.com"
                               class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 font-bold text-slate-700 focus:bg-white focus:border-blue-400 focus:ring-blue-400">

                        @error('email')
                            <p class="mt-2 text-red-500 text-sm font-bold">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- PASSWORD --}}
                    <div class="input-animate">
                        <label class="block text-slate-700 font-black mb-3">
                            🔒 Password
                        </label>

                        <input type="password"
                               name="password"
                               placeholder="Minimal 6 karakter"
                               class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 font-bold text-slate-700 focus:bg-white focus:border-blue-400 focus:ring-blue-400">

                        @error('password')
                            <p class="mt-2 text-red-500 text-sm font-bold">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- ROLE --}}
                    <div class="input-animate">
                        <label class="block text-slate-700 font-black mb-3">
                            🛡️ Role
                        </label>

                        <select name="role"
                                class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 font-bold text-slate-700 focus:bg-white focus:border-blue-400 focus:ring-blue-400">

                            <option value="admin">Admin</option>
                            <option value="operator">Operator</option>

                        </select>

                        @error('role')
                            <p class="mt-2 text-red-500 text-sm font-bold">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- BUTTON --}}
                    <div class="flex items-center justify-end gap-3 pt-4">

                        <a href="{{ route('users.index') }}"
                           class="px-6 py-4 rounded-2xl bg-slate-100 text-slate-600 font-black hover:bg-slate-200 transition">
                            Batal
                        </a>

                        <button type="submit"
                                class="button-animate magnetic-hover glow-hover px-8 py-4 rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-400 text-white font-black shadow-xl hover:scale-105 transition">

                            Simpan User

                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>