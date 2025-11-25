<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="text-slate-500">Transaksi /</span>
                <span class="text-slate-800">Catat Barang Keluar</span>
            </div>
            <a href="{{ route('transaksi.index') }}"
                class="text-sm text-slate-500 hover:text-slate-700 transition-colors">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-100 p-8">

                <div class="mb-8 border-b border-slate-100 pb-6">
                    <h3 class="text-xl font-bold text-slate-800">Form Pengambilan Barang (FIFO)</h3>
                    <p class="text-sm text-slate-500 mt-1">Sistem otomatis mengambil stok dari batch terlama.</p>
                </div>

                <form action="{{ route('transaksi.store') }}" method="POST">
                    @csrf

                    @if ($errors->any())
                        <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-lg relative">
                            <strong class="font-bold flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Terjadi Kesalahan!
                            </strong>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-6">
                        <label class="block font-medium text-sm text-slate-700 mb-2">Pilih Barang (BHP)</label>

                        <select name="consumable_id"
                            class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-rose-500 focus:border-rose-500 transition-colors"
                            required>
                            <option value="">-- Cari Nama Barang --</option>
                            @foreach($consumables as $item)
                                @php $totalStock = $item->details->sum('current_stock'); @endphp

                                @if($totalStock > 0)
                                    <option value="{{ $item->id }}">
                                        {{ $item->name }} (Total Stok: {{ $totalStock }} {{ $item->unit }})
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        <p class="text-xs text-slate-500 mt-1 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Stok akan dikurangi dari batch yang masuk paling awal.
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block font-medium text-sm text-slate-700 mb-2">Jumlah Keluar</label>
                            <input type="number" name="amount" min="1"
                                class="w-full border-slate-300 rounded-lg shadow-sm font-bold text-rose-600 focus:ring-rose-500 focus:border-rose-500 transition-colors"
                                required>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-slate-700 mb-2">Tanggal</label>
                            <input type="date" name="date"
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-rose-500 focus:border-rose-500 transition-colors"
                                value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="block font-medium text-sm text-slate-700 mb-2">Keterangan / Keperluan</label>
                        <textarea name="notes" rows="3"
                            class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-rose-500 focus:border-rose-500 transition-colors"
                            placeholder="Contoh: Permintaan ATK untuk acara Seminar" required></textarea>
                    </div>

                    <div class="flex justify-end items-center gap-4 pt-4 border-t border-slate-100">
                        <a href="{{ route('transaksi.index') }}"
                            class="text-slate-600 hover:text-slate-800 text-sm font-medium transition-colors">Batal</a>
                        <button type="submit"
                            class="bg-rose-600 text-white px-6 py-2.5 rounded-lg font-bold hover:bg-rose-700 transition-all shadow-lg shadow-rose-200 flex items-center gap-2">
                            <span>Simpan Transaksi Keluar</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>