<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Unit: {{ $unit->name }}
            </h2>
            <a href="{{ route('unit.index') }}"
                class="bg-gray-200 text-gray-700 px-4 py-2 rounded text-sm hover:bg-gray-300">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded-lg shadow mb-6 border-l-4 border-purple-600">
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <div class="text-xs text-gray-500 uppercase font-bold">Nama Unit / Divisi</div>
                        <div class="text-lg font-bold text-gray-900">{{ $unit->name }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 uppercase font-bold">Kode Unit</div>
                        <div class="text-lg font-bold text-gray-900">{{ $unit->code ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 uppercase font-bold">Jumlah Ruangan</div>
                        <div class="text-lg font-bold text-purple-600">{{ $rooms->count() }} Ruangan</div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                    <h3 class="font-bold text-gray-700">🏢 Daftar Ruangan / Lokasi</h3>
                </div>

                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="bg-gray-100 text-xs uppercase text-gray-700">
                        <tr>
                            <th class="px-6 py-3">No</th>
                            <th class="px-6 py-3">Nama Ruangan</th>
                            <th class="px-6 py-3">Lokasi Fisik</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rooms as $index => $room)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-4 text-center">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 font-bold text-gray-900">{{ $room->name }}</td>
                                <td class="px-6 py-4">{{ $room->location }}</td>
                                <td class="px-6 py-4">
                                    @if($room->status == 'tersedia')
                                        <span
                                            class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded font-bold">Aktif</span>
                                    @else
                                        <span
                                            class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded font-bold">Perbaikan/Non-Aktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('ruangan.show', $room->id) }}"
                                        class="text-blue-600 hover:underline text-xs font-bold">
                                        Lihat Inventaris &rarr;
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-400 italic">
                                    Belum ada ruangan yang terdaftar di unit ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>