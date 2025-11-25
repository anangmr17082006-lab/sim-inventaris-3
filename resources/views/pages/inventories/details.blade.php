<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <span>Detail Unit: {{ $inventory->name }}</span>
            <a href="{{ route('inventaris.items', $inventory->category_id) }}"
                class="text-sm bg-gray-200 px-3 py-1 rounded hover:bg-gray-300 text-gray-700">
                &larr; Kembali ke Daftar {{ $inventory->category->name }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded-lg shadow mb-8 border-t-4 border-blue-600">
                <h4 class="font-bold mb-4 text-lg text-gray-800">Input Unit Fisik Baru</h4>
                <form action="{{ route('asset.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="inventory_id" value="{{ $inventory->id }}">

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                        <div class="col-span-1">
                            <label class="block text-xs font-bold text-gray-700 mb-1">Tipe/Merk Barang</label>
                            <input type="text" name="model_name" placeholder="Cth: Acer Aspire 5"
                                class="w-full text-sm border-gray-300 rounded focus:ring-blue-500" required>
                        </div>

                        <div class="col-span-1">
                            <label class="block text-xs font-bold text-gray-700 mb-1">Kondisi</label>
                            <select name="condition" class="w-full text-sm border-gray-300 rounded focus:ring-blue-500">
                                <option value="baik">Baik</option>
                                <option value="rusak_ringan">Rusak Ringan</option>
                                <option value="rusak_berat">Rusak Berat</option>
                            </select>
                        </div>

                        <div class="col-span-1">
                            <label class="block text-xs font-bold text-gray-700 mb-1">Lokasi (Ruangan)</label>
                            <select name="room_id" class="w-full text-sm border-gray-300 rounded focus:ring-blue-500"
                                required>
                                <option value="">-- Pilih Ruangan --</option>
                                @foreach($rooms as $r)
                                    <option value="{{ $r->id }}">{{ $r->name }} ({{ $r->unit->name }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-1">
                            <label class="block text-xs font-bold text-gray-700 mb-1">Sumber Dana</label>
                            <select name="funding_source_id"
                                class="w-full text-sm border-gray-300 rounded focus:ring-blue-500 bg-yellow-50"
                                required>
                                <option value="">-- Pilih Sumber --</option>
                                @foreach($fundings as $f)
                                    <option value="{{ $f->id }}">{{ $f->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Tgl Beli</label>
                            <input type="date" name="purchase_date" class="w-full text-sm border-gray-300 rounded">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Harga Beli (Rp)</label>
                            <input type="number" name="price" class="w-full text-sm border-gray-300 rounded"
                                placeholder="0">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Tgl Perbaikan Terakhir</label>
                            <input type="date" name="repair_date"
                                class="w-full text-sm border-gray-300 rounded bg-gray-50">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Tgl Pengecekan</label>
                            <input type="date" name="check_date"
                                class="w-full text-sm border-gray-300 rounded bg-gray-50">
                        </div>

                        <div class="col-span-4">
                            <label class="block text-xs font-bold text-gray-700 mb-1">Keterangan Tambahan</label>
                            <input type="text" name="notes" placeholder="Opsional"
                                class="w-full text-sm border-gray-300 rounded">
                        </div>

                    </div>

                    <div class="mt-4 flex justify-end">
                        <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded text-sm font-bold hover:bg-blue-700 shadow-md">
                            + Simpan Unit Aset
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg border border-gray-200">
                <table class="w-full text-xs text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 border-b">
                        <tr>
                            <th class="px-4 py-3 whitespace-nowrap">Kode Unit</th>
                            <th class="px-4 py-3 whitespace-nowrap">Tipe / Merk</th>
                            <th class="px-4 py-3 text-center">Kondisi</th>
                            <th class="px-4 py-3">Lokasi</th>
                            <th class="px-4 py-3 text-center">Sumber Dana</th>

                            <th class="px-4 py-3">Tgl Beli</th>
                            <th class="px-4 py-3">Tgl Perbaikan</th>
                            <th class="px-4 py-3">Tgl Cek</th>

                            <th class="px-4 py-3">Keterangan</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($details as $unit)
                            <tr class="bg-white border-b hover:bg-blue-50 transition">
                                <td class="px-4 py-3 font-bold text-blue-600 whitespace-nowrap">
                                    {{ $unit->unit_code }}
                                </td>

                                <td class="px-4 py-3 font-medium text-gray-900">
                                    {{ $unit->model_name }}
                                </td>

                                <td class="px-4 py-3 text-center">
                                    @if($unit->condition == 'baik')
                                        <span
                                            class="bg-green-100 text-green-800 text-xs px-2 py-0.5 rounded border border-green-200">Baik</span>
                                    @elseif($unit->condition == 'rusak_ringan')
                                        <span
                                            class="bg-yellow-100 text-yellow-800 text-xs px-2 py-0.5 rounded border border-yellow-200">R.
                                            Ringan</span>
                                    @else
                                        <span
                                            class="bg-red-100 text-red-800 text-xs px-2 py-0.5 rounded border border-red-200">R.
                                            Berat</span>
                                    @endif
                                </td>

                                <td class="px-4 py-3">
                                    {{ $unit->room->name }}
                                </td>

                                <td class="px-4 py-3 text-center">
                                    <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded">
                                        {{ $unit->fundingSource->code }}
                                    </span>
                                </td>

                                <td class="px-4 py-3">{{ $unit->purchase_date ?? '-' }}</td>
                                <td class="px-4 py-3 text-orange-600">{{ $unit->repair_date ?? '-' }}</td>
                                <td class="px-4 py-3 text-blue-600">{{ $unit->check_date ?? '-' }}</td>

                                <td class="px-4 py-3 truncate max-w-[150px]" title="{{ $unit->notes }}">
                                    {{ $unit->notes ?? '-' }}
                                </td>

                                <td class="px-4 py-3 text-center flex justify-center gap-2">
                                    <a href="{{ route('asset.edit', $unit->id) }}"
                                        class="text-yellow-600 hover:underline font-bold text-xs uppercase tracking-wider py-1">Edit</a>
                                    <form action="{{ route('asset.destroy', $unit->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus unit aset ini?');">
                                        @csrf @method('DELETE')
                                        <button
                                            class="text-red-500 hover:text-red-700 font-bold text-xs uppercase tracking-wider">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-6 py-8 text-center text-gray-400 italic">
                                    Belum ada unit fisik yang didaftarkan untuk barang ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>