<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <span class="text-slate-500">Sirkulasi /</span>
            <a href="{{ route('disposals.index') }}" class="text-slate-500 hover:text-slate-700 transition-colors">Disposal</a>
            <span class="text-slate-500">/</span>
            <span class="text-slate-800 font-bold">Ajukan Disposal</span>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-slate-50 via-red-50/30 to-slate-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div class="mb-8">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center shadow-xl shadow-red-200">
                        <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-3xl font-bold text-slate-900 tracking-tight">Ajukan Disposal Aset</h3>
                        <p class="text-slate-500 text-sm mt-1">Lengkapi form berikut untuk mengajukan penghapusan aset dari sistem</p>
                    </div>
                </div>
            </div>

            {{-- FORM --}}
            <form action="{{ route('disposals.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <input type="hidden" name="asset_detail_id" value="{{ $assetDetail->id }}">

                {{-- ASSET INFORMATION (READ-ONLY) --}}
                <div class="bg-white shadow-lg rounded-2xl border border-slate-200 overflow-hidden transform transition-all duration-300 hover:shadow-xl">
                    <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4">
                        <h4 class="font-bold text-white flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Informasi Aset yang Akan Di-disposal
                        </h4>
                    </div>
                    <div class="p-6 bg-gradient-to-br from-white to-indigo-50/30">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full"></span>
                                    Kode Aset
                                </label>
                                <div class="mt-2 text-base font-mono font-bold text-red-600 bg-white px-3 py-2.5 rounded-xl border-2 border-red-100 shadow-sm group-hover:border-red-200 transition-colors">
                                    {{ $assetDetail->unit_code }}
                                </div>
                            </div>
                            <div class="group">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full"></span>
                                    Nama Aset
                                </label>
                                <div class="mt-2 text-base font-bold text-slate-800 bg-white px-3 py-2.5 rounded-xl border-2 border-slate-100 shadow-sm group-hover:border-slate-200 transition-colors">
                                    {{ $assetDetail->inventory->name }}
                                </div>
                            </div>
                            <div class="group">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full"></span>
                                    Kategori
                                </label>
                                <div class="mt-2 text-sm text-slate-600 bg-white px-3 py-2.5 rounded-xl border-2 border-slate-100 shadow-sm group-hover:border-slate-200 transition-colors">
                                    {{ $assetDetail->inventory->category->name }}
                                </div>
                            </div>
                            <div class="group">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full"></span>
                                    Lokasi
                                </label>
                                <div class="mt-2 text-sm text-slate-600 bg-white px-3 py-2.5 rounded-xl border-2 border-slate-100 shadow-sm group-hover:border-slate-200 transition-colors">
                                    {{ $assetDetail->room->name }} - {{ $assetDetail->room->unit->name }}
                                </div>
                            </div>
                            <div class="group">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full"></span>
                                    Kondisi
                                </label>
                                <div class="mt-2 text-sm text-slate-600 bg-white px-3 py-2.5 rounded-xl border-2 border-slate-100 shadow-sm group-hover:border-slate-200 transition-colors">
                                    {{ ucfirst(str_replace('_', ' ', $assetDetail->condition)) }}
                                </div>
                            </div>
                            <div class="group">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full"></span>
                                    Harga Beli
                                </label>
                                <div class="mt-2 text-base font-bold text-emerald-600 bg-white px-3 py-2.5 rounded-xl border-2 border-emerald-100 shadow-sm group-hover:border-emerald-200 transition-colors">
                                    Rp {{ number_format($assetDetail->price, 0, ',', '.') }}
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
                    <div class="p-6 space-y-6">
                        {{-- Disposal Type --}}
                        <div>
                            <label for="disposal_type" class="block text-sm font-bold text-slate-700 mb-3 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                                Tipe Disposal
                            </label>
                            <select id="disposal_type" name="disposal_type" required
                                class="w-full rounded-xl border-2 border-slate-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all @error('disposal_type') border-red-500 @enderror py-3 px-4 text-sm font-medium">
                                <option value="">-- Pilih Tipe Disposal --</option>
                                @foreach($disposalTypes as $type)
                                    <option value="{{ $type->value }}" {{ old('disposal_type') == $type->value ? 'selected' : '' }}>
                                        {{ $type->label() }}
                                    </option>
                                @endforeach
                            </select>
                            @error('disposal_type')
                                <p class="mt-2 text-xs text-red-600 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Reason --}}
                        <div>
                            <label for="reason" class="block text-sm font-bold text-slate-700 mb-3 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                                Alasan Disposal
                                <span class="text-xs font-normal text-slate-500">(Minimal 20 karakter)</span>
                            </label>
                            <textarea id="reason" name="reason" rows="5" required minlength="20"
                                class="w-full rounded-xl border-2 border-slate-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all @error('reason') border-red-500 @enderror py-3 px-4 text-sm"
                                placeholder="Jelaskan secara detail alasan disposal aset ini...">{{ old('reason') }}</textarea>
                            <div class="mt-2 flex justify-between items-center">
                                @error('reason')
                                    <p class="text-xs text-red-600 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @else
                                    <p class="text-xs text-slate-500">Jelaskan kondisi aset dan alasan penghapusan secara detail.</p>
                                @enderror
                                <p class="text-xs font-bold" id="charCount">
                                    <span id="currentCount" class="text-slate-400">0</span>
                                    <span class="text-slate-300">/</span>
                                    <span class="text-emerald-600">20</span>
                                </p>
                            </div>
                        </div>

                        {{-- Evidence Photo with Drag & Drop --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-3 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                                Foto Bukti
                                <span class="text-xs font-normal text-slate-500">(Max 2MB, format: JPG, PNG)</span>
                            </label>
                            
                            <div id="dropZone" class="relative border-3 border-dashed border-slate-300 rounded-2xl p-8 text-center transition-all duration-300 hover:border-red-400 hover:bg-red-50/50 cursor-pointer group">
                                <input type="file" id="evidence_photo" name="evidence_photo" accept="image/jpeg,image/png,image/jpg" required class="hidden">
                                
                                <div id="uploadPrompt" class="space-y-4">
                                    <div class="w-20 h-20 mx-auto bg-gradient-to-br from-red-100 to-red-200 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-base font-bold text-slate-700 mb-1">Drag & drop foto di sini</p>
                                        <p class="text-sm text-slate-500">atau <span class="text-red-600 font-bold">klik untuk browse</span></p>
                                    </div>
                                    <p class="text-xs text-slate-400">JPG, PNG • Max 2MB</p>
                                </div>

                                <div id="imagePreview" class="hidden">
                                    <img id="preview" src="" alt="Preview" class="max-w-full max-h-96 mx-auto rounded-xl shadow-lg border-4 border-white">
                                    <button type="button" id="removeImage" class="mt-4 px-4 py-2 bg-red-100 text-red-700 rounded-lg text-sm font-bold hover:bg-red-200 transition-colors">
                                        Ganti Foto
                                    </button>
                                </div>
                            </div>

                            @error('evidence_photo')
                                <p class="mt-2 text-xs text-red-600 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Notes (Optional) --}}
                        <div>
                            <label for="notes" class="block text-sm font-bold text-slate-700 mb-3 flex items-center gap-2">
                                Catatan Tambahan
                                <span class="text-xs font-normal text-slate-500">(Opsional)</span>
                            </label>
                            <textarea id="notes" name="notes" rows="3"
                                class="w-full rounded-xl border-2 border-slate-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all py-3 px-4 text-sm"
                                placeholder="Catatan tambahan (misal: informasi kompensasi, dll)">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- ACTIONS --}}
                <div class="flex justify-end gap-4">
                    <a href="{{ route('asset.index', $assetDetail->inventory) }}"
                        class="px-8 py-3.5 bg-slate-200 text-slate-700 rounded-xl font-bold hover:bg-slate-300 transition-all duration-300 shadow-sm hover:shadow-md flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Batal
                    </a>
                    <button type="submit"
                        class="px-8 py-3.5 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl font-bold hover:from-red-700 hover:to-red-800 shadow-lg shadow-red-200 hover:shadow-xl hover:shadow-red-300 transition-all duration-300 flex items-center gap-2 hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Ajukan Disposal
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Character counter for reason
        const reasonTextarea = document.getElementById('reason');
        const currentCount = document.getElementById('currentCount');
        
        reasonTextarea.addEventListener('input', function() {
            const length = this.value.length;
            currentCount.textContent = length;
            
            if (length >= 20) {
                currentCount.classList.remove('text-slate-400');
                currentCount.classList.add('text-emerald-600', 'font-bold');
            } else {
                currentCount.classList.remove('text-emerald-600', 'font-bold');
                currentCount.classList.add('text-slate-400');
            }
        });

        // Drag & Drop + Image preview
        const dropZone = document.getElementById('dropZone');
        const photoInput = document.getElementById('evidence_photo');
        const uploadPrompt = document.getElementById('uploadPrompt');
        const imagePreview = document.getElementById('imagePreview');
        const preview = document.getElementById('preview');
        const removeBtn = document.getElementById('removeImage');

        // Click to browse
        dropZone.addEventListener('click', () => photoInput.click());

        // Drag & Drop events
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.add('border-red-500', 'bg-red-100');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.remove('border-red-500', 'bg-red-100');
            });
        });

        dropZone.addEventListener('drop', (e) => {
            const files = e.dataTransfer.files;
            if (files.length) {
                photoInput.files = files;
                handleFile(files[0]);
            }
        });

        photoInput.addEventListener('change', (e) => {
            if (e.target.files.length) {
                handleFile(e.target.files[0]);
            }
        });

        function handleFile(file) {
            // Validate file size (2MB)
            if (file.size > 2097152) {
                alert('Ukuran file terlalu besar! Maksimal 2MB.');
                photoInput.value = '';
                return;
            }
            
            // Validate file type
            if (!['image/jpeg', 'image/png', 'image/jpg'].includes(file.type)) {
                alert('Format file tidak valid! Gunakan JPG, PNG, atau JPEG.');
                photoInput.value = '';
                return;
            }
            
            // Show preview
            const reader = new FileReader();
            reader.onload = (e) => {
                preview.src = e.target.result;
                uploadPrompt.classList.add('hidden');
                imagePreview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }

        removeBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            photoInput.value = '';
            uploadPrompt.classList.remove('hidden');
            imagePreview.classList.add('hidden');
        });
    </script>
    @endpush
</x-app-layout>
