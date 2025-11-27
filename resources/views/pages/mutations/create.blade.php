<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="text-slate-500">Sirkulasi /</span>
                <span class="text-slate-800 font-bold">Form Mutasi Aset</span>
            </div>
            <a href="{{ route('mutasi.index') }}" class="text-sm text-slate-500 hover:text-slate-700 transition-colors">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50/50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200 p-8">

                <div class="mb-8 border-b border-slate-100 pb-6 bg-slate-50/50 -mx-8 -mt-8 px-8 py-6">
                    <h3 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                        Form Pengajuan Mutasi Aset
                    </h3>
                    <p class="text-sm text-slate-500 mt-1 ml-7">Ajukan perpindahan aset antar ruangan. Mutasi akan
                        menunggu approval admin.</p>
                </div>

                <form action="{{ route('mutasi.store') }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <label class="block font-bold text-sm text-slate-700 mb-2">Pilih Aset <span
                                class="text-rose-500">*</span></label>
                        <select name="asset_id" id="assetSelect"
                            class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                            required>
                            <option value="">-- Pilih Aset yang Akan Dimutasi --</option>
                            @foreach($assets as $asset)
                                <option value="{{ $asset->id }}" data-room="{{ $asset->room->name }}"
                                    data-unit="{{ $asset->room->unit->name ?? '' }}"data-name="{{ $asset->inventory->name }} - {{ $asset->model_name }}"
                                        data-code="{{ $asset->unit_code }}">
                                        {{ $asset->inventory->name }} - {{ $asset->model_name }} [{{ $asset->unit_code }}]
                                        ({{ $asset->room->name }})
                                    </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-indigo-600 mt-1 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            Ketik untuk search aset (nama, kode, atau lokasi)
                        </p>
                        @error('asset_id') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-6 bg-slate-50 border border-slate-200 rounded-lg p-4">
                        <label class="block font-bold text-xs text-slate-600 mb-2">Ruangan Asal (Saat Ini)</label>
                        <div id="currentRoom" class="text-sm font-bold text-slate-800">Pilih aset terlebih dahulu</div>
                        <div id="currentUnit" class="text-xs text-slate-500"></div>
                    </div>

                    <div class="mb-6">
                        <label class="block font-bold text-sm text-slate-700 mb-2">Ruangan Tujuan <span
                                class="text-rose-500">*</span></label>
                        <select name="to_room_id"
                            class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                            required>
                            <option value="">-- Pilih Ruangan Tujuan --</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}">{{ $room->name }} ({{ $room->unit->name ?? '' }})</option>
                            @endforeach
                        </select>
                        @error('to_room_id') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block font-bold text-sm text-slate-700 mb-2">Tanggal Mutasi <span
                                    class="text-rose-500">*</span></label>
                            <input type="date" name="mutation_date" value="{{ date('Y-m-d') }}"
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                required>
                            @error('mutation_date') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block font-bold text-sm text-slate-700 mb-2">Kondisi Aset <span
                                    class="text-rose-500">*</span></label>
                            <select name="asset_condition"
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                required>
                                <option value="baik">Baik (Normal)</option>
                                <option value="rusak_ringan">Rusak Ringan</option>
                                <option value="rusak_berat">Rusak Berat</option>
                            </select>
                            @error('asset_condition') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block font-bold text-sm text-slate-700 mb-2">Alasan Mutasi <span
                                class="text-rose-500">*</span></label>
                        <textarea name="reason" rows="3"
                            class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                            placeholder="Minimal 10 karakter. Contoh: Perpindahan aset untuk kebutuhan laboratorium baru..."
                            required></textarea>
                        <p class="text-xs text-slate-400 mt-1">Jelaskan alasan perpindahan aset ini.</p>
                        @error('reason') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-8">
                        <label class="block font-bold text-sm text-slate-700 mb-2">Catatan Tambahan</label>
                        <textarea name="notes" rows="2"
                            class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                            placeholder="Catatan opsional..."></textarea>
                        @error('notes') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end items-center gap-4 pt-6 border-t border-slate-100">
                        <a href="{{ route('mutasi.index') }}"
                            class="text-slate-600 hover:text-slate-800 text-sm font-bold transition-colors px-4 py-2 rounded-lg hover:bg-slate-50">Batal</a>
                        <button type="submit"
                            class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 flex items-center gap-2">
                            <span>Ajukan Mutasi</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Custom Select2 styling to match Tailwind */
        .select2-container--default .select2-selection--single {
            border: 1px solid rgb(203 213 225);
            border-radius: 0.5rem;
            height: 42px;
            padding: 0.5rem 0.75rem;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 26px;
            color: rgb(51 65 85);
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px;
        }
        
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: rgb(99 102 241);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        
        .select2-dropdown {
            border: 1px solid rgb(203 213 225);
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        .select2-search--dropdown .select2-search__field {
            border: 1px solid rgb(203 213 225);
            border-radius: 0.375rem;
            padding: 0.5rem;
        }
        
        .select2-results__option--highlighted {
            background-color: rgb(99 102 241) !important;
        }
        
        .select2-container {
            width: 100% !important;
        }
    </style>

    <script>
        $(document).ready(function() {
            // Initialize Select2 on asset dropdown
            $('#assetSelect').select2({
                placeholder: '-- Cari Aset (ketik untuk search) --',
                allowClear: true,
                width: '100%',
                templateResult: formatAsset,
                templateSelection: formatAssetSelection
            });

            // Custom formatting for dropdown options
            function formatAsset(asset) {
                if (!asset.id) {
                    return asset.text;
                }
                
                var $asset = $(
                    '<div class="flex flex-col py-1">' +
                        '<div class="font-bold text-slate-800">' + $(asset.element).data('name') + '</div>' +
                        '<div class="text-xs text-slate-500">' +
                            '<span class="font-mono text-indigo-600">' + $(asset.element).data('code') + '</span>' +
                            ' • ' + $(asset.element).data('room') +
                        '</div>' +
                    '</div>'
                );
                return $asset;
            }

            function formatAssetSelection(asset) {
                if (!asset.id) {
                    return asset.text;
                }
                return $(asset.element).data('name') + ' [' + $(asset.element).data('code') + ']';
            }

            // Update current room when asset is selected
            $('#assetSelect').on('select2:select', function(e) {
                var data = e.params.data;
                var selected = $(data.element);
                var roomName = selected.data('room');
                var unitName = selected.data('unit');
                
                if (roomName) {
                    $('#currentRoom').text(roomName);
                    $('#currentUnit').text(unitName);
                } else {
                    $('#currentRoom').text('Pilih aset terlebih dahulu');
                    $('#currentUnit').text('');
                }
            });

            // Clear current room when selection is cleared
            $('#assetSelect').on('select2:clear', function() {
                $('#currentRoom').text('Pilih aset terlebih dahulu');
                $('#currentUnit').text('');
            });
        });
    </script>
</x-app-layout>