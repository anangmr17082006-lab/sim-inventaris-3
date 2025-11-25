<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <span class="text-slate-500">Pusat Laporan /</span>
            <span class="text-slate-800">Dashboard Laporan</span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8">
                <h3 class="text-2xl font-bold text-slate-800">Pusat Laporan & Cetak</h3>
                <p class="text-slate-500 mt-1">Unduh laporan inventaris, stok barang, dan peminjaman dalam format PDF.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div
                    class="bg-white p-8 rounded-xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow group">
                    <div
                        class="h-12 w-12 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg text-slate-800 mb-2">Laporan Aset Tetap</h3>
                    <p class="text-sm text-slate-500 mb-6 leading-relaxed">Daftar lengkap inventaris fisik aset tetap
                        (Laptop, Meja, Kursi, dll) dikelompokkan per Ruangan.</p>
                    <a href="{{ route('report.asset') }}" target="_blank"
                        class="w-full bg-white text-indigo-600 border border-indigo-200 px-4 py-2.5 rounded-lg font-bold hover:bg-indigo-50 hover:border-indigo-300 transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                            </path>
                        </svg>
                        Cetak PDF
                    </a>
                </div>

                <div
                    class="bg-white p-8 rounded-xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow group">
                    <div
                        class="h-12 w-12 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg text-slate-800 mb-2">Laporan Stok BHP</h3>
                    <p class="text-sm text-slate-500 mb-6 leading-relaxed">Posisi stok terakhir barang habis pakai (ATK,
                        Obat, dll) beserta informasi tanggal kadaluarsa.</p>
                    <a href="{{ route('report.consumable') }}" target="_blank"
                        class="w-full bg-white text-emerald-600 border border-emerald-200 px-4 py-2.5 rounded-lg font-bold hover:bg-emerald-50 hover:border-emerald-300 transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                            </path>
                        </svg>
                        Cetak PDF
                    </a>
                </div>

                <div
                    class="bg-white p-8 rounded-xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow group">
                    <div
                        class="h-12 w-12 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg text-slate-800 mb-2">Peminjaman Aktif</h3>
                    <p class="text-sm text-slate-500 mb-6 leading-relaxed">Daftar barang yang sedang dipinjam dan belum
                        dikembalikan, termasuk informasi peminjam.</p>
                    <a href="{{ route('report.loan') }}" target="_blank"
                        class="w-full bg-white text-amber-600 border border-amber-200 px-4 py-2.5 rounded-lg font-bold hover:bg-amber-50 hover:border-amber-300 transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                            </path>
                        </svg>
                        Cetak PDF
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>