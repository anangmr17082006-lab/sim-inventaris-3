<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="text-slate-500">Manajemen Ruangan /</span>
                <span class="text-slate-800">Tambah Baru</span>
            </div>
            <a href="{{ route('ruangan.index') }}"
                class="text-sm text-slate-500 hover:text-slate-700 transition-colors">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-100 p-8">

                <div class="mb-8 border-b border-slate-100 pb-6">
                    <h3 class="text-xl font-bold text-slate-800">Registrasi Ruangan Baru</h3>
                    <p class="text-sm text-slate-500 mt-1">Tambahkan data ruangan untuk lokasi penyimpanan aset.</p>
                </div>

                <form action="{{ route('ruangan.store') }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <label class="block font-medium text-sm text-slate-700 mb-2">Nama Ruangan</label>
                        <input type="text" name="name"
                            class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                            placeholder="Contoh: Lab Komputer 1" required>
                    </div>

                    <div class="mb-6">
                        <label class="block font-medium text-sm text-slate-700 mb-2">Lokasi Fisik</label>
                        <input type="text" name="location" placeholder="Contoh: Gedung A, Lt 2"
                            class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                            required>
                    </div>

                    <div class="mb-6">
                        <label class="block font-medium text-sm text-slate-700 mb-2">Milik Unit/Prodi</label>
                        <select name="unit_id"
                            class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                            required>
                            <option value="">-- Pilih Unit --</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-8">
                        <label class="block font-medium text-sm text-slate-700 mb-2">Status</label>
                        <select name="status"
                            class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                            <option value="tersedia">Tersedia</option>
                            <option value="digunakan">Sedang Digunakan</option>
                            <option value="perbaikan">Dalam Perbaikan</option>
                        </select>
                    </div>

                    <div class="flex justify-end items-center gap-4 pt-4 border-t border-slate-100">
                        <a href="{{ route('ruangan.index') }}"
                            class="text-slate-600 hover:text-slate-800 text-sm font-medium transition-colors">Batal</a>
                        <button type="submit"
                            class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 flex items-center gap-2">
                            <span>Simpan Ruangan</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>