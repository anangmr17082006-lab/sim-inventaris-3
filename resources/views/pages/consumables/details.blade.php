<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="text-slate-500">BHP /</span>
                <span class="text-slate-500">{{ $consumable->name }} /</span>
                <span class="text-slate-800">Kelola Stok</span>
            </div>
            <a href="{{ route('bhp.items', $consumable->category_id) }}"
                class="text-sm text-slate-500 hover:text-slate-700 transition-colors">
                &larr; Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-slate-800">Riwayat Batch Kedatangan</h3>
                    <p class="text-slate-500 mt-1">Kelola stok masuk, kadaluarsa, dan lokasi penyimpanan untuk <span
                            class="font-bold text-slate-700">{{ $consumable->name }}</span>.</p>
                </div>

                <a href="{{ route('consumable.createBatch', $consumable->id) }}"
                    class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Stok Baru
                </a>
            </div>

            <div class="bg-white shadow-sm rounded-xl border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500">
                        <thead class="bg-slate-50 uppercase font-bold text-slate-700 border-b border-slate-100 text-xs">
                            <tr>
                                <th class="px-6 py-4">Kode Batch</th>
                                <th class="px-6 py-4">Merk</th>
                                <th class="px-6 py-4">Stok Awal</th>
                                <th class="px-6 py-4 text-emerald-600">Sisa Stok</th>
                                <th class="px-6 py-4 text-rose-600">Kadaluarsa</th>
                                <th class="px-6 py-4">Lokasi</th>
                                <th class="px-6 py-4">Sumber Dana</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($details as $d)
                                <tr class="bg-white hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 font-bold text-indigo-600 font-mono">{{ $d->batch_code }}</td>
                                    <td class="px-6 py-4 font-medium text-slate-800">{{ $d->model_name }}</td>
                                    <td class="px-6 py-4 text-slate-600">{{ $d->initial_stock }}</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="bg-emerald-100 text-emerald-700 text-sm font-bold px-3 py-1 rounded-full border border-emerald-200">
                                            {{ $d->current_stock }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($d->expiry_date)
                                            <span
                                                class="text-rose-600 font-bold bg-rose-50 px-2 py-1 rounded border border-rose-100">{{ $d->expiry_date }}</span>
                                        @else
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-slate-600">{{ $d->room->name }}</td>
                                    <td class="px-6 py-4 text-slate-600">{{ $d->fundingSource->name }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <button
                                            class="text-rose-500 hover:text-rose-700 font-medium hover:underline transition-colors">Hapus</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>