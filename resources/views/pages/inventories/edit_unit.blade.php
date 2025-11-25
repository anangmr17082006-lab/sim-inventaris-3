<x-app-layout>
    <x-slot name="header">Edit Unit Fisik: {{ $assetDetail->unit_code }}</x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-sm sm:rounded-lg border-t-4 border-yellow-500">

                <div class="mb-6 bg-yellow-50 p-4 rounded border border-yellow-200 text-sm text-yellow-800">
                    <strong>Perhatian:</strong> Demi integritas audit, <strong>Lokasi, Status, dan Kondisi</strong>
                    tidak dapat diubah dari menu ini. Gunakan menu Mutasi/Peminjaman untuk mengubahnya.
                </div>

                <form action="{{ route('asset.update', $assetDetail->id) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-500 uppercase">Kode Unit</label>
                        <input type="text" value="{{ $assetDetail->unit_code }}"
                            class="w-full bg-gray-200 border-gray-300 rounded cursor-not-allowed" readonly>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase">Status Saat Ini</label>
                            <input type="text" value="{{ ucfirst($assetDetail->status) }}"
                                class="w-full bg-gray-200 border-gray-300 rounded cursor-not-allowed font-bold text-blue-600"
                                readonly>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase">Lokasi</label>
                            <input type="text" value="{{ $assetDetail->room->name }}"
                                class="w-full bg-gray-200 border-gray-300 rounded cursor-not-allowed" readonly>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold text-sm text-gray-700">Merk / Tipe</label>
                        <input type="text" name="model_name" value="{{ $assetDetail->model_name }}"
                            class="w-full border-gray-300 rounded focus:ring-yellow-500">
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold text-sm text-gray-700">Harga Beli</label>
                        <input type="number" name="price" value="{{ $assetDetail->price }}"
                            class="w-full border-gray-300 rounded focus:ring-yellow-500">
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold text-sm text-gray-700">Keterangan Tambahan</label>
                        <input type="text" name="notes" value="{{ $assetDetail->notes }}"
                            class="w-full border-gray-300 rounded focus:ring-yellow-500">
                    </div>

                    <button
                        class="bg-yellow-600 text-white px-6 py-2 rounded font-bold hover:bg-yellow-700 w-full">Simpan
                        Perubahan</button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>