<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="text-slate-500">Manajemen Unit /</span>
                <span class="text-slate-800">Tambah Baru</span>
            </div>
            <a href="{{ route('unit.index') }}" class="text-sm text-slate-500 hover:text-slate-700 transition-colors">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-100 p-8">

                <div class="mb-8 border-b border-slate-100 pb-6">
                    <h3 class="text-xl font-bold text-slate-800">Registrasi Unit Baru</h3>
                    <p class="text-sm text-slate-500 mt-1">Tambahkan data unit kerja atau divisi baru.</p>
                </div>

                <form action="{{ route('unit.store') }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <label class="block font-medium text-sm text-slate-700 mb-2">Nama Unit</label>
                        <input type="text" name="name"
                            class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                            placeholder="Contoh: Bagian Keuangan" value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-6">
                        <label class="block font-medium text-sm text-slate-700 mb-2">Kode Unit (Opsional)</label>
                        <input type="text" name="code"
                            class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                            placeholder="Contoh: FIN-01" value="{{ old('code') }}">
                    </div>

                    <div class="mb-8">
                        <label class="block font-medium text-sm text-slate-700 mb-2">Status</label>
                        <select name="status"
                            class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                            <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="non-aktif" {{ old('status') == 'non-aktif' ? 'selected' : '' }}>Non-Aktif
                            </option>
                        </select>
                    </div>

                    <div class="flex justify-end items-center gap-4 pt-4 border-t border-slate-100">
                        <a href="{{ route('unit.index') }}"
                            class="text-slate-600 hover:text-slate-800 text-sm font-medium transition-colors">Batal</a>
                        <button type="submit"
                            class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 flex items-center gap-2">
                            <span>Simpan Unit</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>