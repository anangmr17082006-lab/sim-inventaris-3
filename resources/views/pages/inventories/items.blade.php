<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <span class="text-slate-500">Inventaris /</span>
            <span class="text-slate-800">{{ $category->name }}</span>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-slate-800">Daftar Aset: {{ $category->name }}</h3>
                    <p class="text-slate-500 mt-1">Kelola data induk aset tetap di kategori ini.</p>
                </div>
                <a href="{{ route('inventaris.create', $category->id) }}"
                    class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Aset Baru
                </a>
            </div>

            <div class="bg-white shadow-sm rounded-xl border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500">
                        <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-4 font-bold">Nama Aset</th>
                                <th class="px-6 py-4 text-center font-bold">Total Unit</th>
                                <th class="px-6 py-4 font-bold">Rincian Kondisi</th>
                                <th class="px-6 py-4 font-bold">Keterangan</th>
                                <th class="px-6 py-4 font-bold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($items as $item)
                                <tr class="bg-white hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-800 text-lg">{{ $item->name }}</div>
                                        <div class="text-xs text-slate-400 mt-0.5">Kode:
                                            {{ $item->category->code }}-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</div>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="bg-slate-100 text-slate-700 text-sm font-bold px-3 py-1 rounded-full border border-slate-200">
                                            {{ $item->total_unit }} Unit
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex gap-2">
                                            <div
                                                class="flex flex-col items-center p-1.5 bg-emerald-50 rounded-lg border border-emerald-100 min-w-[50px]">
                                                <span class="text-[10px] text-emerald-600 font-bold uppercase">Baik</span>
                                                <span class="text-base font-bold text-emerald-700">{{ $item->baik }}</span>
                                            </div>

                                            <div
                                                class="flex flex-col items-center p-1.5 bg-amber-50 rounded-lg border border-amber-100 min-w-[50px]">
                                                <span class="text-[10px] text-amber-600 font-bold uppercase">Ringan</span>
                                                <span
                                                    class="text-base font-bold text-amber-700">{{ $item->rusak_ringan }}</span>
                                            </div>

                                            <div
                                                class="flex flex-col items-center p-1.5 bg-rose-50 rounded-lg border border-rose-100 min-w-[50px]">
                                                <span class="text-[10px] text-rose-600 font-bold uppercase">Berat</span>
                                                <span
                                                    class="text-base font-bold text-rose-700">{{ $item->rusak_berat }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-slate-500 italic max-w-xs truncate">
                                        {{ $item->description ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('asset.index', $item->id) }}"
                                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-indigo-600 bg-indigo-50 border border-indigo-200 rounded-lg hover:bg-indigo-100 focus:ring-4 focus:outline-none focus:ring-indigo-100 transition-colors">
                                            Lihat Detail
                                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="h-12 w-12 rounded-full bg-slate-100 flex items-center justify-center mb-3">
                                                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                                    </path>
                                                </svg>
                                            </div>
                                            <p class="text-slate-500 font-medium">Belum ada daftar inventaris di kategori
                                                ini.</p>
                                            <p class="text-slate-400 text-sm mt-1">Silakan tambahkan aset baru untuk
                                                memulai.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>