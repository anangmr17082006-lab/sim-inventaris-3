<x-app-layout>
    <x-slot name="header">Buat Usulan Pengadaan Baru</x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow border-l-4 border-purple-600">
                <form action="{{ route('pengadaan.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                    <label class="block font-bold text-sm mb-1">Nama Pengusul</label>
                    <input type="text" name="requestor_name" 
                        class="w-full border-gray-300 rounded bg-gray-100 cursor-not-allowed" 
                        value="{{ Auth::user()->name }}" 
                        readonly>
                </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block font-bold text-sm mb-1">Nama Barang</label>
                            <input type="text" name="item_name" class="w-full border-gray-300 rounded" placeholder="Cth: Laptop Gaming, Tinta Printer" required>
                        </div>
                        <div>
                            <label class="block font-bold text-sm mb-1">Jenis Barang</label>
                            <select name="type" class="w-full border-gray-300 rounded">
                                <option value="asset">Aset Tetap (Laptop, Meja)</option>
                                <option value="consumable">Habis Pakai (ATK, Obat)</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold text-sm mb-1">Jumlah Permintaan</label>
                        <input type="number" name="quantity" min="1" class="w-full border-gray-300 rounded" required>
                    </div>

                    <div class="mb-6">
                        <label class="block font-bold text-sm mb-1">Alasan / Spesifikasi</label>
                        <textarea name="description" class="w-full border-gray-300 rounded" rows="3" placeholder="Jelaskan kebutuhan dan spek teknis..."></textarea>
                    </div>

                    <div class="flex justify-end">
                        <button class="bg-purple-600 text-white px-6 py-2 rounded font-bold hover:bg-purple-700">Kirim Usulan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>