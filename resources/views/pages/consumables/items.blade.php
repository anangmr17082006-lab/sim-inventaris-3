<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <span class="text-slate-500">BHP /</span>
            <span class="text-slate-800">{{ $category->name }}</span>
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-slate-800">Stok Gudang: {{ $category->name }}</h3>
                    <p class="text-slate-500 mt-1">Kelola item dan monitoring kadaluarsa.</p>
                </div>
                <a href="{{ route('bhp.create', $category->id) }}"
                    class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Registrasi Item Baru
                </a>
            </div>

            <div class="bg-white shadow-sm rounded-xl border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500">
                        <thead class="bg-slate-50 text-xs uppercase text-slate-700 border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-4 font-bold">Nama Barang</th>
                                <th class="px-6 py-4 font-bold">Total Stok</th>
                                <th class="px-6 py-4 font-bold">Satuan</th>
                                <th class="px-6 py-4 font-bold text-rose-600">Exp. Tercepat</th>
                                <th class="px-6 py-4 font-bold">Tgl Pengecekan</th>
                                <th class="px-6 py-4 font-bold">Keterangan</th>
                                <th class="px-6 py-4 font-bold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($items as $item)
                                <tr class="bg-white hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 font-bold text-slate-800 text-base">{{ $item->name }}</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="bg-indigo-100 text-indigo-700 text-sm font-bold px-3 py-1 rounded-full border border-indigo-200">
                                            {{ $item->total_stock }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600">{{ $item->unit }}</td>
                                    <td class="px-6 py-4">
                                        @if($item->nearest_expiry)
                                            <span
                                                class="text-rose-600 font-bold bg-rose-50 px-2 py-1 rounded border border-rose-100">{{ $item->nearest_expiry }}</span>
                                        @else
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-slate-600">{{ $item->last_check ?? '-' }}</td>
                                    <td class="px-6 py-4 text-slate-500 italic max-w-xs truncate">{{ $item->notes }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('consumable.detail', $item->id) }}"
                                            class="inline-flex items-center px-3 py-1.5 text-xs font-bold text-indigo-600 bg-indigo-50 border border-indigo-200 rounded-lg hover:bg-indigo-100 transition-colors">
                                            Detail & Stok
                                            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="h-12 w-12 rounded-full bg-slate-100 flex items-center justify-center mb-3">
                                                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                    </path>
                                                </svg>
                                            </div>
                                            <p class="text-slate-500 font-medium">Belum ada barang di kategori ini.</p>
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