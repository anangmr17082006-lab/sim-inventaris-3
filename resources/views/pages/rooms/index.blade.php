<x-app-layout>
    <x-slot name="header">Manajemen Ruangan</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="mb-4 flex justify-end">
                    <a href="{{ route('ruangan.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        + Tambah Ruangan
                    </a>
                </div>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-6 py-3">Nama Ruangan</th>
                                <th class="px-6 py-3">Lokasi</th>
                                <th class="px-6 py-3">Unit / Prodi</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rooms as $room)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $room->name }}</td>
                                <td class="px-6 py-4">{{ $room->location }}</td>
                                <td class="px-6 py-4">{{ $room->unit->name ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded {{ $room->status == 'tersedia' ? 'bg-green-100 text-green-800' : ($room->status == 'digunakan' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($room->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 flex gap-2">
                                    <a href="{{ route('ruangan.edit', $room->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                    <a href="{{ route('ruangan.show', $room->id) }}" class="text-green-600 hover:underline mr-2 font-bold">
    👁️ Lihat Isi
</a>
                                    <form action="{{ route('ruangan.destroy', $room->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center">Belum ada data ruangan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $rooms->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>