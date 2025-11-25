<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <span class="text-slate-500">Sirkulasi /</span>
            <span class="text-slate-800 font-bold">Peminjaman Aset</span>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- HEADER + FILTER TOOLBAR --}}
            <div class="flex flex-col gap-6 mb-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h3 class="text-2xl font-bold text-slate-900 tracking-tight">Daftar Peminjaman</h3>
                        <p class="text-slate-500 text-sm mt-1">Pantau sirkulasi peminjaman aset tetap.</p>
                    </div>
                    <a href="{{ route('peminjaman.create') }}" class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Pinjam Baru
                    </a>
                </div>

                {{-- FILTER --}}
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                    <form action="{{ route('peminjaman.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1 relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama peminjam, NIP/NIM, atau nama barang..." class="w-full pl-9 pr-4 py-2 rounded-lg border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </div>
                        </div>
                        <div class="w-full md:w-48">
                            <select name="status" class="w-full py-2 px-3 rounded-lg border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500" onchange="this.form.submit()">
                                <option value="">Semua Status</option>
                                <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Sedang Dipinjam</option>
                                <option value="kembali" {{ request('status') == 'kembali' ? 'selected' : '' }}>Sudah Kembali</option>
                                <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Terlambat (Overdue)</option>
                            </select>
                        </div>
                        <button type="submit" class="px-6 py-2 bg-slate-800 text-white rounded-lg text-sm font-bold hover:bg-slate-900 transition-colors">Filter</button>
                    </form>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500">
                        <thead class="bg-slate-50 text-xs uppercase text-slate-700 border-b border-slate-100 font-bold">
                            <tr>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4">Barang & Kode</th>
                                <th class="px-6 py-4">Peminjam</th>
                                <th class="px-6 py-4">Tgl Pinjam</th>
                                <th class="px-6 py-4">Tenggat / Kembali</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($loans as $loan)
                                <tr class="bg-white hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $isOverdue = $loan->status == 'dipinjam' && now() > $loan->return_date_plan;
                                        @endphp

                                        @if($loan->status == 'kembali')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                Selesai
                                            </span>
                                        @elseif($isOverdue)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-100 animate-pulse">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Terlambat
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-100">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Dipinjam
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-800 text-base">{{ $loan->asset->inventory->name ?? 'Item Hapus' }}</div>
                                        <div class="text-xs font-mono text-indigo-600 bg-indigo-50 px-1.5 py-0.5 rounded w-fit mt-1 border border-indigo-100">
                                            {{ $loan->asset->unit_code ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-700">{{ $loan->borrower_name }}</div>
                                        <div class="text-xs text-slate-400">{{ $loan->borrower_id }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600 text-xs">
                                        {{ \Carbon\Carbon::parse($loan->loan_date)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($loan->status == 'kembali')
                                            <div class="text-emerald-600 font-bold text-xs">
                                                {{ \Carbon\Carbon::parse($loan->return_date_actual)->format('d M Y') }}
                                            </div>
                                            <span class="text-[10px] text-slate-400">Tgl Kembali</span>
                                        @else
                                            <div class="text-slate-600 font-medium text-xs {{ $isOverdue ? 'text-rose-600 font-bold' : '' }}">
                                                {{ \Carbon\Carbon::parse($loan->return_date_plan)->format('d M Y') }}
                                            </div>
                                            <span class="text-[10px] text-slate-400">Tenggat</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($loan->status == 'dipinjam')
                                            {{-- Tombol Kembali dengan Modal kecil --}}
                                            <button onclick="openReturnModal({{ $loan->id }}, '{{ $loan->asset->inventory->name }}')" class="bg-emerald-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-emerald-700 transition-colors shadow-sm flex items-center justify-center w-full gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                Kembalikan
                                            </button>
                                        @else
                                            <span class="text-slate-300 text-xs">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center opacity-50">
                                            <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <h3 class="text-slate-800 font-bold">Tidak ada data</h3>
                                            <p class="text-slate-500 text-sm">Belum ada peminjaman yang sesuai filter.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
                    {{ $loans->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Pengembalian (Simple JS) --}}
    <div id="returnModal" class="fixed inset-0 bg-slate-900/50 hidden items-center justify-center z-50 backdrop-blur-sm">
        <div class="bg-white p-6 rounded-xl shadow-xl w-full max-w-md m-4">
            <h3 class="text-lg font-bold text-slate-800 mb-2">Proses Pengembalian</h3>
            <p class="text-sm text-slate-500 mb-4">Barang: <span id="modalAssetName" class="font-bold text-slate-700"></span></p>
            
            <form id="returnForm" method="POST">
                @csrf @method('PUT')
                
                <div class="mb-4">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Kondisi Barang Saat Kembali</label>
                    <select name="condition_after" class="w-full border-slate-300 rounded-lg text-sm focus:ring-indigo-500">
                        <option value="baik">Baik (Normal)</option>
                        <option value="rusak_ringan">Rusak Ringan (Lecet/Error Dikit)</option>
                        <option value="rusak_berat">Rusak Berat (Mati Total)</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Catatan Tambahan (Opsional)</label>
                    <textarea name="return_notes" rows="2" class="w-full border-slate-300 rounded-lg text-sm focus:ring-indigo-500" placeholder="Cth: Kabel power agak longgar..."></textarea>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('returnModal').classList.add('hidden'); document.getElementById('returnModal').classList.remove('flex')" class="px-4 py-2 text-slate-600 text-sm font-bold hover:bg-slate-50 rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-bold hover:bg-indigo-700 rounded-lg shadow-lg shadow-indigo-200">Konfirmasi Kembali</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openReturnModal(id, name) {
            const modal = document.getElementById('returnModal');
            const form = document.getElementById('returnForm');
            const nameSpan = document.getElementById('modalAssetName');
            
            form.action = "/peminjaman/return/" + id;
            nameSpan.textContent = name;
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    </script>
</x-app-layout>