<x-guest-layout>
    <!-- Header Section with Logo (Consistent with Sidebar) -->
    <div class="mb-8 flex flex-col items-center text-center">
        <div class="relative flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-600 text-white font-bold text-xl shadow-lg shadow-indigo-500/30 mb-4">
            S
            <div class="absolute inset-0 rounded-xl ring-1 ring-inset ring-white/20"></div>
        </div>
        <h2 class="text-2xl font-bold tracking-tight text-slate-900">Selamat Datang Kembali</h2>
        <p class="text-slate-500 text-sm mt-2">Masuk untuk mengelola inventaris aset</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="sr-only" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <!-- Icon Email -->
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <x-text-input id="email" 
                    class="block w-full pl-10 pr-3 py-2.5 border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg text-sm placeholder:text-slate-400 shadow-sm transition-all" 
                    type="email" name="email" :value="old('email')" required autofocus autocomplete="username" 
                    placeholder="nama@perusahaan.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="sr-only" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <!-- Icon Lock -->
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <x-text-input id="password" 
                    class="block w-full pl-10 pr-3 py-2.5 border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg text-sm placeholder:text-slate-400 shadow-sm transition-all" 
                    type="password" name="password" required autocomplete="current-password" 
                    placeholder="Password Anda" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" 
                    class="rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500 cursor-pointer transition ease-in-out duration-150" 
                    name="remember">
                <span class="ms-2 text-sm text-slate-500 group-hover:text-slate-700 transition-colors">{{ __('Ingat saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors" 
                   href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" 
                class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-lg shadow-indigo-500/30 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:-translate-y-0.5">
                {{ __('Masuk ke Dashboard') }}
            </button>
        </div>
    </form>
    
    <!-- Footer Context (Optional) -->
    <div class="mt-6 text-center">
        <p class="text-xs text-slate-400">
            &copy; {{ date('Y') }} Sistem Informasi Manajemen Inventaris
        </p>
    </div>
</x-guest-layout>