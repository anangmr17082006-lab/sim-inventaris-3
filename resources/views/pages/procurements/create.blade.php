<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="text-slate-500">Pengadaan /</span>
                <span class="text-slate-800">Usulan Baru</span>
            </div>
            <a href="{{ route('pengadaan.index') }}"
                class="text-sm text-slate-500 hover:text-slate-700 transition-colors">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-100 p-8">

                <div class="mb-8 border-b border-slate-100 pb-6">
                    <h3 class="text-xl font-bold text-slate-800">Buat Usulan Pengadaan</h3>
                    <p class="text-sm text-slate-500 mt-1">Ajukan permintaan pengadaan aset atau barang habis pakai
                        baru.</p>
                </div>

                <form action="{{ route('pengadaan.store') }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <label class="block font-medium text-sm text-slate-700 mb-2">Nama Pengusul</label>
                        <input type="text" name="requestor_name"
                            class="w-full border-slate-200 rounded-lg bg-slate-50 text-slate-500 cursor-not-allowed shadow-sm"
                            value="{{ Auth::user()->name }}" readonly>
                        <p class="text-xs text-slate-400 mt-1">Nama pengusul diambil otomatis dari akun login.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block font-medium text-sm text-slate-700 mb-2">Nama Barang</label>
                            <input type="text" name="item_name"
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                placeholder="Contoh: Laptop Gaming, Tinta Printer" required>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-slate-700 mb-2">Jenis Barang</label>
                            <select name="type"
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                <option value="asset">Aset Tetap (Laptop, Meja)</option>
                                <option value="consumable">Habis Pakai (ATK, Obat)</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block font-medium text-sm text-slate-700 mb-2">Jumlah Permintaan</label>
                        <input type="number" name="quantity" min="1"
                            class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                            placeholder="1" required>
                    </div>

                    <div class="mb-8">
                        <label class="block font-medium text-sm text-slate-700 mb-2">Alasan / Spesifikasi</label>
                        <textarea name="description"
                            class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                            rows="4"
                            placeholder="Jelaskan kebutuhan dan spesifikasi teknis barang yang diminta..."></textarea>
                    </div>

                    <div class="flex justify-end items-center gap-4 pt-4 border-t border-slate-100">
                        <a href="{{ route('pengadaan.index') }}"
                            class="text-slate-600 hover:text-slate-800 text-sm font-medium transition-colors">Batal</a>
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