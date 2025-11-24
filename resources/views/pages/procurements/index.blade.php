<x-app-layout>
    <x-slot name="header">Daftar Usulan Pengadaan</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-end mb-4">
                <a href="{{ route('pengadaan.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded font-bold hover:bg-purple-700 shadow">+ Usulan Baru</a>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="bg-gray-100 text-xs uppercase text-gray-700">
                        <tr>
                            <th class="px-6 py-3">Tgl</th>
                            <th class="px-6 py-3">Pengusul</th>
                            <th class="px-6 py-3">Barang & Spek</th>
                            <th class="px-6 py-3">Jml</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Catatan Admin</th>
                            <th class="px-6 py-3 text-center">Aksi Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $req)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $req->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $req->requestor_name }}</td>
                            <td class="px-6 py-4">
                                <div class="font-bold">{{ $req->item_name }}</div>
                                <div class="text-xs text-gray-500">{{ $req->type == 'asset' ? 'Aset Tetap' : 'BHP' }}</div>
                                <div class="text-xs italic mt-1">{{Str::limit($req->description, 50)}}</div>
                            </td>
                            <td class="px-6 py-4 font-bold">{{ $req->quantity }}</td>
                            
                            <td class="px-6 py-4">
                                @if($req->status == 'pending')
                                    <span class="bg-gray-200 text-gray-800 text-xs px-2 py-1 rounded font-bold">MENUNGGU</span>
                                @elseif($req->status == 'approved')
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded font-bold">DISETUJUI</span>
                                @elseif($req->status == 'completed')
                                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded font-bold">SELESAI</span>
                                @else
                                    <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded font-bold">DITOLAK</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center items-center gap-2">
                                    
                                    @if(Auth::user()->role == 'admin') 

                                        @if($req->status == 'pending')
                                            <div class="flex gap-1">
                                                <form action="{{ route('pengadaan.updateStatus', $req->id) }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <input type="hidden" name="status" value="approved">
                                                    <input type="hidden" name="admin_note" value="Disetujui.">
                                                    <button class="bg-blue-600 text-white px-2 py-1 rounded text-xs hover:bg-blue-700" onclick="return confirm('ACC?')">ACC</button>
                                                </form>
                                                
                                                <form action="{{ route('pengadaan.updateStatus', $req->id) }}" method="POST" id="form-reject-{{ $req->id }}">
                                                    @csrf @method('PUT')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <input type="hidden" name="admin_note" id="note-reject-{{ $req->id }}">
                                                    <button type="button" onclick="openRejectPrompt({{ $req->id }})" class="bg-red-600 text-white px-2 py-1 rounded text-xs hover:bg-red-700">
                                                        Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif($req->status == 'approved')
                                            <form action="{{ route('pengadaan.updateStatus', $req->id) }}" method="POST">
                                                @csrf @method('PUT')
                                                <input type="hidden" name="status" value="completed">
                                                <input type="hidden" name="admin_note" value="Selesai.">
                                                <button class="bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-700" onclick="return confirm('Selesai?')">
                                                    ✔ Selesai
                                                </button>
                                            </form>
                                        @else
                                            @endif

                                    @else
                                        @if($req->status == 'pending')
                                            <span class="text-xs text-gray-500 italic">Menunggu</span>
                                        @elseif($req->status == 'approved')
                                            <span class="text-xs text-blue-600 font-bold">Diproses</span>
                                        @elseif($req->status == 'completed')
                                            <span class="text-xs text-green-600 font-bold">✔ Selesai</span>
                                        @elseif($req->status == 'rejected')
                                            <span class="text-xs text-red-500 font-bold">Ditolak</span>
                                        @endif
                                    @endif

                                    @if(Auth::user()->role == 'admin' || ($req->status == 'pending' && strcasecmp(Auth::user()->name, $req->requestor_name) == 0))
                                    <form action="{{ route('pengadaan.destroy', $req->id) }}" method="POST" class="ml-2">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-600 transition" title="Hapus Riwayat" onclick="return confirm('Yakin hapus data ini?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center py-4">Belum ada usulan pengadaan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">{{ $requests->links() }}</div>
            </div>
        </div>
    </div>

    <script>
        function openRejectPrompt(id) {
            // 1. Munculkan Popup Prompt
            let reason = prompt("Tuliskan alasan penolakan:");

            // 2. Validasi Input
            if (reason === null) {
                // User tekan Cancel -> Jangan lakukan apa-apa
                return; 
            }
            
            if (reason.trim() === "") {
                // User tekan OK tapi kosong -> Marahi
                alert("Wajib mengisi alasan penolakan!");
                return;
            }

            // 3. Masukkan teks ke input hidden berdasarkan ID unik
            document.getElementById('note-reject-' + id).value = reason;

            // 4. Submit Form secara manual berdasarkan ID unik
            document.getElementById('form-reject-' + id).submit();
        }
    </script>

</x-app-layout>