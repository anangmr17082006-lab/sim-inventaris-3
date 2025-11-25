<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <a href="{{ route('inventaris.items', $category->id) }}" class="group flex items-center justify-center w-8 h-8 bg-white border border-slate-200 rounded-lg text-slate-500 hover:text-indigo-600 hover:border-indigo-200 transition-all">
                    <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <span class="text-slate-500">Inventaris /</span>
                <span class="text-slate-800 font-bold capitalize">{{ $category->name }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50/50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="text-xl font-bold text-slate-800">Buat Data Induk Barang</h3>
                    <p class="text-sm text-slate-500 mt-1">Mendaftarkan jenis barang baru ke dalam kategori {{ $category->name }}.</p>
                </div>

                <form action="{{ route('inventaris.store') }}" method="POST" class="p-8">
                    @csrf
                    {{-- Kirim Category ID secara sembunyi --}}
                    <input type="hidden" name="category_id" value="{{ $category->id }}">

                    <div class="space-y-6">
                        {{-- Nama Barang --}}
                        <div>
                            <label class="block font-bold text-sm text-slate-700 mb-2">Nama Barang <span class="text-rose-500">*</span></label>
                            <input type="text" name="name" 
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('name') border-rose-500 @enderror"
                                placeholder="Contoh: Laptop Dell Latitude 5420" 
                                value="{{ old('name') }}" required autofocus>
                            <p class="text-xs text-slate-400 mt-1">Nama umum barang. Jangan masukkan Nomor Seri di sini.</p>
                            @error('name') <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>

                        {{-- Merk / Brand --}}
                        <div>
                            <label class="block font-bold text-sm text-slate-700 mb-2">Merk / Brand</label>
                            <input type="text" name="brand" 
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                placeholder="Contoh: Dell, Epson, Honda" 
                                value="{{ old('brand') }}">
                        </div>

                        {{-- Deskripsi --}}
                        <div>
                            <label class="block font-bold text-sm text-slate-700 mb-2">Deskripsi / Spesifikasi</label>
                            <textarea name="description" rows="4" 
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                placeholder="Contoh: Processor i5 Gen 11, RAM 16GB, SSD 512GB...">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="flex justify-end items-center gap-4 pt-6 border-t border-slate-100 mt-6">
                        <a href="{{ route('inventaris.items', $category->id) }}" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 font-bold text-sm hover:bg-slate-50 transition-all">Batal</a>
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 flex items-center gap-2">
                            <span>Simpan & Lanjut</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>