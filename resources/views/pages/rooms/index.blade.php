<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <span class="text-slate-500">Master Data /</span>
            <span class="text-slate-800 font-bold">Manajemen Ruangan</span>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Header Section & Toolbar --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-slate-900 tracking-tight">Daftar Ruangan</h3>
                    <p class="text-slate-500 text-sm mt-1">Total {{ $rooms->total() }} ruangan terdaftar dalam sistem.</p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    {{-- Search Form --}}
                    <form action="{{ route('ruangan.index') }}" method="GET" class="relative w-full sm:w-64">
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Cari nama atau lokasi..."
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </form>

                    <a href="{{ route('ruangan.create') }}"
                        class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/30 transition-all flex items-center justify-center gap-2 whitespace-nowrap">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Ruangan
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
                                <th class="px-6 py-4">Informasi Ruangan</th>
                                <th class="px-6 py-4">Unit / Kepemilikan</th>
                                <th class="px-6 py-4 text-center">Kapasitas</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($rooms as $index => $room)
                                <tr class="bg-white hover:bg-slate-50/80 transition-colors group">
                                    <td class="px-6 py-4 text-center text-slate-400 text-xs">
                                        {{ $rooms->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-slate-800 text-base mb-0.5 group-hover:text-indigo-600 transition-colors">
                                                {{ $room->name }}
                                            </span>
                                            <div class="flex items-center gap-1 text-slate-500 text-xs">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                {{ $room->location }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($room->unit)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 text-xs font-medium border border-slate-200">
                                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                                {{ $room->unit->name }}
                                            </span>
                                        @else
                                            <span class="text-slate-400 italic text-xs">- Umum -</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        {{-- Asumsi ada kolom capacity, jika tidak hapus td ini --}}
                                        <span class="text-slate-600 font-mono font-medium bg-slate-100 px-2 py-0.5 rounded text-xs">
                                            {{ $room->capacity ?? '-' }} Org
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusClasses = [
                                                'tersedia' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
                                                'digunakan' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
                                                'perbaikan' => 'bg-rose-50 text-rose-700 ring-rose-600/20',
                                            ];
                                            $currentClass = $statusClasses[$room->status] ?? 'bg-slate-50 text-slate-700 ring-slate-600/20';
                                        @endphp
                                        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $currentClass }}">
                                            <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-current opacity-60"></span>
                                            {{ strtoupper($room->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end items-center gap-2">
                                            {{-- Detail Button --}}
                                            <a href="{{ route('ruangan.show', $room->id) }}" 
                                               class="p-2 rounded-lg text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 border border-transparent hover:border-indigo-100 transition-all"
                                               title="Lihat Detail">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>

                                            {{-- Edit Button --}}
                                            <a href="{{ route('ruangan.edit', $room->id) }}" 
                                               class="p-2 rounded-lg text-slate-400 hover:text-amber-600 hover:bg-amber-50 border border-transparent hover:border-amber-100 transition-all"
                                               title="Edit Data">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>

                                            {{-- Delete Button --}}
                                            <form action="{{ route('ruangan.destroy', $room->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ruangan ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="p-2 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-transparent hover:border-rose-100 transition-all"
                                                        title="Hapus Permanen">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="h-16 w-16 rounded-full bg-slate-50 flex items-center justify-center mb-4 ring-1 ring-slate-100">
                                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                </svg>
                                            </div>
                                            <h3 class="text-slate-800 font-bold text-lg">Tidak ada data ruangan</h3>
                                            <p class="text-slate-500 mt-1 mb-6 max-w-sm">
                                                Data ruangan belum ditambahkan atau tidak ditemukan berdasarkan pencarian Anda.
                                            </p>
                                            <a href="{{ route('ruangan.create') }}" class="text-indigo-600 font-bold hover:underline">
                                                + Tambah Ruangan Baru
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination Styling --}}
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
                    {{ $rooms->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>