<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <span class="text-slate-500">Inventaris /</span>
            <span class="text-slate-800">Riwayat Transaksi</span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-slate-800">Kartu Stok BHP</h3>
                    <p class="text-slate-500 mt-1">Riwayat keluar masuk barang habis pakai.</p>
                </div>
                <a href="{{ route('transaksi.create') }}"
                    class="bg-rose-600 text-white px-5 py-2.5 rounded-xl font-bold hover:bg-rose-700 shadow-lg shadow-rose-200 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 12H4m0 0l6-6m-6 6l6 6"></path>
                    </svg>
                    Catat Barang Keluar
                </a>
            </div>

            <div class="bg-white shadow-sm rounded-xl border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500">
                        <thead class="bg-slate-50 text-xs uppercase text-slate-700 border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-4 font-bold">Tanggal</th>
                                <th class="px-6 py-4 font-bold">Jenis</th>
                                <th class="px-6 py-4 font-bold">Barang (Batch)</th>
                                <th class="px-6 py-4 font-bold">Jumlah</th>
                                <th class="px-6 py-4 font-bold">Keterangan</th>
                                <th class="px-6 py-4 font-bold">Admin</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($transactions as $t)
                                <tr class="bg-white hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 text-slate-600">{{ $t->date }}</td>
                                    <td class="px-6 py-4">
                                        @if($t->type == 'masuk')
                                            <span
                                                class="bg-emerald-100 text-emerald-800 text-xs px-2.5 py-1 rounded-full font-bold border border-emerald-200">MASUK</span>
                                        @else
                                            <span
                                                class="bg-rose-100 text-rose-800 text-xs px-2.5 py-1 rounded-full font-bold border border-rose-200">KELUAR</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-800 text-base">{{ $t->detail->consumable->name }}
                                        </div>
                                        <div
                                            class="text-xs text-indigo-600 font-mono mt-0.5 bg-indigo-50 inline-block px-1.5 py-0.5 rounded">
                                            {{ $t->detail->batch_code }}</div>
                                    </td>
                                    <td
                                        class="px-6 py-4 font-bold text-lg {{ $t->type == 'masuk' ? 'text-emerald-600' : 'text-rose-600' }}">
                                        {{ $t->type == 'masuk' ? '+' : '-' }}{{ $t->amount }}
                                    </td>
                                    <td class="px-6 py-4 text-slate-600 italic">{{ $t->notes }}</td>
                                    <td class="px-6 py-4 text-xs text-slate-500">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="h-6 w-6 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 font-bold text-xs">
                                                {{ substr($t->user->name, 0, 1) }}
                                            </div>
                                            {{ $t->user->name }}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="h-12 w-12 rounded-full bg-slate-100 flex items-center justify-center mb-3">
                                                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                                    </path>
                                                </svg>
                                            </div>
                                            <p class="text-slate-500 font-medium">Belum ada transaksi.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-slate-100 bg-slate-50">
                    {{ $transactions->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>