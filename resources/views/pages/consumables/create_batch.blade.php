<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="text-slate-500">BHP /</span>
                <span class="text-slate-500">{{ $consumable->name }} /</span>
                <span class="text-slate-800">Input Stok Masuk</span>
            </div>
            <a href="{{ route('consumable.detail', $consumable->id) }}"
                class="text-sm text-slate-500 hover:text-slate-700 transition-colors">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div
                class="mb-6 bg-indigo-50 border border-indigo-200 p-6 rounded-xl flex flex-col md:flex-row justify-between items-center gap-4 shadow-sm">
                <div>
                    <span class="text-xs font-bold text-indigo-600 uppercase tracking-wider">Barang</span>
                    <div class="font-bold text-slate-800 text-lg">{{ $consumable->name }}</div>
                </div>
                <div>
                    <span class="text-xs font-bold text-indigo-600 uppercase tracking-wider">Satuan</span>
                    <div class="font-bold text-slate-800 text-lg">{{ $consumable->unit }}</div>
                </div>
                <div>
                    <span class="text-xs font-bold text-indigo-600 uppercase tracking-wider">Total Stok Saat Ini</span>
                    <div class="font-bold text-slate-800 text-lg">{{ $consumable->details->sum('current_stock') }}</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-100 p-8">
                <div class="mb-8 border-b border-slate-100 pb-6">
                    <h3 class="text-xl font-bold text-slate-800">Registrasi Batch Kedatangan</h3>
                    <p class="text-sm text-slate-500 mt-1">Catat stok masuk baru beserta detail sumber dana dan lokasi
                        penyimpanan.</p>
                </div>

                <form action="{{ route('consumable.storeDetail') }}" method="POST">
                    @csrf
                    <input type="hidden" name="consumable_id" value="{{ $consumable->id }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                        <div>
                            <div class="mb-6">
                                <label class="block font-medium text-sm text-slate-700 mb-2">Merk / Tipe /
                                    Vendor</label>
                                <input type="text" name="model_name"
                                    class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                    placeholder="Contoh: Sanbe / Sidu" required>
                            </div>

                            <div class="mb-6">
                                <label class="block font-medium text-sm text-slate-700 mb-2">Jumlah Masuk
                                    ({{ $consumable->unit }})</label>
                                <input type="number" name="initial_stock"
                                    class="w-full border-slate-300 rounded-lg shadow-sm font-bold text-indigo-600 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                    placeholder="0" min="1" required>
                            </div>

                            <div class="mb-6">
                                <label class="block font-medium text-sm text-slate-700 mb-2">Tanggal Kadaluarsa
                                    (Exp)</label>
                                <input type="date" name="expiry_date"
                                    class="w-full border-slate-300 rounded-lg shadow-sm text-slate-600 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                <p class="text-xs text-slate-400 mt-1">*Kosongkan jika tidak ada expired (misal ATK)</p>
                            </div>
                        </div>

                        <div>
                            <div class="mb-6">
                                <label class="block font-medium text-sm text-slate-700 mb-2">Sumber Dana</label>
                                <select name="funding_source_id"
                                    class="w-full border-slate-300 rounded-lg shadow-sm bg-slate-50 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                    required>
                                    <option value="">-- Pilih Sumber --</option>
                                    @foreach($fundings as $f)
                                        <option value="{{ $f->id }}">{{ $f->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-6">
                                <label class="block font-medium text-sm text-slate-700 mb-2">Lokasi Penyimpanan</label>
                                <select name="room_id"
                                    class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                    required>
                                    <option value="">-- Pilih Ruangan --</option>
                                    @foreach($rooms as $r)
                                        <option value="{{ $r->id }}">{{ $r->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-6">
                                <label class="block font-medium text-sm text-slate-700 mb-2">Keterangan</label>
                                <input type="text" name="notes"
                                    class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                    placeholder="Opsional">
                            </div>
                        </div>

                    </div>

                    <div class="flex justify-end items-center gap-4 mt-8 pt-6 border-t border-slate-100">
                        <a href="{{ route('consumable.detail', $consumable->id) }}"
                            class="text-slate-600 hover:text-slate-800 text-sm font-medium transition-colors">Batal</a>
                        <button type="submit"
                            class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Simpan Stok Masuk
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>