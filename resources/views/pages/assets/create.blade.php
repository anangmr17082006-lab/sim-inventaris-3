<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <a href="{{ route('asset.index', $inventory->id) }}" class="group flex items-center justify-center w-8 h-8 bg-white border border-slate-200 rounded-lg text-slate-500 hover:text-indigo-600 hover:border-indigo-200 transition-all">
                    <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <span class="text-slate-500">Unit Fisik /</span>
                <span class="text-slate-800 font-bold">Tambah Baru</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50/50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                
                <div class="px-8 py-6 border-b border-slate-100 bg-indigo-50/50">
                    <h3 class="text-xl font-bold text-slate-800">Registrasi Unit: {{ $inventory->name }}</h3>
                    <p class="text-sm text-slate-500 mt-1">Kode aset akan di-generate otomatis oleh sistem.</p>
                </div>

                <form action="{{ route('asset.store') }}" method="POST" class="p-8">
                    @csrf
                    <input type="hidden" name="inventory_id" value="{{ $inventory->id }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        
                        <div class="col-span-2">
                            <label class="block text-xs font-bold text-slate-700 mb-1">Model / Spesifikasi Detail <span class="text-rose-500">*</span></label>
                            <input type="text" name="model_name" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500" placeholder="Cth: Warna Hitam, RAM 8GB" required>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Lokasi Penempatan <span class="text-rose-500">*</span></label>
                            <select name="room_id" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500" required>
                                <option value="">-- Pilih Ruangan --</option>
                                @foreach($rooms as $r)
                                    <option value="{{ $r->id }}">{{ $r->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Sumber Dana <span class="text-rose-500">*</span></label>
                            <select name="funding_source_id" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500" required>
                                <option value="">-- Pilih Sumber --</option>
                                @foreach($fundings as $f)
                                    <option value="{{ $f->id }}">{{ $f->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Kondisi Awal</label>
                            <select name="condition" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500">
                                <option value="baik">Baik</option>
                                <option value="rusak_ringan">Rusak Ringan</option>
                                <option value="rusak_berat">Rusak Berat</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Beli</label>
                            <input type="date" name="purchase_date" class="w-full border-slate-300 rounded-lg shadow-sm" value="{{ date('Y-m-d') }}">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Harga (Rp)</label>
                            <input type="number" name="price" class="w-full border-slate-300 rounded-lg shadow-sm" placeholder="0">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Keterangan (SN)</label>
                            <input type="text" name="notes" class="w-full border-slate-300 rounded-lg shadow-sm" placeholder="Serial Number...">
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 pt-6 border-t border-slate-100">
                        <a href="{{ route('asset.index', $inventory->id) }}" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 font-bold text-sm hover:bg-slate-50">Batal</a>
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            Simpan Unit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>