<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <span class="text-slate-500">Sirkulasi /</span>
            <span class="text-slate-800">Peminjaman Aset</span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-slate-800">Daftar Peminjaman</h3>
                    <p class="text-slate-500 mt-1">Monitor status peminjaman aset dan pengembalian.</p>
                </div>
                <a href="{{ route('peminjaman.create') }}"
                    class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Pinjam Baru
                </a>
            </div>

            <div class="bg-white shadow-sm rounded-xl border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500">
                        <thead class="bg-slate-50 text-xs uppercase text-slate-700 border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-4 font-bold">Status</th>
                                <th class="px-6 py-4 font-bold">Barang (Kode)</th>
                                <th class="px-6 py-4 font-bold">Peminjam</th>
                                <th class="px-6 py-4 font-bold">Tgl Pinjam</th>
                                <th class="px-6 py-4 font-bold">Tenggat Kembali</th>
                                <th class="px-6 py-4 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($loans as $loan)
                                <tr class="bg-white hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4">
                                        @if($loan->status == 'dipinjam')
                                            <span
                                                class="bg-amber-100 text-amber-800 text-xs px-2.5 py-1 rounded-full font-bold border border-amber-200">DIPINJAM</span>
                                        @elseif($loan->status == 'kembali')
                                            <span
                                                class="bg-emerald-100 text-emerald-800 text-xs px-2.5 py-1 rounded-full font-bold border border-emerald-200">SELESAI</span>
                                        @else
                                            <span
                                                class="bg-rose-100 text-rose-800 text-xs px-2.5 py-1 rounded-full font-bold border border-rose-200">TELAT</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-800 text-base">{{ $loan->asset->inventory->name }}
                                        </div>
                                        <div
                                            class="text-xs text-indigo-600 font-mono mt-0.5 bg-indigo-50 inline-block px-1.5 py-0.5 rounded">
                                            {{ $loan->asset->unit_code }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-700">{{ $loan->borrower_name }}</div>
                                        <div class="text-xs text-slate-500">{{ $loan->borrower_id }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600">{{ $loan->loan_date }}</td>
                                    <td class="px-6 py-4">
                                        <span class="text-slate-600">{{ $loan->return_date_plan }}</span>
                                        @if($loan->status == 'dipinjam' && now() > $loan->return_date_plan)
                                            <span
                                                class="text-rose-600 text-xs font-bold block mt-1 bg-rose-50 px-2 py-0.5 rounded border border-rose-100 w-fit">Lewat
                                                Jatuh Tempo!</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($loan->status == 'dipinjam')
                                            <form action="{{ route('peminjaman.return', $loan->id) }}" method="POST"
                                                onsubmit="return confirm('Konfirmasi pengembalian barang ini?');">
                                                @csrf @method('PUT')
                                                <input type="text" name="notes" placeholder="Catatan kondisi..."
                                                    class="text-xs border-slate-300 rounded-lg mb-2 w-full focus:ring-indigo-500 focus:border-indigo-500">
                                                <button
                                                    class="bg-emerald-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-emerald-700 w-full transition-colors shadow-sm">
                                                    Terima Kembali
                                                </button>
                                            </form>
                                        @else
                                            <div class="flex flex-col items-center">
                                                <span class="text-slate-400 text-xs font-medium">Dikembalikan:</span>
                                                <span
                                                    class="text-slate-600 text-sm font-bold">{{ $loan->return_date_actual }}</span>
                                            </div>
                                        @endif
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
                                            <p class="text-slate-500 font-medium">Belum ada data peminjaman.</p>
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
</x-app-layout>