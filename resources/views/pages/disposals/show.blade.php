<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <span class="text-slate-500">Sirkulasi /</span>
            <a href="{{ route('disposals.index') }}" class="text-slate-500 hover:text-slate-700 transition-colors">Disposal</a>
            <span class="text-slate-500">/</span>
            <span class="text-slate-800 font-bold">Detail #{{ $disposal->id }}</span>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-slate-50 via-red-50/30 to-slate-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            {{-- HEADER WITH STATUS --}}
            <div class="mb-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center shadow-xl shadow-red-200">
                            <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-3xl font-bold text-slate-900 tracking-tight">Detail Disposal</h3>
                            <p class="text-slate-500 text-sm mt-1">ID: #{{ $disposal->id }} • {{ \Carbon\Carbon::parse($disposal->created_at)->format('d F Y H:i') }}</p>
                        </div>
                    </div>
                    
                    {{-- Status Badge --}}
                    @if($disposal->status->value == 'pending')
                        <div class="flex items-center gap-3 bg-gradient-to-r from-amber-50 to-amber-100 border-2 border-amber-200 px-6 py-3 rounded-2xl shadow-lg">
                            <span class="w-3 h-3 bg-amber-500 rounded-full animate-pulse"></span>
                            <span class="font-bold text-amber-900 text-lg">Menunggu Review</span>
                        </div>
                    @elseif($disposal->status->value == 'approved')
                        <div class="flex items-center gap-3 bg-gradient-to-r from-emerald-50 to-emerald-100 border-2 border-emerald-200 px-6 py-3 rounded-2xl shadow-lg">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="font-bold text-emerald-900 text-lg">Disetujui</span>
                        </div>
                    @else
                        <div class="flex items-center gap-3 bg-gradient-to-r from-rose-50 to-rose-100 border-2 border-rose-200 px-6 py-3 rounded-2xl shadow-lg">
                            <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <span class="font-bold text-rose-900 text-lg">Ditolak</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- LEFT COLUMN --}}
                <div class="lg:col-span-2 space-y-6">
                    
                    {{-- ASSET INFORMATION --}}
                    <div class="bg-white shadow-lg rounded-2xl border border-slate-200 overflow-hidden transform transition-all duration-300 hover:shadow-xl">
                        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4">
                            <h4 class="font-bold text-white flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                Informasi Aset
                            </h4>
                        </div>
                        <div class="p-6 bg-gradient-to-br from-white to-indigo-50/20">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="col-span-2 bg-white rounded-xl p-4 border-2 border-indigo-100 shadow-sm">
                                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1 mb-2">
                                        <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full"></span>
                                        Kode Aset
                                    </label>
                                    <div class="text-2xl font-mono font-bold text-red-600">{{ $disposal->assetDetail->unit_code }}</div>
                                </div>
                                <div class="col-span-2 bg-white rounded-xl p-4 border-2 border-slate-100 shadow-sm">
                                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1 mb-2">
                                        <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full"></span>
                                        Nama Aset
                                    </label>
                                    <div class="text-lg font-bold text-slate-800">{{ $disposal->assetDetail->inventory->name }}</div>
                                </div>
                                <div class="bg-white rounded-xl p-4 border-2 border-slate-100 shadow-sm">
                                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1 mb-2">
                                        <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full"></span>
                                        Kategori
                                    </label>
                                    <div class="text-sm text-slate-600 font-medium">{{ $disposal->assetDetail->inventory->category->name }}</div>
                                </div>
                                <div class="bg-white rounded-xl p-4 border-2 border-slate-100 shadow-sm">
                                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1 mb-2">
                                        <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full"></span>
                                        Kondisi
                                    </label>
                                    <div class="text-sm text-slate-600 font-medium">{{ ucfirst(str_replace('_', ' ', $disposal->assetDetail->condition)) }}</div>
                                </div>
                                <div class="col-span-2 bg-white rounded-xl p-4 border-2 border-slate-100 shadow-sm">
                                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1 mb-2">
                                        <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full"></span>
                                        Lokasi
                                    </label>
                                    <div class="text-sm text-slate-600 font-medium">{{ $disposal->assetDetail->room->name }} - {{ $disposal->assetDetail->room->unit->name }}</div>
                                </div>
                                <div class="col-span-2 bg-gradient-to-br from-emerald-50 to-white rounded-xl p-4 border-2 border-emerald-200 shadow-sm">
                                    <label class="text-xs font-bold text-emerald-700 uppercase tracking-wider flex items-center gap-1 mb-2">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                        Nilai Buku
                                    </label>
                                    <div class="text-2xl font-bold text-emerald-600">
                                        Rp {{ number_format($disposal->book_value ?? $disposal->assetDetail->price, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- DISPOSAL DETAILS --}}
                    <div class="bg-white shadow-lg rounded-2xl border border-slate-200 overflow-hidden transform transition-all duration-300 hover:shadow-xl">
                        <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-4">
                            <h4 class="font-bold text-white flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Detail Disposal
                            </h4>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="bg-gradient-to-br from-slate-50 to-white rounded-xl p-4 border-2 border-slate-100 shadow-sm">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block">Tipe Disposal</label>
                                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-bold bg-{{ $disposal->disposal_type->color() }}-50 text-{{ $disposal->disposal_type->color() }}-700 border-2 border-{{ $disposal->disposal_type->color() }}-200">
                                    {{ $disposal->disposal_type->label() }}
                                </span>
                            </div>
                            <div class="bg-gradient-to-br from-slate-50 to-white rounded-xl p-4 border-2 border-slate-100 shadow-sm">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block">Alasan Disposal</label>
                                <p class="text-sm text-slate-700 leading-relaxed">{{ $disposal->reason }}</p>
                            </div>
                            @if($disposal->notes)
                                <div class="bg-gradient-to-br from-amber-50 to-white rounded-xl p-4 border-2 border-amber-100 shadow-sm">
                                    <label class="text-xs font-bold text-amber-700 uppercase tracking-wider mb-2 block flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                        </svg>
                                        Catatan Admin
                                    </label>
                                    <p class="text-sm text-amber-900 leading-relaxed font-medium">{{ $disposal->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- EVIDENCE PHOTO --}}
                    <div class="bg-white shadow-lg rounded-2xl border border-slate-200 overflow-hidden transform transition-all duration-300 hover:shadow-xl">
                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                            <h4 class="font-bold text-white flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Foto Bukti Kondisi
                            </h4>
                        </div>
                        <div class="p-6">
                            <div class="relative group cursor-pointer" onclick="openLightbox()">
                                <img src="{{ Storage::url($disposal->evidence_photo) }}" 
                                    alt="Evidence Photo" 
                                    class="w-full rounded-xl shadow-lg border-4 border-white group-hover:shadow-2xl transition-all duration-300">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 rounded-xl transition-all duration-300 flex items-center justify-center">
                                    <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-white rounded-full p-4 shadow-xl">
                                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <p class="text-xs text-slate-500 text-center mt-3">Klik untuk memperbesar</p>
                        </div>
                    </div>
                </div>

                {{-- RIGHT COLUMN - TIMELINE --}}
                <div class="lg:col-span-1">
                    <div class="bg-white shadow-lg rounded-2xl border border-slate-200 overflow-hidden sticky top-6">
                        <div class="bg-gradient-to-r from-slate-700 to-slate-800 px-6 py-4">
                            <h4 class="font-bold text-white flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Timeline
                            </h4>
                        </div>
                        <div class="p-6">
                            <div class="space-y-6">
                                {{-- Request Event --}}
                                <div class="relative pl-8 pb-6 border-l-4 border-indigo-200">
                                    <div class="absolute -left-3 top-0 w-6 h-6 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-full border-4 border-white shadow-lg flex items-center justify-center">
                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </div>
                                    <div class="bg-gradient-to-br from-indigo-50 to-white rounded-xl p-4 border-2 border-indigo-100 shadow-sm">
                                        <div class="font-bold text-indigo-900 mb-1">Diajukan</div>
                                        <div class="text-xs text-indigo-600 font-medium mb-2">{{ \Carbon\Carbon::parse($disposal->created_at)->format('d M Y, H:i') }}</div>
                                        <div class="flex items-center gap-2 mt-3">
                                            <div class="w-8 h-8 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-xs shadow">
                                                {{ substr($disposal->requester->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="text-xs font-bold text-slate-700">{{ $disposal->requester->name }}</div>
                                                <div class="text-[10px] text-slate-500">{{ $disposal->requester->email }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Review Event --}}
                                @if($disposal->status->value != 'pending')
                                    <div class="relative pl-8">
                                        <div class="absolute -left-3 top-0 w-6 h-6 bg-gradient-to-br from-{{ $disposal->status->value == 'approved' ? 'emerald' : 'rose' }}-500 to-{{ $disposal->status->value == 'approved' ? 'emerald' : 'rose' }}-600 rounded-full border-4 border-white shadow-lg flex items-center justify-center">
                                            @if($disposal->status->value == 'approved')
                                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            @else
                                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="bg-gradient-to-br from-{{ $disposal->status->value == 'approved' ? 'emerald' : 'rose' }}-50 to-white rounded-xl p-4 border-2 border-{{ $disposal->status->value == 'approved' ? 'emerald' : 'rose' }}-100 shadow-sm">
                                            <div class="font-bold text-{{ $disposal->status->value == 'approved' ? 'emerald' : 'rose' }}-900 mb-1">
                                                {{ $disposal->status->value == 'approved' ? 'Disetujui' : 'Ditolak' }}
                                            </div>
                                            <div class="text-xs text-{{ $disposal->status->value == 'approved' ? 'emerald' : 'rose' }}-600 font-medium mb-2">
                                                {{ \Carbon\Carbon::parse($disposal->approved_at)->format('d M Y, H:i') }}
                                            </div>
                                            @if($disposal->reviewer)
                                                <div class="flex items-center gap-2 mt-3">
                                                    <div class="w-8 h-8 bg-gradient-to-br from-{{ $disposal->status->value == 'approved' ? 'emerald' : 'rose' }}-400 to-{{ $disposal->status->value == 'approved' ? 'emerald' : 'rose' }}-600 rounded-full flex items-center justify-center text-white font-bold text-xs shadow">
                                                        {{ substr($disposal->reviewer->name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <div class="text-xs font-bold text-slate-700">{{ $disposal->reviewer->name }}</div>
                                                        <div class="text-[10px] text-slate-500">{{ $disposal->reviewer->email }}</div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{-- Action Button --}}
                            @if(auth()->user()->role === 'admin' && $disposal->status->value == 'pending')
                                <div class="mt-6 pt-6 border-t-2 border-slate-100">
                                    <a href="{{ route('disposals.review', $disposal) }}"
                                        class="w-full flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl font-bold hover:from-red-700 hover:to-red-800 shadow-lg shadow-red-200 hover:shadow-xl transition-all duration-300 hover:-translate-y-0.5">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Review Disposal
                                    </a>
                                </div>
                            @endif

                            {{-- Back Button --}}
                            <div class="mt-4">
                                <a href="{{ route('disposals.index') }}"
                                    class="w-full flex items-center justify-center gap-2 px-6 py-3 bg-slate-100 text-slate-700 rounded-xl font-bold hover:bg-slate-200 transition-all duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                    </svg>
                                    Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- LIGHTBOX --}}
    <div id="lightbox" class="hidden fixed inset-0 bg-black/90 z-50 flex items-center justify-center p-4" onclick="closeLightbox()">
        <div class="relative max-w-6xl max-h-full">
            <button onclick="closeLightbox()" class="absolute -top-12 right-0 text-white hover:text-red-400 transition-colors">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <img src="{{ Storage::url($disposal->evidence_photo) }}" alt="Evidence Photo" class="max-w-full max-h-[90vh] rounded-xl shadow-2xl">
        </div>
    </div>

    @push('scripts')
    <script>
        function openLightbox() {
            document.getElementById('lightbox').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            event.stopPropagation();
            document.getElementById('lightbox').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLightbox();
            }
        });
    </script>
    @endpush
</x-app-layout>
