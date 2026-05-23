<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-sky-50 via-white to-cyan-100 p-4 lg:p-8">
        <div class="max-w-7xl mx-auto">

            @if (session('success'))
                <div class="mb-6 rounded-2xl bg-green-100 text-green-700 px-5 py-4 font-black">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 rounded-2xl bg-red-100 text-red-700 px-5 py-4 font-black">
                    ❌ {{ session('error') }}
                </div>
            @endif

            <div class="hero-animate rounded-[2.5rem] bg-white/80 backdrop-blur-2xl shadow-2xl border border-white p-6 lg:p-10 mb-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <div class="inline-flex px-4 py-2 rounded-full bg-blue-50 text-blue-600 font-black text-sm mb-4">
                            👤 Manajemen User
                        </div>

                        <h1 class="text-4xl lg:text-6xl font-black text-slate-950">
                            Data User
                        </h1>

                        <p class="text-slate-500 mt-4">
                            Kelola akun admin dan operator aplikasi.
                        </p>
                    </div>

                    <a href="{{ route('users.create') }}"
                       class="button-animate px-6 py-4 rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-400 text-white font-black shadow-xl text-center">
                        + Tambah User
                    </a>
                </div>
            </div>

            <div class="table-animate rounded-[2.5rem] bg-white/90 shadow-xl border border-white overflow-hidden">
                <div class="p-6 border-b border-slate-100">
                    <h2 class="text-2xl font-black text-slate-900">Daftar User</h2>
                    <p class="text-slate-400 mt-1">Akun yang dapat login ke sistem.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 text-slate-500 text-sm">
                            <tr>
                                <th class="px-6 py-4 text-left">User</th>
                                <th class="px-6 py-4 text-left">Email</th>
                                <th class="px-6 py-4 text-left">Role</th>
                                <th class="px-6 py-4 text-left">Tanggal Dibuat</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse ($users as $user)
                                <tr class="hover:bg-blue-50/50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-600 to-cyan-400 text-white flex items-center justify-center font-black shadow">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>

                                            <div>
                                                <p class="font-black text-slate-800">{{ $user->name }}</p>
                                                <p class="text-sm text-slate-400">ID: {{ $user->id }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 font-bold text-slate-600">
                                        {{ $user->email }}
                                    </td>

                                    <td class="px-6 py-4">
                                        @if ($user->role === 'admin')
                                            <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-600 text-xs font-black">
                                                Admin
                                            </span>
                                        @else
                                            <span class="px-3 py-1 rounded-full bg-purple-100 text-purple-600 text-xs font-black">
                                                Operator
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-slate-500 font-bold">
                                        {{ $user->created_at->format('d M Y') }}
                                    </td>

                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('users.edit', $user) }}"
                                               class="px-4 py-2 rounded-2xl bg-blue-50 text-blue-600 font-black hover:bg-blue-100 transition">
                                                Edit
                                            </a>

                                            <form action="{{ route('users.destroy', $user) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                                @csrf
                                                @method('DELETE')

                                                <button class="px-4 py-2 rounded-2xl bg-red-50 text-red-600 font-black hover:bg-red-100 transition">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-20 text-center">
                                        <div class="text-6xl mb-4">👤</div>
                                        <h3 class="text-2xl font-black text-slate-800">Belum ada user</h3>
                                        <p class="text-slate-400 mt-2">Tambahkan akun login pertama.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-6">
                    {{ $users->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>