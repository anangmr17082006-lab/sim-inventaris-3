<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="text-slate-500">Sirkulasi /</span>
                <span class="text-slate-800 font-bold">Detail Mutasi</span>
            </div>
            <a href="{{ route('mutasi.index') }}" class="text-sm text-slate-500 hover:text-slate-700 transition-colors">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50/50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- SUCCESS/ERROR MESSAGE --}}
            @if(session('success'))
                <div
                    class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl">
                    <p class="font-bold">{{ $errors->first() }}</p>
                </div>
            @endif

            {{-- MAIN CARD --}}
            <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">

                {{-- HEADER --}}
                <div class="bg-slate-50 border-b border-slate-200 px-8 py-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-xl font-bold text-slate-800">Detail Mutasi Aset</h3>
                            <p class="text-sm text-slate-500 mt-1">ID Mutasi: #{{ $mutation->id }}</p>
                        </div>
                        @if($mutation->status->value == 'pending')
                            <span
                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-sm font-bold bg-amber-50 text-amber-700 border border-amber-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Pending Approval
                            </span>
                        @elseif($mutation->status->value == 'completed')
                            <span
                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-sm font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Completed
                            </span>
                        @else
                            <span
                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-sm font-bold bg-rose-50 text-rose-700 border border-rose-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Rejected
                            </span>
                        @endif
                    </div>
                </div>

                {{-- CONTENT --}}
                <div class="p-8 space-y-6">

                    {{-- ASSET INFO --}}
                    <div class="bg-indigo-50 border border-indigo-100 rounded-lg p-6">
                        <h4 class="text-sm font-bold text-indigo-900 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Informasi Aset
                        </h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-indigo-600 font-bold mb-1">Nama Aset</p>
                                <p class="text-sm font-bold text-slate-800">
                                    {{ $mutation->asset->inventory->name ?? 'Item Hapus' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-indigo-600 font-bold mb-1">Kode Unit</p>
                                <p class="text-sm font-mono font-bold text-slate-800">{{ $mutation->asset->unit_code }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-indigo-600 font-bold mb-1">Model/Tipe</p>
                                <p class="text-sm text-slate-700">{{ $mutation->asset->model_name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-indigo-600 font-bold mb-1">Kondisi Saat Mutasi</p>
                                <p class="text-sm text-slate-700 capitalize">
                                    {{ str_replace('_', ' ', $mutation->asset_condition->value) }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- MOVEMENT INFO --}}
                    <div class="bg-slate-50 border border-slate-200 rounded-lg p-6">
                        <h4 class="text-sm font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                            Perpindahan Lokasi
                        </h4>
                        <div class="flex items-center gap-4">
                            <div class="flex-1 bg-white border border-slate-200 rounded-lg p-4">
                                <p class="text-xs text-slate-500 font-bold mb-1">DARI</p>
                                <p class="text-base font-bold text-slate-800">{{ $mutation->fromRoom->name }}</p>
                                <p class="text-xs text-slate-500">{{ $mutation->fromRoom->unit->name ?? '' }}</p>
                            </div>
                            <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                            <div class="flex-1 bg-indigo-600 text-white rounded-lg p-4">
                                <p class="text-xs opacity-80 font-bold mb-1">KE</p>
                                <p class="text-base font-bold">{{ $mutation->toRoom->name }}</p>
                                <p class="text-xs opacity-80">{{ $mutation->toRoom->unit->name ?? '' }}</p>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-slate-200">
                            <p class="text-xs text-slate-500 font-bold mb-1">Tanggal Mutasi</p>
                            <p class="text-sm font-bold text-slate-800">
                                {{ \Carbon\Carbon::parse($mutation->mutation_date)->format('d F Y') }}</p>
                        </div>
                    </div>

                    {{-- REASON & NOTES --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-bold text-slate-700 mb-2">Alasan Mutasi</h4>
                            <p class="text-sm text-slate-600 bg-slate-50 border border-slate-200 rounded-lg p-4">
                                {{ $mutation->reason }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-700 mb-2">Catatan Tambahan</h4>
                            <p class="text-sm text-slate-600 bg-slate-50 border border-slate-200 rounded-lg p-4">
                                {{ $mutation->notes ?? '-' }}</p>
                        </div>
                    </div>

                    {{-- TIMELINE --}}
                    <div class="bg-slate-50 border border-slate-200 rounded-lg p-6">
                        <h4 class="text-sm font-bold text-slate-900 mb-4">Timeline</h4>
                        <div class="space-y-3">
                            <div class="flex items-start gap-3">
                                <div class="w-2 h-2 bg-indigo-500 rounded-full mt-1.5"></div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-slate-800">Diajukan oleh
                                        {{ $mutation->requestedBy->name }}</p>
                                    <p class="text-xs text-slate-500">
                                        {{ \Carbon\Carbon::parse($mutation->created_at)->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            @if($mutation->approved_by)
                                <div class="flex items-start gap-3">
                                    <div
                                        class="w-2 h-2 {{ $mutation->status->value == 'completed' ? 'bg-emerald-500' : 'bg-rose-500' }} rounded-full mt-1.5">
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-bold text-slate-800">
                                            {{ $mutation->status->value == 'completed' ? 'Di-approve' : 'Di-reject' }} oleh
                                            {{ $mutation->approvedBy->name }}</p>
                                        <p class="text-xs text-slate-500">
                                            {{ \Carbon\Carbon::parse($mutation->approved_at)->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- ACTION BUTTONS --}}
                    @if($mutation->status->value == 'pending')
                        <div class="flex justify-end gap-3 pt-6 border-t border-slate-200">
                            <form action="{{ route('mutasi.reject', $mutation) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin reject mutasi ini?')">
                                @csrf @method('PUT')
                                <button type="submit"
                                    class="px-5 py-2.5 bg-rose-600 text-white rounded-lg font-bold hover:bg-rose-700 transition-all shadow-lg shadow-rose-200 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Reject Mutasi
                                </button>
                            </form>
                            <form action="{{ route('mutasi.approve', $mutation) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin approve mutasi ini? Ruangan aset akan otomatis berubah.')">
                                @csrf @method('PUT')
                                <button type="submit"
                                    class="px-5 py-2.5 bg-emerald-600 text-white rounded-lg font-bold hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-200 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Approve Mutasi
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>