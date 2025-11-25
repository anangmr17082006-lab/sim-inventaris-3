<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <span class="text-slate-500">Pengadaan /</span>
            <span class="text-slate-800 font-bold">Daftar Usulan</span>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- HEADER + FILTER TOOLBAR --}}
            <div class="flex flex-col gap-6 mb-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h3 class="text-2xl font-bold text-slate-900 tracking-tight">Usulan Pengadaan</h3>
                        <p class="text-slate-500 text-sm mt-1">Kelola permintaan aset baru dari unit kerja.</p>
                    </div>
                    <a href="{{ route('pengadaan.create') }}" class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        Buat Usulan
                    </a>
                </div>

                {{-- FILTER SECTION --}}
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                    <form action="{{ route('pengadaan.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="md:col-span-2">
                            <label class="text-xs font-bold text-slate-500 uppercase mb-1 block">Pencarian</label>
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari barang atau pengusul..." class="w-full pl-9 pr-4 py-2 rounded-lg border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase mb-1 block">Status</label>
                            <select name="status" class="w-full py-2 px-3 rounded-lg border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500" onchange="this.form.submit()">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full py-2 bg-slate-800 text-white rounded-lg text-sm font-bold hover:bg-slate-900 transition-colors">Terapkan Filter</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500">
                        <thead class="bg-slate-50 text-xs uppercase text-slate-700 border-b border-slate-100 font-bold">
                            <tr>
                                <th class="px-6 py-4">Tanggal & Pengusul</th>
                                <th class="px-6 py-4">Barang / Deskripsi</th>
                                <th class="px-6 py-4 text-center">Jumlah</th>
                                <th class="px-6 py-4 text-center">Est. Harga</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($requests as $req)
                                <tr class="bg-white hover:bg-slate-50/80 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-700">{{ $req->created_at->format('d M Y') }}</div>
                                        <div class="text-xs text-slate-500 flex items-center gap-1 mt-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                            {{ $req->requestor_name }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-800 text-base">{{ $req->item_name }}</div>
                                        <div class="text-xs mt-1 px-2 py-0.5 rounded bg-slate-100 w-fit border border-slate-200 font-medium text-slate-500 capitalize">{{ $req->type == 'asset' ? 'Aset Tetap' : 'Barang Habis Pakai' }}</div>
                                        <div class="text-xs italic text-slate-400 mt-1 max-w-xs truncate" title="{{ $req->description }}">{{ $req->description }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center font-bold text-slate-700 text-lg">
                                        {{ $req->quantity }}
                                    </td>
                                    <td class="px-6 py-4 text-center text-slate-600 font-mono text-xs">
                                        @if($req->unit_price_estimation)
                                            Rp {{ number_format($req->unit_price_estimation, 0, ',', '.') }}<br>
                                            <span class="text-[10px] text-slate-400">per unit</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $statusClasses = [
                                                'pending' => 'bg-slate-100 text-slate-600 border-slate-200',
                                                'approved' => 'bg-indigo-50 text-indigo-600 border-indigo-200',
                                                'completed' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                                'rejected' => 'bg-rose-50 text-rose-600 border-rose-200',
                                            ];
                                            $labels = [
                                                'pending' => 'Menunggu', 'approved' => 'Disetujui', 'completed' => 'Selesai', 'rejected' => 'Ditolak'
                                            ];
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $statusClasses[$req->status] ?? '' }}">
                                            {{ $labels[$req->status] }}
                                        </span>
                                        @if($req->admin_note)
                                            <div class="text-[10px] text-slate-400 mt-1 italic max-w-[100px] mx-auto truncate" title="Note: {{ $req->admin_note }}">Note: {{ $req->admin_note }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        {{-- Admin Actions --}}
                                        @if(Auth::user()->role == 'admin')
                                            <div class="flex justify-end items-center gap-2">
                                                @if($req->status == 'pending')
                                                    {{-- ACC Button --}}
                                                    <form action="{{ route('pengadaan.updateStatus', $req->id) }}" method="POST">
                                                        @csrf @method('PUT')
                                                        <input type="hidden" name="status" value="approved">
                                                        <button onclick="return confirm('Setujui usulan ini?')" class="p-1.5 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded-lg border border-indigo-200 transition-colors" title="Setujui">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                                        </button>
                                                    </form>

                                                    {{-- Reject Button (With Modal Logic via JS) --}}
                                                    <button onclick="openRejectModal({{ $req->id }})" class="p-1.5 bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-lg border border-rose-200 transition-colors" title="Tolak">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                                    </button>
                                                @elseif($req->status == 'approved')
                                                    {{-- Complete Button --}}
                                                    <form action="{{ route('pengadaan.updateStatus', $req->id) }}" method="POST">
                                                        @csrf @method('PUT')
                                                        <input type="hidden" name="status" value="completed">
                                                        <button onclick="return confirm('Tandai selesai (barang sudah diterima)?')" class="px-3 py-1.5 bg-emerald-600 text-white text-xs font-bold rounded-lg hover:bg-emerald-700 transition-colors shadow-sm">
                                                            Selesaikan
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        @endif

                                        {{-- User Delete (Only Pending) --}}
                                        @if($req->status == 'pending' && (Auth::user()->id == $req->user_id || Auth::user()->role == 'admin'))
                                            <form action="{{ route('pengadaan.destroy', $req->id) }}" method="POST" class="inline-block mt-2">
                                                @csrf @method('DELETE')
                                                <button onclick="return confirm('Batalkan usulan ini?')" class="text-xs text-slate-400 hover:text-rose-500 hover:underline">Hapus</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center opacity-50">
                                            <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                            <h3 class="text-slate-800 font-bold">Tidak ada usulan</h3>
                                            <p class="text-slate-500 text-sm">Belum ada permintaan pengadaan yang sesuai filter.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
                    {{ $requests->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Hidden Reject Form (JS will populate this) --}}
    <form id="rejectForm" method="POST" class="hidden">
        @csrf @method('PUT')
        <input type="hidden" name="status" value="rejected">
        <input type="hidden" name="admin_note" id="rejectNote">
    </form>

    <script>
        function openRejectModal(id) {
            let reason = prompt("Masukkan alasan penolakan:");
            if (reason !== null && reason.trim() !== "") {
                let form = document.getElementById('rejectForm');
                form.action = "/pengadaan/" + id + "/status"; // Update action URL dinamis
                document.getElementById('rejectNote').value = reason;
                form.submit();
            } else if (reason !== null) {
                alert("Alasan penolakan wajib diisi!");
            }
        }
    </script>
</x-app-layout>