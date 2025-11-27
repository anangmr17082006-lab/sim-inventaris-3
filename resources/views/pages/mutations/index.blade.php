<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <span class="text-slate-500">Sirkulasi /</span>
            <span class="text-slate-800 font-bold">Mutasi Aset</span>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- HEADER + FILTER TOOLBAR --}}
            <div class="flex flex-col gap-6 mb-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h3 class="text-2xl font-bold text-slate-900 tracking-tight">Daftar Mutasi Aset</h3>
                        <p class="text-slate-500 text-sm mt-1">Tracking perpindahan aset antar ruangan dengan approval
                            workflow.</p>
                    </div>
                    <a href="{{ route('mutasi.create') }}"
                        class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Ajukan Mutasi
                    </a>
                </div>

                {{-- FILTER --}}
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                    <form action="{{ route('mutasi.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1 relative">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari kode aset, nama aset, atau nama ruangan..."
                                class="w-full pl-9 pr-4 py-2 rounded-lg border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <div
                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="w-full md:w-48">
                            <select name="status"
                                class="w-full py-2 px-3 rounded-lg border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                                onchange="this.form.submit()">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                    Completed</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected
                                </option>
                            </select>
                        </div>
                        <button type="submit"
                            class="px-6 py-2 bg-slate-800 text-white rounded-lg text-sm font-bold hover:bg-slate-900 transition-colors">Filter</button>
                    </form>
                </div>
            </div>

            {{-- SUCCESS MESSAGE --}}
            @if(session('success'))
                <div
                    class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            {{-- TABLE --}}
            <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500">
                        <thead class="bg-slate-50 text-xs uppercase text-slate-700 border-b border-slate-100 font-bold">
                            <tr>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4">Aset & Kode</th>
                                <th class="px-6 py-4">Dari → Ke</th>
                                <th class="px-6 py-4">Tanggal Mutasi</th>
                                <th class="px-6 py-4">Diajukan Oleh</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($mutations as $mutation)
                                <tr class="bg-white hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 text-center">
                                        @if($mutation->status->value == 'pending')
                                            <span
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-100">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Pending
                                            </span>
                                        @elseif($mutation->status->value == 'completed')
                                            <span
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Completed
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-100">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                Rejected
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-800 text-base">
                                            {{ $mutation->asset->inventory->name ?? 'Item Hapus' }}</div>
                                        <div
                                            class="text-xs font-mono text-indigo-600 bg-indigo-50 px-1.5 py-0.5 rounded w-fit mt-1 border border-indigo-100">
                                            {{ $mutation->asset->unit_code ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="text-xs">
                                                <div class="font-bold text-slate-700">{{ $mutation->fromRoom->name }}</div>
                                                <div class="text-slate-400">{{ $mutation->fromRoom->unit->name ?? '' }}
                                                </div>
                                            </div>
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                            </svg>
                                            <div class="text-xs">
                                                <div class="font-bold text-indigo-700">{{ $mutation->toRoom->name }}</div>
                                                <div class="text-slate-400">{{ $mutation->toRoom->unit->name ?? '' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600 text-xs font-medium">
                                        {{ \Carbon\Carbon::parse($mutation->mutation_date)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-700 text-xs">{{ $mutation->requestedBy->name }}
                                        </div>
                                        <div class="text-[10px] text-slate-400">
                                            {{ \Carbon\Carbon::parse($mutation->created_at)->format('d M Y H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('mutasi.show', $mutation) }}"
                                            class="bg-slate-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-slate-700 transition-colors shadow-sm inline-flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center opacity-50">
                                            <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                            </svg>
                                            <h3 class="text-slate-800 font-bold">Tidak ada data</h3>
                                            <p class="text-slate-500 text-sm">Belum ada mutasi yang sesuai filter.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
                    {{ $mutations->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>