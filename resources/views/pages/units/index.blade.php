<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <span class="text-slate-500">Master Data /</span>
            <span class="text-slate-800 font-bold">Manajemen Unit Kerja</span>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Header & Toolbar --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-slate-900 tracking-tight">Daftar Unit & Divisi</h3>
                    <p class="text-slate-500 text-sm mt-1">Total {{ $units->total() }} unit kerja terdaftar.</p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    {{-- Search Bar --}}
                    <form action="{{ route('unit.index') }}" method="GET" class="relative w-full sm:w-64">
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Cari nama atau kode..."
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm transition-all">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </form>

                    <a href="{{ route('unit.create') }}"
                        class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/30 transition-all flex items-center justify-center gap-2 whitespace-nowrap">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Unit
                    </a>
                </div>
            </div>

            {{-- Table Card --}}
            <div class="bg-white shadow-sm rounded-xl border border-slate-200/60 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500">
                        <thead class="bg-slate-50 text-xs uppercase text-slate-500 font-semibold border-b border-slate-100 tracking-wider">
                            <tr>
                                <th class="px-6 py-4 w-10 text-center">#</th>
                                <th class="px-6 py-4">Nama Unit Kerja</th>
                                <th class="px-6 py-4">Kode Singkatan</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($units as $index => $unit)
                                <tr class="bg-white hover:bg-slate-50/80 transition-colors group">
                                    <td class="px-6 py-4 text-center text-slate-400 text-xs">
                                        {{ $units->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-bold text-slate-800 text-base group-hover:text-indigo-600 transition-colors">
                                            {{ $unit->name }}
                                        </span>
                                        @if($unit->description)
                                            <p class="text-xs text-slate-400 mt-0.5 truncate max-w-xs">{{ $unit->description }}</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($unit->code)
                                            <code class="px-2 py-1 rounded-md bg-slate-100 text-slate-600 font-mono text-xs border border-slate-200">
                                                {{ $unit->code }}
                                            </code>
                                        @else
                                            <span class="text-slate-300">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($unit->status == 'aktif')
                                            <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                                <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                AKTIF
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/20">
                                                <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-rose-500"></span>
                                                NON-AKTIF
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end items-center gap-2">
                                            <a href="{{ route('unit.show', $unit->id) }}" 
                                               class="p-2 rounded-lg text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 border border-transparent hover:border-indigo-100 transition-all"
                                               title="Lihat Detail">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('unit.edit', $unit->id) }}" 
                                               class="p-2 rounded-lg text-slate-400 hover:text-amber-600 hover:bg-amber-50 border border-transparent hover:border-amber-100 transition-all"
                                               title="Edit Unit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            
                                            <form action="{{ route('unit.destroy', $unit->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus unit ini? Data aset yang terhubung mungkin akan terpengaruh.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="p-2 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-transparent hover:border-rose-100 transition-all"
                                                        title="Hapus Unit">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="h-16 w-16 rounded-full bg-slate-50 flex items-center justify-center mb-4 ring-1 ring-slate-100">
                                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                </svg>
                                            </div>
                                            <h3 class="text-slate-800 font-bold text-lg">Tidak ada data unit</h3>
                                            <p class="text-slate-500 mt-1 mb-6 max-w-sm">
                                                Silakan tambahkan unit/divisi baru atau gunakan kata kunci pencarian lain.
                                            </p>
                                            <a href="{{ route('unit.create') }}" class="text-indigo-600 font-bold hover:underline">
                                                + Tambah Unit Baru
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination --}}
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
                    {{ $units->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>