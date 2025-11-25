<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <a href="{{ route('ruangan.index') }}" class="group flex items-center justify-center w-8 h-8 bg-white border border-slate-200 rounded-lg text-slate-500 hover:text-indigo-600 hover:border-indigo-200 transition-all">
                    <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <span class="text-slate-500">Manajemen Ruangan /</span>
                <span class="text-slate-800 font-bold">Edit Data</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50/50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                
                {{-- Form Header --}}
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Edit Informasi Ruangan
                    </h3>
                    <p class="text-sm text-slate-500 mt-1 ml-7">Perbarui data nama, lokasi, atau status ruangan.</p>
                </div>

                <form action="{{ route('ruangan.update', $room->id) }}" method="POST" class="p-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        {{-- Nama Ruangan --}}
                        <div class="col-span-2">
                            <label class="block font-bold text-sm text-slate-700 mb-2">Nama Ruangan <span class="text-rose-500">*</span></label>
                            <input type="text" name="name" 
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('name') border-rose-500 @enderror"
                                value="{{ old('name', $room->name) }}" required>
                            @error('name')
                                <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Lokasi --}}
                        <div>
                            <label class="block font-bold text-sm text-slate-700 mb-2">Lokasi Fisik <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </span>
                                <input type="text" name="location" 
                                    class="pl-10 w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('location') border-rose-500 @enderror"
                                    value="{{ old('location', $room->location) }}" required>
                            </div>
                            @error('location')
                                <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Unit --}}
                        <div>
                            <label class="block font-bold text-sm text-slate-700 mb-2">Kepemilikan Unit <span class="text-rose-500">*</span></label>
                            <select name="unit_id" 
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('unit_id') border-rose-500 @enderror" required>
                                <option value="">-- Pilih Unit / Prodi --</option>
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}" {{ old('unit_id', $room->unit_id) == $unit->id ? 'selected' : '' }}>
                                        {{ $unit->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('unit_id')
                                <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                         {{-- Status (Radio Buttons untuk UX lebih cepat) --}}
                         <div class="col-span-2">
                            <label class="block font-bold text-sm text-slate-700 mb-2">Status Saat Ini</label>
                            <div class="grid grid-cols-3 gap-4">
                                @foreach(['tersedia' => ['emerald', 'Tersedia'], 'digunakan' => ['amber', 'Digunakan'], 'perbaikan' => ['rose', 'Perbaikan']] as $key => $val)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="status" value="{{ $key }}" class="peer sr-only" {{ old('status', $room->status) == $key ? 'checked' : '' }}>
                                        <div class="text-center p-3 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 peer-checked:border-{{ $val[0] }}-500 peer-checked:bg-{{ $val[0] }}-50 peer-checked:text-{{ $val[0] }}-700 transition-all">
                                            <div class="font-bold text-sm">{{ $val[1] }}</div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('status')
                                <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end items-center gap-4 pt-6 border-t border-slate-100">
                        <a href="{{ route('ruangan.index') }}" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 font-bold text-sm hover:bg-slate-50 transition-all">Batal</a>
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Perbarui Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>