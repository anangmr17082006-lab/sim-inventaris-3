<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <a href="{{ route('unit.index') }}" class="group flex items-center justify-center w-8 h-8 bg-white border border-slate-200 rounded-lg text-slate-500 hover:text-indigo-600 hover:border-indigo-200 transition-all">
                    <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <span class="text-slate-500">Unit Kerja /</span>
                <span class="text-slate-800 font-bold">Tambah Baru</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50/50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="text-xl font-bold text-slate-800">Registrasi Unit / Divisi</h3>
                    <p class="text-sm text-slate-500 mt-1">Tambahkan unit kerja baru ke dalam sistem.</p>
                </div>

                <form action="{{ route('unit.store') }}" method="POST" class="p-8">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="col-span-2">
                            <label class="block font-bold text-sm text-slate-700 mb-2">Nama Unit Kerja <span class="text-rose-500">*</span></label>
                            <input type="text" name="name" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('name') border-rose-500 @enderror" placeholder="Contoh: Biro Administrasi Umum" value="{{ old('name') }}" required>
                            @error('name') <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block font-bold text-sm text-slate-700 mb-2">Kode Singkatan</label>
                            <input type="text" name="code" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 uppercase transition-colors @error('code') border-rose-500 @enderror" placeholder="Contoh: BAU" value="{{ old('code') }}">
                            @error('code') <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block font-bold text-sm text-slate-700 mb-2">Status</label>
                            <select name="status" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                <option value="aktif">Aktif</option>
                                <option value="non-aktif">Non-Aktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end items-center gap-4 pt-6 border-t border-slate-100">
                        <a href="{{ route('unit.index') }}" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 font-bold text-sm hover:bg-slate-50 transition-all">Batal</a>
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 flex items-center gap-2">
                            <span>Simpan Unit</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>