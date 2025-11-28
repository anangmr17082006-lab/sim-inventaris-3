<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <span class="text-slate-500">Sirkulasi /</span>
            <a href="{{ route('disposals.index') }}"
                class="text-slate-500 hover:text-slate-700 transition-colors">Disposal</a>
            <span class="text-slate-500">/</span>
            <span class="text-slate-800 font-bold">Review #{{ $disposal->id }}</span>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-slate-50 via-red-50/30 to-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div class="mb-8">
                <div class="flex items-center gap-4">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center shadow-xl shadow-red-200 animate-pulse">
                        <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-3xl font-bold text-slate-900 tracking-tight">Review Disposal Aset</h3>
                        <p class="text-slate-500 text-sm mt-1">Periksa detail disposal dan berikan keputusan</p>
                    </div>
                </div>
            </div>

            {{-- IMPORTANT NOTICE --}}
            <div
                class="mb-6 bg-gradient-to-r from-amber-50 via-amber-100/50 to-amber-50 border-l-4 border-amber-500 rounded-xl p-6 shadow-lg">
                <div class="flex items-start gap-4">
                    <div
                        class="w-12 h-12 bg-amber-500 rounded-full flex items-center justify-center flex-shrink-0 shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-amber-900 text-lg mb-2">Perhatian Penting!</h4>
                        <ul class="space-y-1 text-sm text-amber-800">
                            <li class="flex items-start gap-2">
                                <span class="text-amber-600 mt-0.5">•</span>
                                <span>Periksa foto bukti dan alasan disposal dengan teliti</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-amber-600 mt-0.5">•</span>
                                <span>Pastikan alasan disposal valid dan sesuai dengan kondisi aset</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-amber-600 mt-0.5">•</span>
                                <span><strong>Disposal yang disetujui tidak dapat dibatalkan</strong> - aset akan
                                    dihapus permanen dari sistem</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- LEFT COLUMN - INFO --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- ASSET INFORMATION --}}
                    <div class="bg-white shadow-lg rounded-2xl border border-slate-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4">
                            <h4 class="font-bold text-white flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                Informasi Lengkap Aset
                            </h4>
                        </div>
                        <div class="p-6 bg-gradient-to-br from-white to-indigo-50/20">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="col-span-2 bg-white rounded-xl p-4 border-2 border-indigo-100 shadow-sm">
                                    <label
                                        class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block">Kode
                                        Aset</label>
                                    <div class="text-2xl font-mono font-bold text-red-600">
                                        {{ $disposal->assetDetail->unit_code }}</div>
                                </div>
                                <div class="col-span-2 bg-white rounded-xl p-4 border-2 border-slate-100 shadow-sm">
                                    <label
                                        class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block">Nama
                                        Aset</label>
                                    <div class="text-lg font-bold text-slate-800">
                                        {{ $disposal->assetDetail->inventory->name }}</div>
                                </div>
                                <div class="bg-white rounded-xl p-4 border-2 border-slate-100 shadow-sm">
                                    <label
                                        class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block">Model/Tipe</label>
                                    <div class="text-sm text-slate-600 font-medium">
                                        {{ $disposal->assetDetail->model ?? '-' }}</div>
                                </div>
                                <div class="bg-white rounded-xl p-4 border-2 border-slate-100 shadow-sm">
                                    <label
                                        class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block">Kategori</label>
                                    <div class="text-sm text-slate-600 font-medium">
                                        {{ $disposal->assetDetail->inventory->category->name }}</div>
                                </div>
                                <div class="bg-white rounded-xl p-4 border-2 border-slate-100 shadow-sm">
                                    <label
                                        class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block">Lokasi</label>
                                    <div class="text-sm text-slate-600 font-medium">
                                        {{ $disposal->assetDetail->room->name }}</div>
                                    <div class="text-xs text-slate-400 mt-1">
                                        {{ $disposal->assetDetail->room->unit->name }}</div>
                                </div>
                                <div class="bg-white rounded-xl p-4 border-2 border-slate-100 shadow-sm">
                                    <label
                                        class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block">Kondisi</label>
                                    <div class="text-sm text-slate-600 font-medium">
                                        {{ ucfirst(str_replace('_', ' ', $disposal->assetDetail->condition)) }}</div>
                                </div>
                                <div class="bg-white rounded-xl p-4 border-2 border-slate-100 shadow-sm">
                                    <label
                                        class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block">Tanggal
                                        Pembelian</label>
                                    <div class="text-sm text-slate-600 font-medium">
                                        {{ \Carbon\Carbon::parse($disposal->assetDetail->purchase_date)->format('d M Y') }}
                                    </div>
                                </div>
                                <div class="bg-white rounded-xl p-4 border-2 border-slate-100 shadow-sm">
                                    <label
                                        class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block">Sumber
                                        Dana</label>
                                    <div class="text-sm text-slate-600 font-medium">
                                        {{ $disposal->assetDetail->fundingSource->name ?? '-' }}</div>
                                </div>
                                <div
                                    class="col-span-2 bg-gradient-to-br from-emerald-50 to-white rounded-xl p-4 border-2 border-emerald-200 shadow-sm">
                                    <label
                                        class="text-xs font-bold text-emerald-700 uppercase tracking-wider mb-2 block">Nilai
                                        Buku (Harga Beli)</label>
                                    <div class="text-3xl font-bold text-emerald-600">
                                        Rp {{ number_format($disposal->assetDetail->price, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- DISPOSAL REQUEST DETAILS --}}
                    <div class="bg-white shadow-lg rounded-2xl border border-slate-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-4">
                            <h4 class="font-bold text-white flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                Detail Pengajuan Disposal
                            </h4>
                        </div>
                        <div class="p-6 space-y-4">
                            <div
                                class="bg-gradient-to-br from-slate-50 to-white rounded-xl p-4 border-2 border-slate-100 shadow-sm">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block">Tipe
                                    Disposal</label>
                                <span
                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-bold bg-{{ $disposal->disposal_type->color() }}-50 text-{{ $disposal->disposal_type->color() }}-700 border-2 border-{{ $disposal->disposal_type->color() }}-200">
                                    {{ $disposal->disposal_type->label() }}
                                </span>
                            </div>
                            <div
                                class="bg-gradient-to-br from-slate-50 to-white rounded-xl p-4 border-2 border-slate-100 shadow-sm">
                                <label
                                    class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block">Alasan
                                    Disposal</label>
                                <p class="text-sm text-slate-700 leading-relaxed">{{ $disposal->reason }}</p>
                            </div>
                            <div
                                class="bg-gradient-to-br from-indigo-50 to-white rounded-xl p-4 border-2 border-indigo-100 shadow-sm">
                                <label
                                    class="text-xs font-bold text-indigo-700 uppercase tracking-wider mb-2 block">Diajukan
                                    Oleh</label>
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold shadow">
                                        {{ substr($disposal->requester->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-slate-800">{{ $disposal->requester->name }}
                                        </div>
                                        <div class="text-xs text-slate-500">{{ $disposal->requester->email }}</div>
                                        <div class="text-xs text-slate-400 mt-1">
                                            {{ \Carbon\Carbon::parse($disposal->created_at)->format('d M Y, H:i') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- EVIDENCE PHOTO --}}
                    <div class="bg-white shadow-lg rounded-2xl border border-slate-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                            <h4 class="font-bold text-white flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                Foto Bukti Kondisi Aset
                            </h4>
                        </div>
                        <div class="p-6">
                            <div class="relative group cursor-pointer" onclick="openLightbox()">
                                <img src="{{ Storage::url($disposal->evidence_photo) }}" alt="Evidence Photo"
                                    class="w-full rounded-xl shadow-lg border-4 border-white group-hover:shadow-2xl transition-all duration-300">
                                <div
                                    class="absolute inset-0 bg-black/0 group-hover:bg-black/40 rounded-xl transition-all duration-300 flex items-center justify-center">
                                    <div
                                        class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-white rounded-full p-4 shadow-xl">
                                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <p class="text-xs text-slate-500 text-center mt-3">Klik untuk memperbesar</p>
                        </div>
                    </div>
                </div>

                {{-- RIGHT COLUMN - ACTIONS --}}
                <div class="lg:col-span-1 space-y-6">

                    {{-- APPROVE FORM --}}
                    <div
                        class="bg-white shadow-lg rounded-2xl border-2 border-emerald-200 overflow-hidden sticky top-6">
                        <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 px-6 py-4">
                            <h4 class="font-bold text-white flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Setujui Disposal
                            </h4>
                        </div>
                        <form action="{{ route('disposals.approve', $disposal) }}" method="POST" id="approveForm"
                            class="p-6 space-y-4">
                            @csrf
                            <div>
                                <label for="approve_notes" class="block text-sm font-bold text-slate-700 mb-2">
                                    Catatan Admin <span class="text-xs font-normal text-slate-500">(Opsional)</span>
                                </label>
                                <textarea id="approve_notes" name="notes" rows="4"
                                    class="w-full rounded-xl border-2 border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all py-3 px-4 text-sm"
                                    placeholder="Catatan tambahan untuk persetujuan..."></textarea>
                            </div>

                            <div
                                class="bg-gradient-to-br from-red-50 to-rose-50 border-2 border-red-200 rounded-xl p-4">
                                <div class="flex items-start gap-3">
                                    <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                        </path>
                                    </svg>
                                    <div class="text-xs text-red-800 leading-relaxed">
                                        <strong class="block mb-1">Perhatian!</strong>
                                        Menyetujui disposal akan menghapus aset dari sistem (soft delete). Aset tidak
                                        dapat dikembalikan setelah disetujui.
                                    </div>
                                </div>
                            </div>

                            <button type="button" onclick="confirmApprove()"
                                class="w-full flex items-center justify-center gap-2 px-6 py-4 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white rounded-xl font-bold hover:from-emerald-700 hover:to-emerald-800 shadow-lg shadow-emerald-200 hover:shadow-xl transition-all duration-300 hover:-translate-y-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Setujui Disposal
                            </button>
                        </form>
                    </div>

                    {{-- REJECT FORM --}}
                    <div class="bg-white shadow-lg rounded-2xl border-2 border-rose-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-rose-500 to-rose-600 px-6 py-4">
                            <h4 class="font-bold text-white flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Tolak Disposal
                            </h4>
                        </div>
                        <form action="{{ route('disposals.reject', $disposal) }}" method="POST" id="rejectForm"
                            class="p-6 space-y-4">
                            @csrf
                            <div>
                                <label for="rejection_reason"
                                    class="block text-sm font-bold text-slate-700 mb-2 flex items-center gap-1">
                                    <span class="text-red-500">*</span>
                                    Alasan Penolakan
                                    <span class="text-xs font-normal text-slate-500">(Min 10 karakter)</span>
                                </label>
                                <textarea id="rejection_reason" name="rejection_reason" rows="4" required minlength="10"
                                    class="w-full rounded-xl border-2 border-slate-300 focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition-all py-3 px-4 text-sm @error('rejection_reason') border-red-500 @enderror"
                                    placeholder="Jelaskan alasan penolakan disposal..."></textarea>
                                @error('rejection_reason')
                                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="button" onclick="confirmReject()"
                                class="w-full flex items-center justify-center gap-2 px-6 py-4 bg-gradient-to-r from-rose-600 to-rose-700 text-white rounded-xl font-bold hover:from-rose-700 hover:to-rose-800 shadow-lg shadow-rose-200 hover:shadow-xl transition-all duration-300 hover:-translate-y-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Tolak Disposal
                            </button>
                        </form>
                    </div>

                    {{-- BACK BUTTON --}}
                    <a href="{{ route('disposals.index') }}"
                        class="block w-full text-center px-6 py-3 bg-slate-100 text-slate-700 rounded-xl font-bold hover:bg-slate-200 transition-all duration-300">
                        ← Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- LIGHTBOX --}}
    <div id="lightbox" class="hidden fixed inset-0 bg-black/90 z-50 flex items-center justify-center p-4"
        onclick="closeLightbox()">
        <div class="relative max-w-6xl max-h-full">
            <button onclick="closeLightbox()"
                class="absolute -top-12 right-0 text-white hover:text-red-400 transition-colors">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <img src="{{ Storage::url($disposal->evidence_photo) }}" alt="Evidence Photo"
                class="max-w-full max-h-[90vh] rounded-xl shadow-2xl">
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

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') closeLightbox();
            });

            function confirmApprove() {
                if (confirm('⚠️ KONFIRMASI PERSETUJUAN\n\nYakin menyetujui disposal aset ini?\n\nAset akan dihapus dari sistem dan tidak dapat dikembalikan.\n\nKlik OK untuk melanjutkan.')) {
                    document.getElementById('approveForm').submit();
                }
            }

            function confirmReject() {
                const reason = document.getElementById('rejection_reason').value;
                if (reason.length < 10) {
                    alert('Alasan penolakan minimal 10 karakter!');
                    return;
                }
                if (confirm('Yakin menolak disposal aset ini?\n\nAset akan tetap aktif dalam sistem.\n\nKlik OK untuk melanjutkan.')) {
                    document.getElementById('rejectForm').submit();
                }
            }
        </script>
    @endpush
</x-app-layout>