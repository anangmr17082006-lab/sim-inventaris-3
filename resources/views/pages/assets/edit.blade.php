<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <a href="{{ route('asset.index', $assetDetail->inventory_id) }}" class="group flex items-center justify-center w-8 h-8 bg-white border border-slate-200 rounded-lg text-slate-500 hover:text-indigo-600 hover:border-indigo-200 transition-all">
                    <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <div class="flex flex-col">
                    <span class="text-slate-500 text-xs uppercase font-bold tracking-wider">Edit Unit Fisik</span>
                    <span class="text-slate-800 font-bold text-lg leading-none">{{ $assetDetail->unit_code }}</span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50/50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                
                <div class="px-8 py-6 border-b border-slate-100 bg-amber-50/50">
                    <h3 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Perbarui Informasi Unit
                    </h3>
                    <p class="text-sm text-slate-500 mt-1 ml-7">Ubah lokasi, kondisi, atau spesifikasi unit ini.</p>
                </div>

                <form action="{{ route('asset.update', $assetDetail->id) }}" method="POST" class="p-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        
                        {{-- Kode Unit (Read Only) --}}
                        <div>
                            <label class="block font-bold text-sm text-slate-500 mb-2">Kode Aset (Tidak bisa diubah)</label>
                            <input type="text" value="{{ $assetDetail->unit_code }}" class="w-full border-slate-200 bg-slate-100 text-slate-500 rounded-lg shadow-sm font-mono" readonly>
                        </div>

                        {{-- Model Name --}}
                        <div>
                            <label class="block font-bold text-sm text-slate-700 mb-2">Model / Spesifikasi <span class="text-rose-500">*</span></label>
                            <input type="text" name="model_name" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors" value="{{ old('model_name', $assetDetail->model_name) }}" required>
                            @error('model_name') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Kondisi --}}
                        <div>
                            <label class="block font-bold text-sm text-slate-700 mb-2">Kondisi Saat Ini <span class="text-rose-500">*</span></label>
                            <select name="condition" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="baik" {{ old('condition', $assetDetail->condition) == 'baik' ? 'selected' : '' }}>Baik</option>
                                <option value="rusak_ringan" {{ old('condition', $assetDetail->condition) == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                <option value="rusak_berat" {{ old('condition', $assetDetail->condition) == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                            </select>
                        </div>

                        {{-- Lokasi --}}
                        <div>
                            <label class="block font-bold text-sm text-slate-700 mb-2">Lokasi Penempatan <span class="text-rose-500">*</span></label>
                            <select name="room_id" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                @foreach($rooms as $r)
                                    <option value="{{ $r->id }}" {{ old('room_id', $assetDetail->room_id) == $r->id ? 'selected' : '' }}>
                                        {{ $r->name }} ({{ $r->unit->name ?? 'Umum' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Sumber Dana --}}
                        <div>
                            <label class="block font-bold text-sm text-slate-700 mb-2">Sumber Dana <span class="text-rose-500">*</span></label>
                            <select name="funding_source_id" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                @foreach($fundings as $f)
                                    <option value="{{ $f->id }}" {{ old('funding_source_id', $assetDetail->funding_source_id) == $f->id ? 'selected' : '' }}>
                                        {{ $f->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Harga --}}
                        <div>
                            <label class="block font-bold text-sm text-slate-700 mb-2">Harga Perolehan (Rp)</label>
                            <input type="number" name="price" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('price', $assetDetail->price) }}">
                        </div>

                        {{-- Tanggal-tanggal --}}
                        <div>
                            <label class="block font-bold text-sm text-slate-700 mb-2">Tanggal Beli</label>
                            <input type="date" name="purchase_date" class="w-full border-slate-300 rounded-lg" value="{{ old('purchase_date', $assetDetail->purchase_date) }}">
                        </div>
                        <div>
                            <label class="block font-bold text-sm text-slate-700 mb-2">Perbaikan Terakhir</label>
                            <input type="date" name="repair_date" class="w-full border-slate-300 rounded-lg" value="{{ old('repair_date', $assetDetail->repair_date) }}">
                        </div>
                        
                        {{-- Notes --}}
                        <div class="col-span-1 md:col-span-2">
                            <label class="block font-bold text-sm text-slate-700 mb-2">Keterangan / Serial Number</label>
                            <textarea name="notes" rows="2" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('notes', $assetDetail->notes) }}</textarea>
                        </div>
                    </div>

                    <div class="flex justify-end items-center gap-4 pt-6 border-t border-slate-100">
                        <a href="{{ route('asset.index', $assetDetail->inventory_id) }}" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 font-bold text-sm hover:bg-slate-50 transition-all">Batal</a>
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>