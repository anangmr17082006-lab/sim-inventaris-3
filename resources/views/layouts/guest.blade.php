<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-slate-900 antialiased">
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-slate-900 to-slate-800">
        <div>
            <a href="/" class="flex flex-col items-center gap-2">
                <div
                    class="h-16 w-16 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-bold text-3xl shadow-lg">
                    S
                </div>
                <span class="text-white font-bold text-xl tracking-tight">SIM INVENTARIS</span>
            </a>
        </div>

        <div
            class="w-full sm:max-w-md mt-8 px-8 py-8 bg-white shadow-2xl overflow-hidden sm:rounded-2xl border border-slate-100">
            {{ $slot }}
        </div>

        <div class="mt-8 text-slate-500 text-sm">
            &copy; {{ date('Y') }} SIM Inventaris System
        </div>
    </div>
</body>

</html>