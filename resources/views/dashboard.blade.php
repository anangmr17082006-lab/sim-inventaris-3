<x-app-layout>
    <x-slot name="header">
        {{ __('Dashboard Overview') }}
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Welcome Section -->
            <div
                class="mb-8 bg-gradient-to-r from-indigo-600 to-violet-600 rounded-2xl p-8 text-white shadow-lg relative overflow-hidden">
                <div class="relative z-10">
                    <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
                    <p class="text-indigo-100 text-lg opacity-90">Berikut adalah ringkasan aktivitas dan status
                        inventaris hari ini.</p>
                </div>
                <div class="absolute right-0 top-0 h-full w-1/2 bg-white/10 transform skew-x-12 translate-x-20"></div>
                <div class="absolute right-0 bottom-0 h-32 w-32 bg-white/10 rounded-full blur-2xl -mr-10 -mb-10"></div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                <!-- Card 1 -->
                <div
                    class="bg-white rounded-xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-slate-500 text-sm font-medium uppercase tracking-wider">Total Aset</p>
                            <h3 class="text-2xl font-bold text-slate-800 mt-1">Rp
                                {{ number_format($totalAssetValue, 0, ',', '.') }}</h3>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-lg text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-center text-xs text-slate-400">
                        <span class="flex items-center text-emerald-500 font-medium mr-2">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            Updated
                        </span>
                        <span>Akumulasi nilai perolehan</span>
                    </div>
                </div>

                <!-- Card 2 -->
                <div
                    class="bg-white rounded-xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-slate-500 text-sm font-medium uppercase tracking-wider">Aset Dipinjam</p>
                            <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $activeLoans }} <span
                                    class="text-sm font-normal text-slate-500">Unit</span></h3>
                        </div>
                        <div class="p-3 bg-amber-50 rounded-lg text-amber-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-center text-xs text-slate-400">
                        <span class="text-amber-500 font-medium mr-2">Active</span>
                        <span>Sedang digunakan user</span>
                    </div>
                </div>

                <!-- Card 3 -->
                <div
                    class="bg-white rounded-xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-slate-500 text-sm font-medium uppercase tracking-wider">Stok Menipis</p>
                            <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $lowStockCount }} <span
                                    class="text-sm font-normal text-slate-500">Batch</span></h3>
                        </div>
                        <div class="p-3 bg-rose-50 rounded-lg text-rose-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-center text-xs text-slate-400">
                        <span class="text-rose-500 font-medium mr-2">Alert</span>
                        <span>Perlu restock segera</span>
                    </div>
                </div>

                <!-- Card 4 -->
                <div
                    class="bg-white rounded-xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-slate-500 text-sm font-medium uppercase tracking-wider">Status Sistem</p>
                            <h3 class="text-2xl font-bold text-emerald-600 mt-1">ONLINE</h3>
                        </div>
                        <div class="p-3 bg-emerald-50 rounded-lg text-emerald-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-center text-xs text-slate-400">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
                        <span>{{ date('d M Y H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 md:col-span-2">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-slate-700 text-lg">Tren Peminjaman</h3>
                        <span class="text-xs font-medium px-2.5 py-0.5 rounded bg-indigo-100 text-indigo-800">Tahun
                            {{ date('Y') }}</span>
                    </div>
                    <div id="chart-loans" class="w-full"></div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100">
                    <h3 class="font-bold text-slate-700 text-lg mb-6">Kondisi Fisik Aset</h3>
                    <div id="chart-condition" class="flex justify-center"></div>
                </div>

            </div>

            <!-- Tables Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Overdue Loans -->
                <div class="bg-white shadow-sm rounded-xl border border-slate-100 overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                        <h3 class="font-bold text-lg text-slate-800 flex items-center gap-2">
                            <span class="flex h-2 w-2 rounded-full bg-rose-500"></span>
                            Terlambat Mengembalikan
                        </h3>
                        @if($lateLoans->count() > 0)
                            <span
                                class="bg-rose-100 text-rose-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $lateLoans->count() }}
                                Item</span>
                        @endif
                    </div>

                    <div class="p-0">
                        @if($lateLoans->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left text-slate-500">
                                    <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                                        <tr>
                                            <th class="px-6 py-3">Peminjam</th>
                                            <th class="px-6 py-3">Barang</th>
                                            <th class="px-6 py-3">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @foreach($lateLoans as $loan)
                                            <tr class="bg-white hover:bg-slate-50 transition-colors">
                                                <td class="px-6 py-4 font-medium text-slate-900">
                                                    {{ $loan->borrower_name }}
                                                    <div class="text-xs text-slate-400 mt-0.5">{{ $loan->phone }}</div>
                                                </td>
                                                <td class="px-6 py-4">{{ $loan->asset->inventory->name }}</td>
                                                <td class="px-6 py-4">
                                                    <span
                                                        class="bg-rose-100 text-rose-800 text-xs font-medium px-2.5 py-0.5 rounded border border-rose-200">
                                                        {{ \Carbon\Carbon::parse($loan->return_date_plan)->diffForHumans() }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="p-8 text-center">
                                <div
                                    class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-emerald-100 mb-4">
                                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-slate-900">Semua Aman!</h3>
                                <p class="text-slate-500 mt-1">Tidak ada peminjaman yang terlambat hari ini.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Stock Alerts -->
                <div class="bg-white shadow-sm rounded-xl border border-slate-100 overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                        <h3 class="font-bold text-lg text-slate-800 flex items-center gap-2">
                            <span class="flex h-2 w-2 rounded-full bg-amber-500"></span>
                            Perhatian Stok
                        </h3>
                    </div>

                    <div class="p-6 space-y-6">
                        <!-- Expiring -->
                        <div>
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Akan Kadaluarsa
                                (30 Hari)</h4>
                            @if($expiringItems->count() > 0)
                                <div class="space-y-3">
                                    @foreach($expiringItems as $item)
                                        <div
                                            class="flex items-center justify-between p-3 bg-white border border-slate-200 rounded-lg hover:border-amber-300 transition-colors">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="h-8 w-8 rounded bg-amber-100 flex items-center justify-center text-amber-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <div class="font-medium text-slate-700 text-sm">
                                                        {{ $item->consumable->name }}</div>
                                                    <div class="text-xs text-slate-400">Batch: {{ $item->batch_code }}</div>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-xs font-bold text-rose-500">{{ $item->expiry_date }}</div>
                                                <div class="text-[10px] text-slate-400">Expired</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-slate-400 italic">Tidak ada barang mendekati expired.</p>
                            @endif
                        </div>

                        <!-- Low Stock -->
                        <div>
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Stok Menipis (<
                                    5)</h4>
                                    @if($lowStocks->count() > 0)
                                        <div class="space-y-3">
                                            @foreach($lowStocks as $stock)
                                                <div
                                                    class="flex items-center justify-between p-3 bg-white border border-slate-200 rounded-lg hover:border-rose-300 transition-colors">
                                                    <div class="flex items-center gap-3">
                                                        <div
                                                            class="h-8 w-8 rounded bg-rose-100 flex items-center justify-center text-rose-600">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M20 12H4" />
                                                            </svg>
                                                        </div>
                                                        <span
                                                            class="font-medium text-slate-700 text-sm">{{ $stock->consumable->name }}</span>
                                                    </div>
                                                    <span
                                                        class="px-2.5 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700">
                                                        Sisa: {{ $stock->current_stock }} {{ $stock->consumable->unit }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-sm text-slate-400 italic">Stok aman.</p>
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
                data: @json($chartLoans) // Data dari Controller
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
                labels: { style: { colors: '#64748b', fontSize: '12px' } }
            },
            yaxis: {
                labels: { style: { colors: '#64748b', fontSize: '12px' } }
            },
            colors: ['#6366f1'], // Indigo-500
            fill: {
                type: "gradient",
                gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 100] }
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
            series: @json($chartCondition), // Data [Baik, Ringan, Berat]
            chart: {
                type: 'donut',
                height: 350,
                fontFamily: 'Figtree, sans-serif',
            },
            labels: ['Baik', 'Rusak Ringan', 'Rusak Berat'],
            colors: ['#10b981', '#f59e0b', '#f43f5e'], // Emerald, Amber, Rose
            legend: {
                position: 'bottom',
                markers: { radius: 12 },
                itemMargin: { horizontal: 10, vertical: 5 }
            },
            dataLabels: { enabled: false },
            plotOptions: {
                pie: {
                    donut: {
                        size: '75%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total Aset',
                                fontSize: '14px',
                                fontWeight: 600,
                                color: '#64748b',
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                                }
                            },
                            value: {
                                fontSize: '24px',
                                fontWeight: 700,
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
</x-app-layout>