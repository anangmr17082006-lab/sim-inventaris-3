<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-2">
                <a href="{{ route('ruangan.index') }}" class="group flex items-center justify-center w-8 h-8 bg-white border border-slate-200 rounded-lg text-slate-500 hover:text-indigo-600 hover:border-indigo-200 transition-all">
                    <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <div class="flex flex-col">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Manajemen Ruangan</span>
                    <span class="text-slate-800 font-bold text-lg leading-none">Audit & Detail Ruangan</span>
                </div>
            </div>
            
            <div class="flex gap-2">
                <button onclick="window.print()" class="flex items-center gap-2 bg-white text-slate-700 px-4 py-2 rounded-lg text-sm font-bold border border-slate-200 hover:bg-slate-50 hover:text-indigo-600 transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak / PDF
                </button>
                <a href="{{ route('ruangan.edit', $ruangan->id) }}" class="flex items-center gap-2 bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Edit Data
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Info Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-8 relative overflow-hidden">
                {{-- Background Decoration --}}
                <div class="absolute top-0 right-0 w-64 h-64 bg-slate-50 rounded-full -mr-32 -mt-32 blur-3xl opacity-50 pointer-events-none"></div>

                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 relative z-10">
                    <div>
                        <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $ruangan->name }}</h3>
                        <div class="flex items-center gap-2 mt-2 text-slate-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="font-medium">{{ $ruangan->location }}</span>
                            <span class="text-slate-300 mx-2">|</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            <span class="font-medium">{{ $ruangan->unit->name }}</span>
                        </div>
                    </div>
                    
                    @php
                        $statusStyles = [
                            'tersedia' => 'bg-emerald-100 text-emerald-800 border-emerald-200 ring-emerald-500/30',
                            'digunakan' => 'bg-amber-100 text-amber-800 border-amber-200 ring-amber-500/30',
                            'perbaikan' => 'bg-rose-100 text-rose-800 border-rose-200 ring-rose-500/30',
                        ];
                        $style = $statusStyles[$ruangan->status] ?? 'bg-slate-100 text-slate-800 border-slate-200';
                    @endphp
                    <span class="mt-4 md:mt-0 px-4 py-1.5 rounded-full text-sm font-bold border ring-4 ring-opacity-20 {{ $style }}">
                        {{ strtoupper($ruangan->status) }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 relative z-10">
                    {{-- Card 1: Total Aset --}}
                    <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm flex items-center gap-4 group hover:border-indigo-200 transition-colors">
                        <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <div class="text-xs text-slate-400 font-bold uppercase">Total Item Aset</div>
                            <div class="text-2xl font-extrabold text-slate-800">{{ $assets->count() }} <span class="text-sm font-normal text-slate-500">Unit</span></div>
                        </div>
                    </div>

                    {{-- Card 2: Total Nilai --}}
                    <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm flex items-center gap-4 group hover:border-emerald-200 transition-colors">
                        <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <div class="text-xs text-slate-400 font-bold uppercase">Estimasi Nilai Aset</div>
                            <div class="text-2xl font-extrabold text-slate-800">Rp {{ number_format($assets->sum('price'), 0, ',', '.') }}</div>
                        </div>
                    </div>

                     {{-- Card 3: BHP --}}
                     <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm flex items-center gap-4 group hover:border-amber-200 transition-colors">
                        <div class="w-12 h-12 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <div>
                            <div class="text-xs text-slate-400 font-bold uppercase">Stok Barang Habis Pakai</div>
                            <div class="text-2xl font-extrabold text-slate-800">{{ $consumables->count() }} <span class="text-sm font-normal text-slate-500">Batch</span></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Grid Layout for Tables --}}
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 print:block">
                
                {{-- Table 1: Inventaris Aset --}}
                <div class="bg-white shadow-sm rounded-2xl border border-slate-200 overflow-hidden h-fit print:mb-8 print:border-slate-800">
                    <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold">A</div>
                            <div>
                                <h3 class="font-bold text-slate-800 text-lg">Aset Tetap</h3>
                                <p class="text-xs text-slate-500">Inventaris barang modal di ruangan ini.</p>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-slate-500">
                            <thead class="bg-slate-50 text-xs uppercase text-slate-400 font-bold border-b border-slate-100">
                                <tr>
                                    <th class="px-6 py-4">Barang</th>
                                    <th class="px-6 py-4">Merk & Kode</th>
                                    <th class="px-6 py-4 text-center">Kondisi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($assets as $asset)
                                    <tr class="bg-white hover:bg-slate-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-slate-800">{{ $asset->inventory->name }}</div>
                                            <div class="text-xs text-slate-500 mt-0.5">Tahun: {{ $asset->purchase_date ? \Carbon\Carbon::parse($asset->purchase_date)->year : '-' }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-slate-700 font-medium">{{ $asset->model_name ?? '-' }}</div>
                                            <code class="text-xs font-mono text-indigo-500 bg-indigo-50 px-1.5 py-0.5 rounded">{{ $asset->unit_code }}</code>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @php
                                                $condColor = match($asset->condition) {
                                                    'baik' => 'bg-emerald-500',
                                                    'rusak-ringan' => 'bg-amber-500',
                                                    'rusak-berat' => 'bg-rose-500',
                                                    default => 'bg-slate-300'
                                                };
                                            @endphp
                                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full border border-slate-100 bg-white shadow-sm">
                                                <span class="w-2 h-2 rounded-full {{ $condColor }}"></span>
                                                <span class="text-xs font-bold text-slate-600 capitalize">{{ str_replace('-', ' ', $asset->condition) }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center opacity-50">
                                                <svg class="w-10 h-10 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                                <span class="text-slate-500 text-sm">Tidak ada aset tetap.</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Table 2: BHP --}}
                <div class="bg-white shadow-sm rounded-2xl border border-slate-200 overflow-hidden h-fit print:border-slate-800">
                     <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center font-bold">B</div>
                            <div>
                                <h3 class="font-bold text-slate-800 text-lg">Barang Habis Pakai</h3>
                                <p class="text-xs text-slate-500">Stok opname barang konsumsi.</p>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-slate-500">
                            <thead class="bg-slate-50 text-xs uppercase text-slate-400 font-bold border-b border-slate-100">
                                <tr>
                                    <th class="px-6 py-4">Barang & Batch</th>
                                    <th class="px-6 py-4 text-center">Sisa Stok</th>
                                    <th class="px-6 py-4 text-right">Kadaluarsa</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($consumables as $bhp)
                                    <tr class="bg-white hover:bg-slate-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-slate-800">{{ $bhp->consumable->name }}</div>
                                            <div class="text-xs text-slate-500 mt-0.5 flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                                {{ $bhp->batch_code }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="font-mono font-bold text-lg text-slate-700">{{ $bhp->current_stock }}</span>
                                            <span class="text-xs text-slate-400 block">{{ $bhp->consumable->unit }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            @if($bhp->expiry_date)
                                                @php
                                                    $expDate = \Carbon\Carbon::parse($bhp->expiry_date);
                                                    $isExpired = $expDate->isPast();
                                                    $isNear = $expDate->diffInMonths(now()) < 3 && !$isExpired;
                                                @endphp
                                                @if($isExpired)
                                                    <span class="text-rose-600 font-bold text-xs bg-rose-50 px-2 py-1 rounded border border-rose-100">Expired</span>
                                                    <div class="text-xs text-rose-500 mt-1">{{ $expDate->format('d M Y') }}</div>
                                                @elseif($isNear)
                                                     <span class="text-amber-600 font-bold text-xs bg-amber-50 px-2 py-1 rounded border border-amber-100">Near Exp</span>
                                                     <div class="text-xs text-amber-500 mt-1">{{ $expDate->format('d M Y') }}</div>
                                                @else
                                                    <div class="text-slate-600 font-medium">{{ $expDate->format('d M Y') }}</div>
                                                    <div class="text-xs text-slate-400">{{ $expDate->diffForHumans() }}</div>
                                                @endif
                                            @else
                                                <span class="text-slate-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center opacity-50">
                                                <svg class="w-10 h-10 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                                <span class="text-slate-500 text-sm">Stok kosong.</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>