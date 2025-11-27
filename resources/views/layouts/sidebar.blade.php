<aside
   class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 bg-slate-900 border-r border-slate-800 flex flex-col"
   aria-label="Sidebar">

   <div class="shrink-0 px-6 py-6 bg-slate-900 z-10">
      <div class="flex items-center gap-3">
         <div
            class="h-8 w-8 rounded bg-indigo-500 flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-indigo-500/20">
            S
         </div>
         <span class="self-center text-xl font-bold whitespace-nowrap text-white tracking-tight">SIM INVENTARIS</span>
      </div>
   </div>

   <div class="flex-1 px-3 pb-4 overflow-y-auto custom-scrollbar">
      <ul class="space-y-1 font-medium">
         <li>
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
               class="flex items-center p-2 rounded-lg group {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
               <svg
                  class="w-5 h-5 transition duration-75 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}"
                  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                  <path
                     d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                  <path
                     d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
               </svg>
               <span class="ms-3">Dashboard</span>
            </x-nav-link>
         </li>

         <div class="pt-6 pb-2 px-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Aset & Barang</div>

         <li>
            <x-nav-link :href="route('inventaris.categories')" :active="request()->routeIs('inventaris*')"
               class="flex items-center p-2 rounded-lg group {{ request()->routeIs('inventaris*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
               <svg
                  class="w-5 h-5 transition duration-75 {{ request()->routeIs('inventaris*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}"
                  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                  <path fill-rule="evenodd"
                     d="M4 4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H4Zm10 5a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm0 3a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm0 3a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm-8-5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm1.942 4a3 3 0 0 0-2.847 2.051l-.044.133-.004.012c-.042.126-.055.167-.042.195.006.013.02.023.038.039.032.025.08.064.146.155A1 1 0 0 0 6 17h6a1 1 0 0 0 .811-.415.713.713 0 0 1 .146-.155c.019-.016.031-.026.038-.04.014-.027 0-.068-.042-.194l-.004-.012-.044-.133A3 3 0 0 0 10.059 14H7.942Z"
                     clip-rule="evenodd" />
               </svg>
               <span class="ms-3">Inventaris (Aset)</span>
            </x-nav-link>
         </li>

         <li>
            <x-nav-link :href="route('bhp.categories')" :active="request()->routeIs('bhp*')"
               class="flex items-center p-2 rounded-lg group {{ request()->routeIs('bhp*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
               <svg
                  class="w-5 h-5 transition duration-75 {{ request()->routeIs('bhp*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}"
                  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                  <path fill-rule="evenodd"
                     d="M12 2a1 1 0 0 1 1 1v1h3a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h3V3a1 1 0 0 1 1-1Zm-2 4a1 1 0 0 0-1 1v7a1 1 0 1 0 2 0V7a1 1 0 0 0-1-1Zm4 0a1 1 0 0 0-1 1v7a1 1 0 1 0 2 0V7a1 1 0 0 0-1-1Z"
                     clip-rule="evenodd" />
               </svg>
               <span class="ms-3">Barang Habis Pakai</span>
            </x-nav-link>
         </li>

         <div class="pt-6 pb-2 px-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Akuisisi</div>

         <li>
            <x-nav-link :href="route('pengadaan.index')" :active="request()->routeIs('pengadaan*')"
               class="flex items-center p-2 rounded-lg group {{ request()->routeIs('pengadaan*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
               <svg
                  class="w-5 h-5 transition duration-75 {{ request()->routeIs('pengadaan*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}"
                  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                  <path fill-rule="evenodd"
                     d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586a2 2 0 0 1 .5-.365Zm2.243 0A2 2 0 0 1 11.5 2.586L15.414 6.5a2 2 0 0 1 .586 1.414V19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8a2 2 0 0 1 .586-1.414l3.914-3.914A2 2 0 0 1 7.243 2.221H11.243ZM17 9a1 1 0 0 0-1 1v2h-2a1 1 0 1 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0-2h-2v-2a1 1 0 0 0-1-1Z"
                     clip-rule="evenodd" />
               </svg>
               <span class="ms-3">Usulan Pengadaan</span>
            </x-nav-link>
         </li>

         <div class="pt-6 pb-2 px-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Data Master</div>

         <li>
            <x-nav-link :href="route('ruangan.index')" :active="request()->routeIs('ruangan*')"
               class="flex items-center p-2 rounded-lg group {{ request()->routeIs('ruangan*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
               <svg
                  class="w-5 h-5 transition duration-75 {{ request()->routeIs('ruangan*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}"
                  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                  <path fill-rule="evenodd"
                     d="M4 4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H4Zm16 14H4V6h16v12ZM10 8a1 1 0 0 1 1 1v4a1 1 0 1 1-2 0V9a1 1 0 0 1 1-1Z"
                     clip-rule="evenodd" />
               </svg>
               <span class="ms-3">Ruangan</span>
            </x-nav-link>
         </li>

         <li>
            <x-nav-link :href="route('unit.index')" :active="request()->routeIs('unit*')"
               class="flex items-center p-2 rounded-lg group {{ request()->routeIs('unit*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
               <svg
                  class="w-5 h-5 transition duration-75 {{ request()->routeIs('unit*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}"
                  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                  <path fill-rule="evenodd"
                     d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.762A5.998 5.998 0 0 1 19.5 18ZM4 7.5a3.5 3.5 0 0 1 5.477-2.889 5.5 5.5 0 0 0-2.796 6.293A5.48 5.48 0 0 0 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4 2 2 0 0 0 2 2h.5a5.998 5.998 0 0 1 1.965-5.038A5.513 5.513 0 0 1 7.1 12Z"
                     clip-rule="evenodd" />
               </svg>
               <span class="ms-3">Unit / Divisi</span>
            </x-nav-link>
         </li>

         <li>
            <x-nav-link :href="route('sumber-dana.index')" :active="request()->routeIs('sumber-dana*')"
               class="flex items-center p-2 rounded-lg group {{ request()->routeIs('sumber-dana*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
               <svg
                  class="w-5 h-5 transition duration-75 {{ request()->routeIs('sumber-dana*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}"
                  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                  <path fill-rule="evenodd"
                     d="M7 2a2 2 0 0 0-2 2v1a1 1 0 0 0 0 2v1a1 1 0 0 0 0 2v1a1 1 0 1 0 0 2v1a1 1 0 1 0 0 2v1a1 1 0 1 0 0 2v1a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H7Zm3 8a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm-1 7a3 3 0 0 1 3-3h2a3 3 0 0 1 3 3 1 1 0 0 1-1 1h-6a1 1 0 0 1-1-1Z"
                     clip-rule="evenodd" />
               </svg>
               <span class="ms-3">Sumber Dana</span>
            </x-nav-link>
         </li>

         <div class="pt-6 pb-2 px-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Sirkulasi</div>

         <li>
            <x-nav-link :href="route('transaksi.index')" :active="request()->routeIs('transaksi*')"
               class="flex items-center p-2 rounded-lg group {{ request()->routeIs('transaksi*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
               <svg
                  class="w-5 h-5 transition duration-75 {{ request()->routeIs('transaksi*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}"
                  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                  <path fill-rule="evenodd"
                     d="M4 4a1 1 0 0 1 1-1h1.5a1 1 0 0 1 .979.796L7.939 6H19a1 1 0 0 1 .979 1.204l-1.25 6a1 1 0 0 1-.979.796H9.605l.208 1H17a3 3 0 1 1-2.83 2h-2.34a3 3 0 1 1-4.009-1.76L5.686 5H5a1 1 0 0 1-1-1Z"
                     clip-rule="evenodd" />
               </svg>
               <span class="ms-3">Transaksi BHP</span>
            </x-nav-link>
         </li>

         <li>
            <x-nav-link :href="route('peminjaman.index')" :active="request()->routeIs('peminjaman*')"
               class="flex items-center p-2 rounded-lg group {{ request()->routeIs('peminjaman*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
               <svg
                  class="w-5 h-5 transition duration-75 {{ request()->routeIs('peminjaman*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}"
                  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                  <path fill-rule="evenodd"
                     d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z"
                     clip-rule="evenodd" />
               </svg>
               <span class="ms-3">Peminjaman Aset</span>
            </x-nav-link>
         </li>

         <li>
            <x-nav-link :href="route('mutasi.index')" :active="request()->routeIs('mutasi*')"
               class="flex items-center p-2 rounded-lg group {{ request()->routeIs('mutasi*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
               <svg
                  class="w-5 h-5 transition duration-75 {{ request()->routeIs('mutasi*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}"
                  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                  viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
               </svg>
               <span class="ms-3">Mutasi Aset</span>
            </x-nav-link>
         </li>

         <div class="pt-6 pb-2 px-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Pengaturan</div>

         <li>
            <x-nav-link :href="route('users.index')" :active="request()->routeIs('users*')"
               class="flex items-center p-2 rounded-lg group {{ request()->routeIs('users*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
               <svg
                  class="w-5 h-5 transition duration-75 {{ request()->routeIs('users*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}"
                  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                  <path fill-rule="evenodd"
                     d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z"
                     clip-rule="evenodd" />
               </svg>
               <span class="ms-3">Manajemen Pengguna</span>
            </x-nav-link>
         </li>

         <div class="pt-6 pb-2 px-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Laporan</div>

         <li>
            <x-nav-link :href="route('report.index')" :active="request()->routeIs('report*')"
               class="flex items-center p-2 rounded-lg group {{ request()->routeIs('report*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
               <svg
                  class="w-5 h-5 transition duration-75 {{ request()->routeIs('report*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}"
                  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                  <path fill-rule="evenodd"
                     d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586a2 2 0 0 1 .5-.365Zm2.243 0A2 2 0 0 1 11.5 2.586L15.414 6.5a2 2 0 0 1 .586 1.414V19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8a2 2 0 0 1 .586-1.414l3.914-3.914A2 2 0 0 1 7.243 2.221H11.243ZM17 9a1 1 0 0 0-1 1v2h-2a1 1 0 1 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0-2h-2v-2a1 1 0 0 0-1-1Z"
                     clip-rule="evenodd" />
               </svg>
               <span class="ms-3">Pusat Laporan</span>
            </x-nav-link>
         </li>

         <li class="mt-8 pt-4 border-t border-slate-800">
            <form method="POST" action="{{ route('logout') }}">
               @csrf
               <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                  class="flex items-center p-2 text-rose-400 rounded-lg hover:bg-rose-900/20 group cursor-pointer transition-colors">
                  <svg class="w-5 h-5 text-rose-500 transition duration-75 group-hover:text-rose-400" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16">
                     <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3" />
                  </svg>
                  <span class="ms-3">Logout</span>
               </a>
            </form>
         </li>
      </ul>
   </div>
</aside>