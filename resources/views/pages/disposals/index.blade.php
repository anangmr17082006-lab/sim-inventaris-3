<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <span class="text-slate-500">Sirkulasi /</span>
            <span class="text-slate-800 font-bold">Disposal Aset</span>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-slate-50 via-red-50/30 to-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div class="mb-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h3 class="text-3xl font-bold text-slate-900 tracking-tight flex items-center gap-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg shadow-red-200">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                            </div>
                            Disposal Aset
                        </h3>
                        <p class="text-slate-500 text-sm mt-2">Kelola penghapusan aset dengan approval workflow dan audit trail lengkap</p>
                    </div>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('disposals.report.pdf') }}" target="_blank"
                            class="group bg-gradient-to-r from-red-600 to-red-700 text-white px-6 py-3 rounded-xl text-sm font-bold hover:from-red-700 hover:to-red-800 shadow-lg shadow-red-200 hover:shadow-xl hover:shadow-red-300 transition-all duration-300 flex items-center gap-2 hover:-translate-y-0.5">
                            <svg class="w-5 h-5 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            Export PDF
                        </a>
                    @endif
                </div>
            </div>

            {{-- STATS CARDS --}}
            @if(auth()->user()->role === 'admin')
                @php
                    $totalDisposals = \App\Models\Disposal::count();
                    $approvedCount = \App\Models\Disposal::approved()->count();
                    $rejectedCount = \App\Models\Disposal::rejected()->count();
                    $totalValue = \App\Models\Disposal::approved()->sum('book_value');
                @endphp
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    {{-- Pending Card --}}
                    <div class="bg-gradient-to-br from-amber-50 to-white border border-amber-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            @if($pendingCount > 0)
                                <span class="animate-pulse w-3 h-3 bg-amber-500 rounded-full"></span>
                            @endif
                        </div>
                        <div class="text-3xl font-bold text-amber-900 mb-1">{{ $pendingCount }}</div>
                        <div class="text-sm text-amber-600 font-medium">Menunggu Review</div>
                    </div>

                    {{-- Approved Card --}}
                    <div class="bg-gradient-to-br from-emerald-50 to-white border border-emerald-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="text-3xl font-bold text-emerald-900 mb-1">{{ $approvedCount }}</div>
                        <div class="text-sm text-emerald-600 font-medium">Disetujui</div>
                    </div>

                    {{-- Rejected Card --}}
                    <div class="bg-gradient-to-br from-rose-50 to-white border border-rose-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-rose-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="text-3xl font-bold text-rose-900 mb-1">{{ $rejectedCount }}</div>
                        <div class="text-sm text-rose-600 font-medium">Ditolak</div>
                    </div>

                    {{-- Total Value Card --}}
                    <div class="bg-gradient-to-br from-indigo-50 to-white border border-indigo-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="text-2xl font-bold text-indigo-900 mb-1">Rp {{ number_format($totalValue / 1000000, 1) }}M</div>
                        <div class="text-sm text-indigo-600 font-medium">Total Nilai Disposal</div>
                    </div>
                </div>
            @endif

            {{-- FILTER SECTION --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm mb-6 overflow-hidden">
                <div class="bg-gradient-to-r from-slate-50 to-white px-6 py-4 border-b border-slate-200">
                    <h4 class="font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                            </path>
                        </svg>
                        Filter & Pencarian
                    </h4>
                </div>
                <div class="p-6">
                    <form action="{{ route('disposals.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1 relative group">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari kode aset, nama aset..."
                                class="w-full pl-11 pr-4 py-3 rounded-xl border-slate-300 text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all group-hover:border-slate-400">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-hover:text-slate-600 transition-colors">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="w-full md:w-56">
                            <select name="status"
                                class="w-full py-3 px-4 rounded-xl border-slate-300 text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all hover:border-slate-400"
                                onchange="this.form.submit()">
                                <option value="">📋 Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏱️ Pending</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>✅ Approved</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>❌ Rejected</option>
                            </select>
                        </div>
                        <button type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-slate-700 to-slate-800 text-white rounded-xl text-sm font-bold hover:from-slate-800 hover:to-slate-900 shadow-lg shadow-slate-200 hover:shadow-xl transition-all duration-300 flex items-center justify-center gap-2 hover:-translate-y-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Filter
                        </button>
                    </form>
                </div>
            </div>

            {{-- SUCCESS/ERROR MESSAGE --}}
            @if(session('success'))
                <div class="mb-6 bg-gradient-to-r from-emerald-50 to-emerald-100/50 border-l-4 border-emerald-500 text-emerald-700 px-6 py-4 rounded-xl flex items-center gap-3 shadow-sm animate-slide-in">
                    <div class="w-10 h-10 bg-emerald-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-gradient-to-r from-rose-50 to-rose-100/50 border-l-4 border-rose-500 text-rose-700 px-6 py-4 rounded-xl flex items-center gap-3 shadow-sm animate-slide-in">
                    <div class="w-10 h-10 bg-rose-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <span class="font-bold">{{ session('error') }}</span>
                </div>
            @endif

            {{-- TABLE --}}
            <div class="bg-white shadow-lg rounded-2xl border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500">
                        <thead class="bg-gradient-to-r from-slate-50 to-slate-100 text-xs uppercase text-slate-700 border-b-2 border-slate-200 font-bold">
                            <tr>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4">Aset & Kode</th>
                                <th class="px-6 py-4">Tipe Disposal</th>
                                <th class="px-6 py-4">Tanggal</th>
                                <th class="px-6 py-4">Pengusul</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($disposals as $disposal)
                                <tr class="bg-white hover:bg-gradient-to-r hover:from-slate-50 hover:to-transparent transition-all duration-200 group">
                                    <td class="px-6 py-4 text-center">
                                        @if($disposal->status->value == 'pending')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-gradient-to-r from-amber-50 to-amber-100 text-amber-700 border border-amber-200 shadow-sm">
                                                <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></span>
                                                Pending
                                            </span>
                                        @elseif($disposal->status->value == 'approved')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-gradient-to-r from-emerald-50 to-emerald-100 text-emerald-700 border border-emerald-200 shadow-sm">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Approved
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-gradient-to-r from-rose-50 to-rose-100 text-rose-700 border border-rose-200 shadow-sm">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                Rejected
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-800 text-base group-hover:text-red-600 transition-colors">
                                            {{ $disposal->assetDetail->inventory->name ?? 'Item Dihapus' }}</div>
                                        <div class="text-xs font-mono text-red-600 bg-red-50 px-2 py-1 rounded-lg w-fit mt-1.5 border border-red-100 shadow-sm">
                                            {{ $disposal->assetDetail->unit_code ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-bold bg-{{ $disposal->disposal_type->color() }}-50 text-{{ $disposal->disposal_type->color() }}-700 border border-{{ $disposal->disposal_type->color() }}-200 shadow-sm">
                                            {{ $disposal->disposal_type->label() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600 text-xs font-medium">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ \Carbon\Carbon::parse($disposal->created_at)->format('d M Y H:i') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-xs shadow-sm">
                                                {{ substr($disposal->requester->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-700 text-xs">{{ $disposal->requester->name }}</div>
                                                <div class="text-[10px] text-slate-400">{{ $disposal->requester->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('disposals.show', $disposal) }}"
                                                class="group/btn bg-gradient-to-r from-slate-600 to-slate-700 text-white px-4 py-2 rounded-lg text-xs font-bold hover:from-slate-700 hover:to-slate-800 transition-all duration-300 shadow-sm hover:shadow-md inline-flex items-center gap-2 hover:-translate-y-0.5">
                                                <svg class="w-4 h-4 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                Detail
                                            </a>
                                            @if(auth()->user()->role === 'admin' && $disposal->status->value == 'pending')
                                                <a href="{{ route('disposals.review', $disposal) }}"
                                                    class="group/btn bg-gradient-to-r from-red-600 to-red-700 text-white px-4 py-2 rounded-lg text-xs font-bold hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-sm hover:shadow-md inline-flex items-center gap-2 hover:-translate-y-0.5">
                                                    <svg class="w-4 h-4 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Review
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-24 h-24 bg-gradient-to-br from-slate-100 to-slate-200 rounded-full flex items-center justify-center mb-4 shadow-inner">
                                                <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </div>
                                            <h3 class="text-slate-800 font-bold text-lg mb-2">Tidak ada data disposal</h3>
                                            <p class="text-slate-500 text-sm max-w-md">Belum ada pengajuan disposal yang sesuai dengan filter yang dipilih.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($disposals->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 bg-gradient-to-r from-slate-50 to-white">
                        {{ $disposals->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        @keyframes slide-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-slide-in {
            animation: slide-in 0.3s ease-out;
        }
    </style>
    @endpush
</x-app-layout>