<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-50 text-slate-600">

    {{-- WRAPPER SIDEBAR: Sembunyikan total saat print --}}
    <div class="print:hidden">
        @include('layouts.sidebar')
    </div>

    {{-- MAIN CONTENT WRAPPER --}}
    {{-- Perhatikan penambahan class: print:ml-0 print:p-0 --}}
    <div id="main-content"
        class="p-4 sm:ml-64 min-h-screen flex flex-col print:ml-0 print:p-0 transition-all duration-300">

        {{-- HEADER: Sembunyikan saat print --}}
        <header
            class="mb-6 bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-30 rounded-xl px-6 py-4 flex justify-between items-center shadow-sm print:hidden">
            <h2 class="font-bold text-2xl text-slate-800 leading-tight tracking-tight">
                {{ $header ?? 'SIM Inventaris' }}
            </h2>
            <div class="flex items-center gap-4">
                <div class="text-sm text-right hidden sm:block">
                    <div class="font-medium text-slate-700">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-slate-500">{{ Auth::user()->email }}</div>
                </div>
                <div
                    class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-lg border-2 border-white shadow-sm">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
        </header>

        <main class="flex-grow">
            {{-- ALERTS: Sembunyikan saat print --}}
            @if (session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center gap-3 shadow-sm print:hidden"
                    role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-500" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <p class="font-bold">Sukses</p>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl shadow-sm print:hidden"
                    role="alert">
                    <div class="flex items-center gap-3 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-rose-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="font-bold">Terjadi Kesalahan</p>
                    </div>
                    <ul class="list-disc list-inside text-sm ml-9">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="fade-in print:animate-none">
                {{ $slot }}
            </div>
        </main>

        {{-- FOOTER: Sembunyikan saat print --}}
        <footer class="mt-10 py-6 text-center text-xs text-slate-400 print:hidden">
            &copy; {{ date('Y') }} SIM Inventaris. All rights reserved.
        </footer>
    </div>
</body>

</html>