<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <a href="{{ route('transaksi.index') }}" class="group flex items-center justify-center w-8 h-8 bg-white border border-slate-200 rounded-lg text-slate-500 hover:text-rose-600 hover:border-rose-200 transition-all">
                    <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <span class="text-slate-500">Transaksi /</span>
                <span class="text-slate-800 font-bold">Barang Keluar</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50/50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                
                <div class="px-8 py-6 border-b border-slate-100 bg-rose-50/50">
                    <h3 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4m0 0l6-6m-6 6l6 6"></path></svg>
                        Form Permintaan Barang (Keluar)
                    </h3>
                    <p class="text-sm text-slate-500 mt-1 ml-7">Sistem akan otomatis menggunakan stok terlama (FIFO).</p>
                </div>

                <form action="{{ route('transaksi.store') }}" method="POST" class="p-8">
                    @csrf
                    
                    <div class="space-y-6">
                        {{-- Pilih Barang (Induk) --}}
                        <div>
                            <label class="block font-bold text-sm text-slate-700 mb-2">Pilih Barang <span class="text-rose-500">*</span></label>
                            <select name="consumable_id" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-rose-500 focus:border-rose-500 transition-colors" required>
                                <option value="">-- Pilih Barang Habis Pakai --</option>
                                @foreach($consumables as $item)
                                    {{-- Hitung total stok dari semua batch --}}
                                    @php $totalStock = $item->details->sum('current_stock'); @endphp
                                    <option value="{{ $item->id }}">
                                        {{ $item->name }} (Total Stok: {{ $totalStock }} {{ $item->unit }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-slate-400 mt-1">Hanya barang yang memiliki stok tersedia yang muncul di sini.</p>
                            @error('consumable_id') <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>

                        {{-- Jumlah & Tanggal --}}
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="block font-bold text-sm text-slate-700 mb-2">Jumlah Keluar <span class="text-rose-500">*</span></label>
                                <input type="number" name="amount" min="1" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-rose-500 focus:border-rose-500 transition-colors" placeholder="0" required>
                                @error('amount') <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block font-bold text-sm text-slate-700 mb-2">Tanggal Transaksi <span class="text-rose-500">*</span></label>
                                <input type="date" name="date" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-rose-500 focus:border-rose-500 transition-colors" value="{{ date('Y-m-d') }}" required>
                                @error('date') <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- Keterangan --}}
                        <div>
                            <label class="block font-bold text-sm text-slate-700 mb-2">Keperluan / Keterangan</label>
                            <textarea name="notes" rows="3" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-rose-500 focus:border-rose-500 transition-colors" placeholder="Contoh: Permintaan dari Divisi IT untuk kegiatan workshop..."></textarea>
                            @error('notes') <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex justify-end items-center gap-4 pt-6 border-t border-slate-100 mt-6">
                        <a href="{{ route('transaksi.index') }}" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 font-bold text-sm hover:bg-slate-50 transition-all">Batal</a>
                        <button type="submit" class="bg-rose-600 text-white px-6 py-2.5 rounded-lg font-bold hover:bg-rose-700 transition-all shadow-lg shadow-rose-200 flex items-center gap-2">
                            <span>Proses Barang Keluar</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>