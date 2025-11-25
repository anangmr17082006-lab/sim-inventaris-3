<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <span class="text-slate-500">Inventaris /</span>
            <span class="text-slate-800">Barang Habis Pakai (BHP)</span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8">
                <h3 class="text-2xl font-bold text-slate-800">Kategori Barang Habis Pakai</h3>
                <p class="text-slate-500 mt-1">Pilih kategori untuk mengelola stok dan monitoring kadaluarsa.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($categories as $cat)
                    <a href="{{ route('bhp.items', $cat->id) }}"
                        class="group block p-8 bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-xl hover:border-indigo-200 transition-all duration-300 relative overflow-hidden">
                        <div
                            class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-indigo-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-out opacity-50">
                        </div>

                        <div class="relative z-10 flex flex-col items-center text-center">
                            <div
                                class="h-16 w-16 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300 shadow-sm">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>

                            <h5
                                class="mb-2 text-xl font-bold tracking-tight text-slate-800 group-hover:text-indigo-700 transition-colors">
                                {{ $cat->name }}</h5>
                            <p class="font-medium text-slate-500 text-sm group-hover:text-slate-600">Kelola stok &
                                kadaluarsa {{ strtolower($cat->name) }}</p>
                        </div>
                    </a>
                @empty
                    <div class="col-span-3 text-center p-12 bg-white rounded-2xl shadow-sm border border-slate-100">
                        <div
                            class="h-16 w-16 bg-rose-100 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                        </div>
                        <p class="text-slate-800 font-bold text-lg">Belum ada Kategori tipe 'Consumable'.</p>
                        <p class="text-sm text-slate-500 mt-2">Pastikan Anda sudah menjalankan seeder CategorySeeder yang
                            baru.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>