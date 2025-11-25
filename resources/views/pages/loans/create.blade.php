<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="text-slate-500">Sirkulasi /</span>
                <span class="text-slate-800 font-bold">Form Peminjaman</span>
            </div>
            <a href="{{ route('peminjaman.index') }}" class="text-sm text-slate-500 hover:text-slate-700 transition-colors">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50/50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200 p-8">

                <div class="mb-8 border-b border-slate-100 pb-6 bg-slate-50/50 -mx-8 -mt-8 px-8 py-6">
                    <h3 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Form Peminjaman Aset
                    </h3>
                    <p class="text-sm text-slate-500 mt-1 ml-7">Pastikan data peminjam dan aset yang dipilih sudah sesuai.</p>
                </div>

                <form action="{{ route('peminjaman.store') }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <label class="block font-bold text-sm text-slate-700 mb-2">Pilih Aset <span class="text-rose-500">*</span></label>
                        <select name="asset_detail_id" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors" required>
                            <option value="">-- Cari Barang Tersedia --</option>
                            @foreach($assets as $unit)
                                <option value="{{ $unit->id }}">
                                    {{ $unit->inventory->name }} - {{ $unit->model_name }} [{{ $unit->unit_code }}] (Lokasi: {{ $unit->room->name }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-slate-400 mt-1">Hanya menampilkan aset dengan status 'Tersedia' dan kondisi Layak.</p>
                        @error('asset_detail_id') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block font-bold text-sm text-slate-700 mb-2">Nama Peminjam <span class="text-rose-500">*</span></label>
                            <input type="text" name="borrower_name" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="Nama Lengkap" required>
                            @error('borrower_name') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block font-bold text-sm text-slate-700 mb-2">NIM / NIP <span class="text-rose-500">*</span></label>
                            <input type="text" name="borrower_id" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="Nomor Identitas" required>
                            @error('borrower_id') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block font-bold text-sm text-slate-700 mb-2">Tanggal Pinjam <span class="text-rose-500">*</span></label>
                            <input type="date" name="loan_date" value="{{ date('Y-m-d') }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors" required>
                            @error('loan_date') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block font-bold text-sm text-slate-700 mb-2">Rencana Kembali <span class="text-rose-500">*</span></label>
                            <input type="date" name="return_date_plan" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors" required>
                            @error('return_date_plan') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="block font-bold text-sm text-slate-700 mb-2">Keperluan / Catatan</label>
                        <textarea name="notes" rows="3" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="Contoh: Untuk kegiatan seminar..."></textarea>
                        @error('notes') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end items-center gap-4 pt-6 border-t border-slate-100">
                        <a href="{{ route('peminjaman.index') }}" class="text-slate-600 hover:text-slate-800 text-sm font-bold transition-colors px-4 py-2 rounded-lg hover:bg-slate-50">Batal</a>
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 flex items-center gap-2">
                            <span>Simpan Peminjaman</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>