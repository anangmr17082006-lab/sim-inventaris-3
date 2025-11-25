<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <span class="text-slate-500">Pengadaan /</span>
            <span class="text-slate-800">Daftar Usulan</span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-slate-800">Daftar Usulan Pengadaan</h3>
                    <p class="text-slate-500 mt-1">Kelola usulan pengadaan aset dan barang habis pakai.</p>
                </div>
                <a href="{{ route('pengadaan.create') }}"
                    class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Usulan Baru
                </a>
            </div>

            <div class="bg-white shadow-sm rounded-xl border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500">
                        <thead class="bg-slate-50 text-xs uppercase text-slate-700 border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-4 font-bold">Tanggal</th>
                                <th class="px-6 py-4 font-bold">Pengusul</th>
                                <th class="px-6 py-4 font-bold">Barang & Spek</th>
                                <th class="px-6 py-4 font-bold">Jumlah</th>
                                <th class="px-6 py-4 font-bold">Status</th>
                                <th class="px-6 py-4 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($requests as $req)
                                <tr class="bg-white hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 text-slate-600">{{ $req->created_at->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 font-bold text-slate-800">{{ $req->requestor_name }}</td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-800">{{ $req->item_name }}</div>
                                        <div class="text-xs text-slate-500 mt-0.5">
                                            {{ $req->type == 'asset' ? 'Aset Tetap' : 'BHP' }}
                                        </div>
                                        <div class="text-xs italic text-slate-400 mt-1">
                                            {{Str::limit($req->description, 50)}}</div>
                                    </td>
                                    <td class="px-6 py-4 font-bold text-slate-800">{{ $req->quantity }}</td>

                                    <td class="px-6 py-4">
                                        @if($req->status == 'pending')
                                            <span
                                                class="bg-slate-100 text-slate-600 text-xs px-2.5 py-1 rounded-full font-bold border border-slate-200">MENUNGGU</span>
                                        @elseif($req->status == 'approved')
                                            <span
                                                class="bg-indigo-100 text-indigo-800 text-xs px-2.5 py-1 rounded-full font-bold border border-indigo-200">DISETUJUI</span>
                                        @elseif($req->status == 'completed')
                                            <span
                                                class="bg-emerald-100 text-emerald-800 text-xs px-2.5 py-1 rounded-full font-bold border border-emerald-200">SELESAI</span>
                                        @else
                                            <span
                                                class="bg-rose-100 text-rose-800 text-xs px-2.5 py-1 rounded-full font-bold border border-rose-200">DITOLAK</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center items-center gap-2">

                                            @if(Auth::user()->role == 'admin')

                                                @if($req->status == 'pending')
                                                    <div class="flex gap-1">
                                                        <form action="{{ route('pengadaan.updateStatus', $req->id) }}"
                                                            method="POST">
                                                            @csrf @method('PUT')
                                                            <input type="hidden" name="status" value="approved">
                                                            <input type="hidden" name="admin_note" value="Disetujui.">
                                                            <button
                                                                class="bg-indigo-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-indigo-700 transition-colors shadow-sm"
                                                                onclick="return confirm('Setujui usulan ini?')">ACC</button>
                                                        </form>

                                                        <form action="{{ route('pengadaan.updateStatus', $req->id) }}" method="POST"
                                                            id="form-reject-{{ $req->id }}">
                                                            @csrf @method('PUT')
                                                            <input type="hidden" name="status" value="rejected">
                                                            <input type="hidden" name="admin_note" id="note-reject-{{ $req->id }}">
                                                            <button type="button" onclick="openRejectPrompt({{ $req->id }})"
                                                                class="bg-rose-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-rose-700 transition-colors shadow-sm">
                                                                Tolak
                                                            </button>
                                                        </form>
                                                    </div>
                                                @elseif($req->status == 'approved')
                                                    <form action="{{ route('pengadaan.updateStatus', $req->id) }}" method="POST">
                                                        @csrf @method('PUT')
                                                        <input type="hidden" name="status" value="completed">
                                                        <input type="hidden" name="admin_note" value="Selesai.">
                                                        <button
                                                            class="bg-emerald-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-emerald-700 transition-colors shadow-sm flex items-center gap-1"
                                                            onclick="return confirm('Tandai selesai?')">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                            Selesai
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-xs text-slate-400 italic">-</span>
                                                @endif

                                            @else
                                                @if($req->status == 'pending')
                                                    <span class="text-xs text-slate-500 italic">Menunggu Persetujuan</span>
                                                @elseif($req->status == 'approved')
                                                    <span class="text-xs text-indigo-600 font-bold">Sedang Diproses</span>
                                                @elseif($req->status == 'completed')
                                                    <span class="text-xs text-emerald-600 font-bold">✔ Selesai</span>
                                                @elseif($req->status == 'rejected')
                                                    <span class="text-xs text-rose-500 font-bold">Ditolak</span>
                                                @endif
                                            @endif

                                            @if(Auth::user()->role == 'admin' || ($req->status == 'pending' && strcasecmp(Auth::user()->name, $req->requestor_name) == 0))
                                                <form action="{{ route('pengadaan.destroy', $req->id) }}" method="POST"
                                                    class="ml-2">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="text-slate-400 hover:text-rose-600 transition-colors"
                                                        title="Hapus Riwayat" onclick="return confirm('Yakin hapus data ini?')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="h-12 w-12 rounded-full bg-slate-100 flex items-center justify-center mb-3">
                                                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                                    </path>
                                                </svg>
                                            </div>
                                            <p class="text-slate-500 font-medium">Belum ada usulan pengadaan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-slate-100 bg-slate-50">
                    {{ $requests->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        function openRejectPrompt(id) {
            let reason = prompt("Tuliskan alasan penolakan:");
            if (reason === null) return;
            if (reason.trim() === "") {
                alert("Wajib mengisi alasan penolakan!");
                return;
            }
            document.getElementById('note-reject-' + id).value = reason;
            document.getElementById('form-reject-' + id).submit();
        }
    </script>
</x-app-layout>