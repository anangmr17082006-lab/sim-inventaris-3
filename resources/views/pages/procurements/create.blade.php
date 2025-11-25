<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="text-slate-500">Pengadaan /</span>
                <span class="text-slate-800 font-bold">Usulan Baru</span>
            </div>
            <a href="{{ route('pengadaan.index') }}"
                class="text-sm text-slate-500 hover:text-slate-700 transition-colors">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50/50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200 p-8">

                <div class="mb-8 border-b border-slate-100 pb-6 bg-slate-50/50 -mx-8 -mt-8 px-8 py-6">
                    <h3 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Form Usulan Pengadaan
                    </h3>
                    <p class="text-sm text-slate-500 mt-1 ml-7">Ajukan permintaan aset atau barang habis pakai baru.</p>
                </div>

                <form action="{{ route('pengadaan.store') }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <label class="block font-bold text-sm text-slate-700 mb-2">Pengusul</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </span>
                            <input type="text" name="requestor_name"
                                class="w-full pl-10 border-slate-200 rounded-lg bg-slate-50 text-slate-500 cursor-not-allowed shadow-sm font-medium"
                                value="{{ Auth::user()->name }}" readonly>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="col-span-2 md:col-span-1">
                            <label class="block font-bold text-sm text-slate-700 mb-2">Nama Barang <span class="text-rose-500">*</span></label>
                            <input type="text" name="item_name"
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                placeholder="Contoh: Laptop Gaming, Tinta Printer" required>
                            @error('item_name') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <label class="block font-bold text-sm text-slate-700 mb-2">Jenis Barang <span class="text-rose-500">*</span></label>
                            <select name="type"
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                <option value="asset">Aset Tetap (Inventaris)</option>
                                <option value="consumable">Barang Habis Pakai (BHP)</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block font-bold text-sm text-slate-700 mb-2">Jumlah Permintaan <span class="text-rose-500">*</span></label>
                            <input type="number" name="quantity" min="1"
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                placeholder="1" required>
                            @error('quantity') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        {{-- INI YANG SAYA TAMBAHKAN: ESTIMASI HARGA --}}
                        <div>
                            <label class="block font-bold text-sm text-slate-700 mb-2">Estimasi Harga Satuan (Rp)</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 font-bold text-xs">Rp</span>
                                <input type="number" name="unit_price_estimation" min="0"
                                    class="w-full pl-8 border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                    placeholder="0 (Opsional)">
                            </div>
                            <p class="text-xs text-slate-400 mt-1">Kosongkan jika tidak tahu harga pasarnya.</p>
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="block font-bold text-sm text-slate-700 mb-2">Alasan / Spesifikasi Teknis <span class="text-rose-500">*</span></label>
                        <textarea name="description"
                            class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                            rows="4"
                            placeholder="Jelaskan kebutuhan mendesak dan spesifikasi teknis (RAM, Processor, Ukuran, dll)..." required></textarea>
                        @error('description') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end items-center gap-4 pt-6 border-t border-slate-100">
                        <a href="{{ route('pengadaan.index') }}"
                            class="text-slate-600 hover:text-slate-800 text-sm font-bold transition-colors px-4 py-2 rounded-lg hover:bg-slate-50">Batal</a>
                        <button type="submit"
                            class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 flex items-center gap-2">
                            <span>Kirim Usulan</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>