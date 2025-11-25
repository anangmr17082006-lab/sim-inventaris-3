<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="text-slate-500">Manajemen Ruangan /</span>
                <span class="text-slate-800">Audit Ruangan</span>
            </div>
            <a href="{{ route('ruangan.index') }}"
                class="text-sm text-slate-500 hover:text-slate-700 transition-colors">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 mb-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                    <div>
                        <h3 class="text-2xl font-bold text-slate-800">{{ $ruangan->name }}</h3>
                        <p class="text-slate-500 mt-1">Detail informasi dan audit aset ruangan.</p>
                    </div>
                    <span
                        class="px-3 py-1 rounded-full text-sm font-bold {{ $ruangan->status == 'tersedia' ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : ($ruangan->status == 'digunakan' ? 'bg-amber-100 text-amber-800 border border-amber-200' : 'bg-rose-100 text-rose-800 border border-rose-200') }}">
                        {{ ucfirst($ruangan->status) }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <div class="text-xs text-slate-500 uppercase font-bold mb-1">Lokasi</div>
                        <div class="text-lg font-bold text-slate-800">{{ $ruangan->location }}</div>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <div class="text-xs text-slate-500 uppercase font-bold mb-1">Unit Pemilik</div>
                        <div class="text-lg font-bold text-slate-800">{{ $ruangan->unit->name }}</div>
                    </div>
                    <div class="bg-indigo-50 p-4 rounded-xl border border-indigo-100">
                        <div class="text-xs text-indigo-500 uppercase font-bold mb-1">Total Nilai Aset</div>
                        <div class="text-lg font-bold text-indigo-700">
                            Rp {{ number_format($assets->sum('price'), 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-xl border border-slate-100 overflow-hidden mb-8">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center gap-2">
                    <span class="text-xl">🖥️</span>
                    <h3 class="font-bold text-slate-700">Daftar Aset Tetap (Inventaris)</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500">
                        <thead class="bg-slate-50 text-xs uppercase text-slate-700 border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-4 font-bold">Kode Aset</th>
                                <th class="px-6 py-4 font-bold">Nama Barang</th>
                                <th class="px-6 py-4 font-bold">Merk/Tipe</th>
                                <th class="px-6 py-4 font-bold">Kondisi</th>
                                <th class="px-6 py-4 font-bold">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($assets as $asset)
                                <tr class="bg-white hover:bg-slate-50 transition-colors">
                                    <td
                                        class="px-6 py-4 font-bold text-indigo-600 font-mono bg-indigo-50 w-fit rounded px-2 py-1">
                                        {{ $asset->unit_code }}</td>
                                    <td class="px-6 py-4 font-medium text-slate-800">{{ $asset->inventory->name }}</td>
                                    <td class="px-6 py-4 text-slate-600">{{ $asset->model_name }}</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-2.5 py-1 rounded-full text-xs font-bold border {{ $asset->condition == 'baik' ? 'bg-emerald-100 text-emerald-800 border-emerald-200' : ($asset->condition == 'rusak-ringan' ? 'bg-amber-100 text-amber-800 border-amber-200' : 'bg-rose-100 text-rose-800 border-rose-200') }}">
                                            {{ ucfirst($asset->condition) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($asset->status == 'tersedia')
                                            <span
                                                class="bg-emerald-100 text-emerald-800 text-xs px-2.5 py-1 rounded-full font-bold border border-emerald-200">Ada
                                                di Ruangan</span>
                                        @else
                                            <span
                                                class="bg-amber-100 text-amber-800 text-xs px-2.5 py-1 rounded-full font-bold border border-amber-200">Dipinjam/Keluar</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-slate-500 italic">Tidak ada aset tetap
                                        di ruangan ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-xl border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center gap-2">
                    <span class="text-xl">📦</span>
                    <h3 class="font-bold text-slate-700">Stok Barang Habis Pakai (BHP)</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500">
                        <thead class="bg-slate-50 text-xs uppercase text-slate-700 border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-4 font-bold">Kode Batch</th>
                                <th class="px-6 py-4 font-bold">Nama Barang</th>
                                <th class="px-6 py-4 font-bold">Sisa Stok</th>
                                <th class="px-6 py-4 font-bold">Exp Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($consumables as $bhp)
                                <tr class="bg-white hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 font-mono text-slate-600">{{ $bhp->batch_code }}</td>
                                    <td class="px-6 py-4">
                                        <span class="font-medium text-slate-800">{{ $bhp->consumable->name }}</span>
                                        <span class="text-xs text-slate-400 ml-1">({{ $bhp->consumable->unit }})</span>
                                    </td>
                                    <td class="px-6 py-4 font-bold text-emerald-600">{{ $bhp->current_stock }}</td>
                                    <td class="px-6 py-4">
                                        @if($bhp->expiry_date < now())
                                            <span
                                                class="text-rose-600 font-bold bg-rose-50 px-2 py-1 rounded border border-rose-100">{{ $bhp->expiry_date }}
                                                (Expired)</span>
                                        @else
                                            <span class="text-slate-600">{{ $bhp->expiry_date ?? '-' }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-slate-500 italic">Tidak ada stok BHP
                                        di ruangan ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>