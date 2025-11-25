<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="text-slate-500">Manajemen Pengguna /</span>
                <span class="text-slate-800">Edit Data</span>
            </div>
            <a href="{{ route('users.index') }}" class="text-sm text-slate-500 hover:text-slate-700 transition-colors">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-100 p-8">

                <div class="mb-8 border-b border-slate-100 pb-6">
                    <h3 class="text-xl font-bold text-slate-800">Edit Data Pengguna</h3>
                    <p class="text-sm text-slate-500 mt-1">Perbarui informasi akun dan hak akses pengguna.</p>
                </div>

                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="mb-6">
                        <label class="block font-medium text-sm text-slate-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ $user->name }}"
                            class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                            required>
                    </div>

                    <div class="mb-6">
                        <label class="block font-medium text-sm text-slate-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}"
                            class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                            required>
                    </div>

                    <div class="mb-8">
                        <label class="block font-medium text-sm text-slate-700 mb-2">Role (Hak Akses)</label>
                        <select name="role"
                            class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User Biasa</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrator</option>
                        </select>
                    </div>

                    <div class="bg-slate-50 rounded-xl p-6 border border-slate-100 mb-8">
                        <h4 class="text-sm font-bold text-slate-800 mb-1">Ganti Password (Opsional)</h4>
                        <p class="text-xs text-slate-500 mb-4">Biarkan kosong jika tidak ingin mengubah password.</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <input type="password" name="password" placeholder="Password Baru"
                                    class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                            </div>
                            <div>
                                <input type="password" name="password_confirmation" placeholder="Ulangi Password Baru"
                                    class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end items-center gap-4 pt-4 border-t border-slate-100">
                        <a href="{{ route('users.index') }}"
                            class="text-slate-600 hover:text-slate-800 text-sm font-medium transition-colors">Batal</a>
                        <button type="submit"
                            class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 flex items-center gap-2">
                            <span>Perbarui Data</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>