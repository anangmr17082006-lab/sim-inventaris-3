<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                {{-- Tombol Kembali --}}
                <a href="{{ route('inventaris.items', $inventory->category_id) }}"
                    class="group flex items-center justify-center w-8 h-8 bg-white border border-slate-200 rounded-lg text-slate-500 hover:text-indigo-600 hover:border-indigo-200 transition-all">
                    <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                </a>
                {{-- Judul Halaman --}}
                <div class="flex flex-col">
                    <span class="text-slate-500 text-xs uppercase font-bold tracking-wider">Detail Unit Fisik</span>
                    <span class="text-slate-800 font-bold text-lg leading-none">{{ $inventory->name }}</span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50/50 min-h-screen">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">

            {{-- TOOLBAR: JUDUL TABEL + SEARCH + TOMBOL TAMBAH --}}
            <div class="flex flex-col md:flex-row justify-between items-end md:items-center mb-6 gap-4">

                <div>
                    <h3 class="font-bold text-slate-800 text-xl">Daftar Unit Terdaftar</h3>
                    <p class="text-slate-500 text-sm mt-1">Total {{ $details->total() }} unit fisik tercatat.</p>
                </div>

                <div class="flex gap-3 w-full md:w-auto">
                    {{-- Search Bar --}}
                    <form action="{{ route('asset.index', $inventory->id) }}" method="GET"
                        class="relative w-full md:w-64">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari Kode / Ruangan..."
                            class="w-full pl-9 pr-4 py-2 rounded-lg border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                        <div
                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </form>

                    {{-- TOMBOL TAMBAH UNIT --}}
                    <a href="{{ route('asset.create', $inventory->id) }}"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all flex items-center gap-2 whitespace-nowrap">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Tambah Unit
                    </a>
                </div>
            </div>

            {{-- TABEL DATA --}}
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-xl border border-slate-200">
                <table class="w-full text-sm text-left text-slate-500">
                    <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-100 font-bold">
                        <tr>
                            <th class="px-6 py-4 whitespace-nowrap">Kode Unit</th>
                            <th class="px-6 py-4">Tipe / Merek</th>
                            <th class="px-6 py-4 text-center">Kondisi</th>
                            <th class="px-6 py-4">Lokasi</th>
                            <th class="px-6 py-4">Sumber Dana</th>
                            <th class="px-6 py-4">Tgl Beli</th>
                            <th class="px-6 py-4">Tgl Perbaikan</th>
                            <th class="px-6 py-4">Tgl Cek</th>
                            <th class="px-6 py-4">Keterangan</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($details as $unit)
                            <tr class="bg-white hover:bg-indigo-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <span
                                        class="font-mono font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded text-xs border border-indigo-100">
                                        {{ $unit->unit_code }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 font-medium text-slate-800">
                                    {{ $unit->model_name }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    @php
                                        $badges = [
                                            'baik' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                            'rusak_ringan' => 'bg-amber-100 text-amber-800 border-amber-200',
                                            'rusak_berat' => 'bg-rose-100 text-rose-800 border-rose-200'
                                        ];
                                        $labels = [
                                            'baik' => 'Baik',
                                            'rusak_ringan' => 'Rusak Ringan',
                                            'rusak_berat' => 'Rusak Berat'
                                        ];
                                    @endphp
                                    <span
                                        class="px-2.5 py-1 rounded-full text-xs font-bold border {{ $badges[$unit->condition] ?? 'bg-gray-100' }}">
                                        {{ $labels[$unit->condition] ?? $unit->condition }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="text-slate-700 font-bold">{{ $unit->room->name }}</div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="text-slate-700 text-xs">{{ $unit->fundingSource->name ?? '-' }}</div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="text-slate-600 text-xs">
                                        {{ $unit->purchase_date ? \Carbon\Carbon::parse($unit->purchase_date)->format('d M Y') : '-' }}
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="text-slate-600 text-xs">
                                        {{ $unit->repair_date ? \Carbon\Carbon::parse($unit->repair_date)->format('d M Y') : '-' }}
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="text-slate-600 text-xs">
                                        {{ $unit->check_date ? \Carbon\Carbon::parse($unit->check_date)->format('d M Y') : '-' }}
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="text-slate-500 text-xs italic max-w-[150px] truncate">
                                        {{ $unit->notes ?? '-' }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-3">
                                        {{-- Edit Button --}}
                                        <a href="{{ route('asset.edit', $unit->id) }}"
                                            class="text-amber-500 hover:text-amber-700 font-bold text-xs uppercase tracking-wider transition-colors">
                                            Edit
                                        </a>

                                        {{-- Disposal Button --}}
                                        @php
                                            $canDispose = $unit->isDisposable();
                                        @endphp
                                        @if($canDispose)
                                            <a href="{{ route('disposals.create', $unit->id) }}"
                                                class="text-red-500 hover:text-red-700 font-bold text-xs uppercase tracking-wider transition-colors">
                                                Disposal
                                            </a>
                                        @else
                                            <span
                                                class="text-slate-300 font-bold text-xs uppercase tracking-wider cursor-not-allowed"
                                                title="Aset tidak dapat di-disposal (dipinjam atau ada mutasi pending)">
                                                Disposal
                                            </span>
                                        @endif

                                        {{-- Delete Button --}}
                                        <form action="{{ route('asset.destroy', $unit->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus permanen unit ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="text-rose-500 hover:text-rose-700 font-bold text-xs uppercase tracking-wider transition-colors">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center opacity-50">
                                        <svg class="w-10 h-10 text-slate-300 mb-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                        <span class="text-slate-500 text-sm">Belum ada unit fisik yang didaftarkan.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Links --}}
            <div class="mt-6">
                {{ $details->withQueryString()->links() }}
            </div>

        </div>
    </div>
</x-app-layout>