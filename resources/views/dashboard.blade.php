<x-app-layout>
    <x-slot name="header">
        {{ __('Dashboard Overview') }}
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Welcome Section - Enhanced -->
            <div
                class="mb-8 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 rounded-3xl p-8 text-white shadow-2xl relative overflow-hidden transform hover:scale-[1.02] transition-all duration-300">
                <div class="relative z-10">
                    <h1 class="text-4xl font-extrabold mb-3 animate-fade-in">
                        Selamat Datang, {{ Auth::user()->name }}! 👋
                    </h1>
                    <p class="text-indigo-100 text-lg opacity-90">
                        Berikut adalah ringkasan aktivitas dan status inventaris hari ini.
                    </p>
                </div>
                <!-- Decorative Elements -->
                <div class="absolute right-0 top-0 h-full w-1/2 bg-white/10 transform skew-x-12 translate-x-20"></div>
                <div class="absolute right-10 top-10 h-40 w-40 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute left-10 bottom-10 h-32 w-32 bg-white/10 rounded-full blur-2xl"></div>
                <div class="absolute right-0 bottom-0 h-24 w-24 bg-white/5 rounded-full blur-xl"></div>
            </div>

            <!-- Stats Grid - Enhanced -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                <!-- Card 1 - Total Aset -->
                <div
                    class="group bg-white rounded-2xl p-6 shadow-md border-2 border-transparent hover:border-blue-200 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-2">Total Aset</p>
                            <h3
                                class="text-3xl font-extrabold text-slate-800 transition-colors group-hover:text-blue-600">
                                Rp {{ number_format($totalAssetValue, 0, ',', '.') }}
                            </h3>
                        </div>
                        <div
                            class="p-4 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg transform group-hover:scale-110 group-hover:rotate-12 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-center text-xs">
                        <span
                            class="flex items-center text-emerald-600 font-bold mr-2 bg-emerald-50 px-2 py-1 rounded-full">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            Updated
                        </span>
                        <span class="text-slate-500">Akumulasi nilai perolehan</span>
                    </div>
                </div>

                <!-- Card 2 - Aset Dipinjam -->
                <div
                    class="group bg-white rounded-2xl p-6 shadow-md border-2 border-transparent hover:border-amber-200 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-2">Aset Dipinjam</p>
                            <h3
                                class="text-3xl font-extrabold text-slate-800 transition-colors group-hover:text-amber-600">
                                {{ $activeLoans }} <span class="text-lg font-normal text-slate-500">Unit</span>
                            </h3>
                        </div>
                        <div
                            class="p-4 bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl shadow-lg transform group-hover:scale-110 group-hover:rotate-12 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-center text-xs">
                        <span class="bg-amber-100 text-amber-700 font-bold px-2 py-1 rounded-full mr-2">Active</span>
                        <span class="text-slate-500">Sedang digunakan user</span>
                    </div>
                </div>

                <!-- Card 3 - Stok Menipis -->
                <div
                    class="group bg-white rounded-2xl p-6 shadow-md border-2 border-transparent hover:border-rose-200 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-2">Stok Menipis</p>
                            <h3
                                class="text-3xl font-extrabold text-slate-800 transition-colors group-hover:text-rose-600">
                                {{ $lowStockCount }} <span class="text-lg font-normal text-slate-500">Batch</span>
                            </h3>
                        </div>
                        <div
                            class="p-4 bg-gradient-to-br from-rose-500 to-pink-600 rounded-2xl shadow-lg transform group-hover:scale-110 group-hover:rotate-12 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-center text-xs">
                        <span
                            class="bg-rose-100 text-rose-700 font-bold px-2 py-1 rounded-full mr-2 animate-pulse">Alert</span>
                        <span class="text-slate-500">Perlu restock segera</span>
                    </div>
                </div>

                <!-- Card 4 - Status Sistem -->
                <div
                    class="group bg-white rounded-2xl p-6 shadow-md border-2 border-transparent hover:border-emerald-200 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-2">Status Sistem</p>
                            <h3
                                class="text-3xl font-extrabold text-emerald-600 transition-colors group-hover:text-emerald-700">
                                ONLINE
                            </h3>
                        </div>
                        <div
                            class="p-4 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl shadow-lg transform group-hover:scale-110 group-hover:rotate-12 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-center text-xs text-slate-500">
                        <span
                            class="w-2.5 h-2.5 rounded-full bg-emerald-500 mr-2 animate-pulse shadow-lg shadow-emerald-500/50"></span>
                        <span>{{ date('d M Y H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Charts Section - Enhanced -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                <!-- Chart 1: Tren Peminjaman -->
                <div
                    class="bg-white p-6 rounded-2xl shadow-lg border border-slate-200 md:col-span-2 hover:shadow-2xl transition-shadow duration-300">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-extrabold text-slate-800 text-xl flex items-center gap-2">
                            <span class="w-1 h-6 bg-indigo-600 rounded-full"></span>
                            Tren Peminjaman
                        </h3>
                        <span
                            class="text-xs font-bold px-3 py-1.5 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 text-white shadow-md">
                            Tahun {{ date('Y') }}
                        </span>
                    </div>
                    <div id="chart-loans" class="w-full"></div>
                </div>

                <!-- Chart 2: Kondisi Fisik Aset -->
                <div
                    class="bg-white p-6 rounded-2xl shadow-lg border border-slate-200 hover:shadow-2xl transition-shadow duration-300">
                    <h3 class="font-extrabold text-slate-800 text-xl mb-6 flex items-center gap-2">
                        <span class="w-1 h-6 bg-emerald-600 rounded-full"></span>
                        Kondisi Fisik Aset
                    </h3>
                    <div id="chart-condition" class="flex justify-center"></div>
                </div>

            </div>

            <!-- Tables Section - Enhanced -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Overdue Loans -->
                <div
                    class="bg-white shadow-lg rounded-2xl border border-slate-200 overflow-hidden hover:shadow-2xl transition-shadow duration-300">
                    <div
                        class="p-6 bg-gradient-to-r from-rose-50 to-pink-50 border-b border-rose-100 flex justify-between items-center">
                        <h3 class="font-extrabold text-lg text-slate-800 flex items-center gap-3">
                            <span class="flex h-3 w-3 relative">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-rose-500"></span>
                            </span>
                            Terlambat Mengembalikan
                        </h3>
                        @if($lateLoans->count() > 0)
                            <span class="bg-rose-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-md">
                                {{ $lateLoans->count() }} Item
                            </span>
                        @endif
                    </div>

                    <div class="p-0">
                        @if($lateLoans->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left text-slate-500">
                                    <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b-2 border-slate-200">
                                        <tr>
                                            <th class="px-6 py-4 font-bold">Peminjam</th>
                                            <th class="px-6 py-4 font-bold">Barang</th>
                                            <th class="px-6 py-4 font-bold">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @foreach($lateLoans as $loan)
                                            <tr class="bg-white hover:bg-rose-50 transition-colors">
                                                <td class="px-6 py-4 font-semibold text-slate-900">
                                                    {{ $loan->borrower_name }}
                                                    <div class="text-xs text-slate-500 mt-1">{{ $loan->phone }}</div>
                                                </td>
                                                <td class="px-6 py-4 text-slate-700">{{ $loan->asset->inventory->name }}</td>
                                                <td class="px-6 py-4">
                                                    <span
                                                        class="bg-rose-100 text-rose-800 text-xs font-bold px-3 py-1.5 rounded-full border-2 border-rose-200">
                                                        {{ \Carbon\Carbon::parse($loan->return_date_plan)->diffForHumans() }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="p-12 text-center">
                                <div
                                    class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-emerald-100 to-teal-100 mb-4 shadow-lg">
                                    <svg class="w-10 h-10 text-emerald-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-slate-900 mb-2">Semua Aman!</h3>
                                <p class="text-slate-500">Tidak ada peminjaman yang terlambat hari ini.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Stock Alerts -->
                <div
                    class="bg-white shadow-lg rounded-2xl border border-slate-200 overflow-hidden hover:shadow-2xl transition-shadow duration-300">
                    <div
                        class="p-6 bg-gradient-to-r from-amber-50 to-orange-50 border-b border-amber-100 flex justify-between items-center">
                        <h3 class="font-extrabold text-lg text-slate-800 flex items-center gap-3">
                            <span class="flex h-3 w-3 relative">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-500"></span>
                            </span>
                            Perhatian Stok
                        </h3>
                    </div>

                    <div class="p-6 space-y-6">
                        <!-- Expiring Items -->
                        <div>
                            <h4
                                class="text-xs font-extrabold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Akan Kadaluarsa (30 Hari)
                            </h4>
                            @if($expiringItems->count() > 0)
                                <div class="space-y-3">
                                    @foreach($expiringItems as $item)
                                        <div
                                            class="group flex items-center justify-between p-4 bg-gradient-to-r from-white to-amber-50 border-2 border-amber-100 rounded-xl hover:border-amber-300 hover:shadow-md transition-all">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="h-10 w-10 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white shadow-md group-hover:scale-110 transition-transform">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <div class="font-bold text-slate-800 text-sm">{{ $item->consumable->name }}
                                                    </div>
                                                    <div class="text-xs text-slate-500 font-medium">Batch:
                                                        {{ $item->batch_code }}</div>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-xs font-extrabold text-rose-600 bg-rose-50 px-2 py-1 rounded">
                                                    {{ $item->expiry_date }}</div>
                                                <div class="text-[10px] text-slate-400 mt-1">Expired Date</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-slate-400 italic py-4 text-center bg-slate-50 rounded-lg">Tidak ada
                                    barang mendekati expired.</p>
                            @endif
                        </div>

                        <!-- Low Stock -->
                        <div>
                            <h4
                                class="text-xs font-extrabold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 12H4" />
                                </svg>
                                Stok Menipis (< 5) </h4>
                                    @if($lowStocks->count() > 0)
                                        <div class="space-y-3">
                                            @foreach($lowStocks as $stock)
                                                <div
                                                    class="group flex items-center justify-between p-4 bg-gradient-to-r from-white to-rose-50 border-2 border-rose-100 rounded-xl hover:border-rose-300 hover:shadow-md transition-all">
                                                    <div class="flex items-center gap-3">
                                                        <div
                                                            class="h-10 w-10 rounded-xl bg-gradient-to-br from-rose-400 to-pink-500 flex items-center justify-center text-white shadow-md group-hover:scale-110 transition-transform">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2.5" d="M20 12H4" />
                                                            </svg>
                                                        </div>
                                                        <span
                                                            class="font-bold text-slate-800 text-sm">{{ $stock->consumable->name }}</span>
                                                    </div>
                                                    <span
                                                        class="px-3 py-1.5 rounded-full text-xs font-extrabold bg-rose-500 text-white shadow-md">
                                                        Sisa: {{ $stock->current_stock }} {{ $stock->consumable->unit }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-sm text-slate-400 italic py-4 text-center bg-slate-50 rounded-lg">
                                            Stok aman.</p>
                                    @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        // --- Grafik 1: Tren Peminjaman (Area Chart) ---
        var optionsLoans = {
            series: [{
                name: 'Jumlah Peminjaman',
                data: @json($chartLoans)
            }],
            chart: {
                height: 320,
                type: 'area',
                fontFamily: 'Figtree, sans-serif',
                toolbar: { show: false },
                zoom: { enabled: false }
            },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: {
                    style: {
                        colors: '#64748b',
                        fontSize: '12px',
                        fontWeight: 600
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: '#64748b',
                        fontSize: '12px',
                        fontWeight: 600
                    }
                }
            },
            colors: ['#6366f1'],
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.5,
                    opacityTo: 0.1,
                    stops: [0, 100]
                }
            },
            grid: {
                borderColor: '#f1f5f9',
                strokeDashArray: 4,
                yaxis: { lines: { show: true } }
            },
            tooltip: {
                theme: 'light',
                y: { formatter: function (val) { return val + " Peminjaman" } }
            }
        };

        if (document.querySelector("#chart-loans")) {
            var chart1 = new ApexCharts(document.querySelector("#chart-loans"), optionsLoans);
            chart1.render();
        }

        // --- Grafik 2: Kondisi Aset (Donut Chart) ---
        var optionsCondition = {
            series: @json($chartCondition),
            chart: {
                type: 'donut',
                height: 350,
                fontFamily: 'Figtree, sans-serif',
            },
            labels: ['Baik', 'Rusak Ringan', 'Rusak Berat'],
            colors: ['#10b981', '#f59e0b', '#f43f5e'],
            legend: {
                position: 'bottom',
                markers: { radius: 12 },
                itemMargin: { horizontal: 10, vertical: 5 },
                fontSize: '13px',
                fontWeight: 600
            },
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold'
                }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total Aset',
                                fontSize: '14px',
                                fontWeight: 700,
                                color: '#64748b',
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                                }
                            },
                            value: {
                                fontSize: '28px',
                                fontWeight: 800,
                                color: '#1e293b',
                            }
                        }
                    }
                }
            },
            stroke: { show: false }
        };

        if (document.querySelector("#chart-condition")) {
            var chart2 = new ApexCharts(document.querySelector("#chart-condition"), optionsCondition);
            chart2.render();
        }
    </script>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.6s ease-out;
        }
    </style>
</x-app-layout>