<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <span class="text-slate-500">Inventaris /</span>
            <span class="text-slate-800 font-bold capitalize">{{ $category->name }}</span>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- HEADER & TOOLBAR (KAMU LUPA SEARCH BAR DI SINI) --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-slate-900 tracking-tight">Data Induk Aset</h3>
                    <p class="text-slate-500 text-sm mt-1">Daftar tipe barang kategori {{ $category->name }}.</p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    {{-- SEARCH FORM --}}
                    <form action="{{ route('inventaris.items', $category->id) }}" method="GET" class="relative w-full sm:w-64">
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Cari merk atau nama..."
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm transition-all">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                    </form>

                    <a href="{{ route('inventaris.create', $category->id) }}"
                        class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Barang Baru
                    </a>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500">
                        <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100 font-bold tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Nama Aset & Kode</th>
                                <th class="px-6 py-4 text-center">Total Unit</th>
                                <th class="px-6 py-4">Kondisi Fisik</th>
                                <th class="px-6 py-4">Keterangan</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($items as $item)
                                <tr class="bg-white hover:bg-slate-50 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-800 text-base group-hover:text-indigo-600 transition-colors">{{ $item->name }}</div>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-xs font-mono bg-slate-100 text-slate-500 px-1.5 py-0.5 rounded border border-slate-200">
                                                {{ $item->brand ?? 'No Brand' }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        @if($item->total_unit > 0)
                                            <span class="bg-indigo-50 text-indigo-700 text-sm font-bold px-3 py-1 rounded-full border border-indigo-100">
                                                {{ $item->total_unit }} Unit
                                            </span>
                                        @else
                                            <span class="text-slate-400 text-xs italic">0 Unit</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">
                                        {{-- Statistik Kondisi (Code kamu sudah bagus di sini, saya rapikan dikit) --}}
                                        <div class="flex gap-2">
                                            @if($item->baik > 0)
                                            <div class="flex flex-col items-center p-1 bg-emerald-50 rounded border border-emerald-100 min-w-[40px]" title="Kondisi Baik">
                                                <span class="text-[9px] text-emerald-600 font-bold uppercase">Baik</span>
                                                <span class="text-sm font-bold text-emerald-700">{{ $item->baik }}</span>
                                            </div>
                                            @endif

                                            @if($item->rusak_ringan > 0)
                                            <div class="flex flex-col items-center p-1 bg-amber-50 rounded border border-amber-100 min-w-[40px]" title="Rusak Ringan">
                                                <span class="text-[9px] text-amber-600 font-bold uppercase">Rgn</span>
                                                <span class="text-sm font-bold text-amber-700">{{ $item->rusak_ringan }}</span>
                                            </div>
                                            @endif

                                            @if($item->rusak_berat > 0)
                                            <div class="flex flex-col items-center p-1 bg-rose-50 rounded border border-rose-100 min-w-[40px]" title="Rusak Berat">
                                                <span class="text-[9px] text-rose-600 font-bold uppercase">Brt</span>
                                                <span class="text-sm font-bold text-rose-700">{{ $item->rusak_berat }}</span>
                                            </div>
                                            @endif
                                            
                                            @if($item->total_unit == 0)
                                                <span class="text-slate-400 text-xs">-</span>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-slate-500 text-xs italic max-w-xs truncate">
                                        {{ $item->description ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            {{-- Tombol Edit Induk --}}
                                            <a href="{{ route('inventaris.edit', $item->id) }}" class="p-2 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit Data Induk">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </a>

                                            {{-- Tombol Lihat Unit (Primary) --}}
                                            <a href="{{ route('asset.index', $item->id) }}" 
                                               class="inline-flex items-center px-3 py-1.5 text-xs font-bold text-indigo-600 bg-indigo-50 border border-indigo-200 rounded-lg hover:bg-indigo-100 hover:text-indigo-800 transition-colors gap-1">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                Unit Fisik
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center opacity-50">
                                            <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                            <h3 class="text-slate-800 font-bold">Tidak ada data</h3>
                                            <p class="text-slate-500 text-sm mt-1">Coba kata kunci lain atau tambahkan aset baru.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- PAGINATION (KAMU LUPA INI) --}}
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
                    {{ $items->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>