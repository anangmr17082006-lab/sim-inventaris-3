<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <span class="text-slate-500">Logistik /</span>
            <span class="text-slate-800 font-bold">Riwayat Transaksi BHP</span>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Header Section --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-slate-900 tracking-tight">Kartu Stok & Mutasi</h3>
                    <p class="text-slate-500 text-sm mt-1">Pantau pergerakan masuk dan keluar barang habis pakai.</p>
                </div>
                
                {{-- Action Buttons --}}
                <div class="flex gap-2">
                    {{-- Tombol Stok Masuk (Opsional, arahkan ke pembelian/penerimaan) --}}
                    {{-- <a href="#" class="bg-emerald-600 text-white px-4 py-2.5 rounded-xl font-bold hover:bg-emerald-700 shadow-lg shadow-emerald-200 transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Stok Masuk
                    </a> --}}

                    <a href="{{ route('transaksi.create') }}" class="bg-rose-600 text-white px-5 py-2.5 rounded-xl font-bold hover:bg-rose-700 shadow-lg shadow-rose-200 transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4m0 0l6-6m-6 6l6 6"></path></svg>
                        Catat Barang Keluar
                    </a>
                </div>
            </div>

            {{-- FILTER CARD (Ini yang kamu lupakan!) --}}
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 mb-6">
                <form action="{{ route('transaksi.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    
                    {{-- Search --}}
                    <div class="md:col-span-1">
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Cari Barang / Batch</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama barang atau kode..." class="w-full text-sm border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    {{-- Filter Jenis --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Jenis Transaksi</label>
                        <select name="type" class="w-full text-sm border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Semua Jenis</option>
                            <option value="masuk" {{ request('type') == 'masuk' ? 'selected' : '' }}>Stok Masuk (+)</option>
                            <option value="keluar" {{ request('type') == 'keluar' ? 'selected' : '' }}>Stok Keluar (-)</option>
                        </select>
                    </div>

                    {{-- Filter Tanggal --}}
                    <div class="md:col-span-2 flex gap-2">
                        <div class="w-full">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Dari Tanggal</label>
                            <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full text-sm border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div class="w-full">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Sampai Tanggal</label>
                            <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full text-sm border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="h-[38px] px-4 bg-slate-800 text-white rounded-lg hover:bg-slate-900 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Table --}}
            <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500">
                        <thead class="bg-slate-50 text-xs uppercase text-slate-500 font-bold border-b border-slate-100 tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Waktu Transaksi</th>
                                <th class="px-6 py-4">Item & Batch</th>
                                <th class="px-6 py-4 text-center">Jenis Mutasi</th>
                                <th class="px-6 py-4 text-right">Jumlah</th>
                                <th class="px-6 py-4">Keterangan</th>
                                <th class="px-6 py-4">Petugas</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($transactions as $t)
                                <tr class="bg-white hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-700">{{ \Carbon\Carbon::parse($t->date)->format('d M Y') }}</div>
                                        <div class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($t->created_at)->format('H:i') }} WIB</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-800 text-base">{{ $t->detail->consumable->name ?? 'Item Terhapus' }}</div>
                                        <div class="flex items-center gap-1 mt-1">
                                            <span class="px-1.5 py-0.5 rounded text-[10px] font-mono font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                                {{ $t->detail->batch_code ?? 'N/A' }}
                                            </span>
                                            @if($t->detail->expiry_date)
                                                <span class="text-[10px] text-slate-400">Exp: {{ $t->detail->expiry_date }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($t->type == 'masuk')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                                Stok Masuk
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-100">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                                Stok Keluar
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="text-lg font-bold font-mono {{ $t->type == 'masuk' ? 'text-emerald-600' : 'text-rose-600' }}">
                                            {{ $t->type == 'masuk' ? '+' : '-' }}{{ $t->amount }}
                                        </span>
                                        <span class="text-xs text-slate-400 block">{{ $t->detail->consumable->unit ?? 'Unit' }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-slate-600 italic text-sm truncate max-w-xs" title="{{ $t->notes }}">
                                            {{ $t->notes ?: '-' }}
                                        </p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="h-6 w-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold border border-indigo-200">
                                                {{ substr($t->user->name ?? '?', 0, 1) }}
                                            </div>
                                            <span class="text-xs font-medium text-slate-600">{{ $t->user->name ?? 'System' }}</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center opacity-50">
                                            <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                            <h3 class="text-slate-800 font-bold">Tidak ada riwayat transaksi</h3>
                                            <p class="text-slate-500 text-sm">Sesuaikan filter pencarian atau catat transaksi baru.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
                    {{ $transactions->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>