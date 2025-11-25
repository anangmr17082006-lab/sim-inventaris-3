<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="text-slate-500">BHP /</span>
                <span class="text-slate-500">{{ $category->name }} /</span>
                <span class="text-slate-800">Tambah Baru</span>
            </div>
            <a href="{{ route('bhp.items', $category->id) }}"
                class="text-sm text-slate-500 hover:text-slate-700 transition-colors">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-100 p-8">

                <div class="mb-8 border-b border-slate-100 pb-6">
                    <h3 class="text-xl font-bold text-slate-800">Registrasi Barang Habis Pakai</h3>
                    <p class="text-sm text-slate-500 mt-1">Data induk untuk barang yang stoknya akan terus dipantau
                        (Obat, ATK, dll).</p>
                </div>

                <form action="{{ route('bhp.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="category_id" value="{{ $category->id }}">

                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div class="col-span-2">
                            <label class="block font-medium text-sm text-slate-700 mb-2">Nama Barang</label>
                            <input type="text" name="name"
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                placeholder="Contoh: Kertas HVS A4 80gr" required>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-slate-700 mb-2">Satuan</label>
                            <input type="text" name="unit"
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                placeholder="Rim / Box / Pcs" required>
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="block font-medium text-sm text-slate-700 mb-2">Keterangan</label>
                        <textarea name="notes" rows="3"
                            class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"></textarea>
                    </div>

                    <div class="flex justify-end items-center gap-4 pt-4 border-t border-slate-100">
                        <a href="{{ route('bhp.items', $category->id) }}"
                            class="text-slate-600 hover:text-slate-800 text-sm font-medium transition-colors">Batal</a>
                        <button type="submit"
                            class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 flex items-center gap-2">
                            <span>Simpan & Input Stok Awal</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>