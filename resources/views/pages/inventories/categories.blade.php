<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-bold text-2xl text-slate-800 leading-tight tracking-tight">
                {{ __('Kategori Inventaris') }}
            </h2>
            <p class="text-slate-500 text-sm">
                Pusat kontrol pengelolaan aset dan barang milik organisasi.
            </p>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                @foreach($categories as $category)
                    {{-- 
                        Logic dipanggil via Accessor ($category->theme).
                        Tidak ada lagi logika PHP yang berantakan di sini.
                    --}}
                    <a href="{{ route('inventaris.items', $category->id) }}" 
                       class="group relative flex flex-col h-full bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                        
                        {{-- Decorative Blob --}}
                        <div class="absolute -right-6 -top-6 w-24 h-24 rounded-full {{ $category->theme->classes['blob'] }} {{ $category->theme->classes['blob_hover'] }} transition-colors duration-300 blur-2xl opacity-60"></div>

                        {{-- Header: Icon & Arrow --}}
                        <div class="flex justify-between items-start mb-6 relative z-10">
                            <div class="w-14 h-14 rounded-xl {{ $category->theme->classes['bg_soft'] }} {{ $category->theme->classes['text'] }} flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300 shadow-sm ring-1 {{ $category->theme->classes['ring'] }}">
                                <x-category-icon :name="$category->theme->icon" class="w-7 h-7" />
                            </div>

                            {{-- Arrow Action --}}
                            <div class="text-slate-300 {{ $category->theme->classes['arrow_hover'] }} transition-colors duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="relative z-10 mt-2">
                            <h3 class="text-xl font-bold text-slate-800 mb-1 {{ $category->theme->classes['text_hover'] }} transition-colors capitalize tracking-tight">
                                {{ $category->name }}
                            </h3>
                            <p class="text-sm text-slate-500 line-clamp-2 leading-relaxed">
                                Kelola inventaris {{ strtolower($category->name) }}
                            </p>
                        </div>

                        {{-- Bottom Decoration Line --}}
                        <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r {{ $category->theme->classes['line_from'] }} {{ $category->theme->classes['line_to'] }} transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>
                    </a>
                @endforeach

            </div>
        </div>
    </div>
</x-app-layout>