<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Audit Ruangan: {{ $ruangan->name }}
            </h2>
            <a href="{{ route('ruangan.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded text-sm hover:bg-gray-300">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white p-6 rounded-lg shadow mb-6 border-l-4 border-blue-600">
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <div class="text-xs text-gray-500 uppercase font-bold">Lokasi</div>
                        <div class="text-lg font-bold">{{ $ruangan->location }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 uppercase font-bold">Unit Pemilik</div>
                        <div class="text-lg font-bold">{{ $ruangan->unit->name }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 uppercase font-bold">Total Nilai Aset</div>
                        <div class="text-lg font-bold text-blue-600">
                            Rp {{ number_format($assets->sum('price'), 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="font-bold text-gray-700">🖥️ Daftar Aset Tetap (Inventaris)</h3>
                </div>
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="bg-gray-100 text-xs uppercase text-gray-700">
                        <tr>
                            <th class="px-6 py-3">Kode Aset</th>
                            <th class="px-6 py-3">Nama Barang</th>
                            <th class="px-6 py-3">Merk/Tipe</th>
                            <th class="px-6 py-3">Kondisi</th>
                            <th class="px-6 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assets as $asset)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-bold text-blue-600">{{ $asset->unit_code }}</td>
                            <td class="px-6 py-4">{{ $asset->inventory->name }}</td>
                            <td class="px-6 py-4">{{ $asset->model_name }}</td>
                            <td class="px-6 py-4">{{ ucfirst($asset->condition) }}</td>
                            <td class="px-6 py-4">
                                @if($asset->status == 'tersedia')
                                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Ada di Ruangan</span>
                                @else
                                    <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">Dipinjam/Keluar</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-4">Tidak ada aset tetap di ruangan ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="font-bold text-gray-700">📦 Stok Barang Habis Pakai (BHP)</h3>
                </div>
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="bg-gray-100 text-xs uppercase text-gray-700">
                        <tr>
                            <th class="px-6 py-3">Kode Batch</th>
                            <th class="px-6 py-3">Nama Barang</th>
                            <th class="px-6 py-3">Sisa Stok</th>
                            <th class="px-6 py-3">Exp Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($consumables as $bhp)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $bhp->batch_code }}</td>
                            <td class="px-6 py-4">
                                {{ $bhp->consumable->name }}
                                <span class="text-xs text-gray-400">({{ $bhp->consumable->unit }})</span>
                            </td>
                            <td class="px-6 py-4 font-bold text-green-600">{{ $bhp->current_stock }}</td>
                            <td class="px-6 py-4 {{ $bhp->expiry_date < now() ? 'text-red-600 font-bold' : '' }}">
                                {{ $bhp->expiry_date ?? '-' }}
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-4">Tidak ada stok BHP di ruangan ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>