<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Executive Summary (Dashboard)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-500 text-xs font-bold uppercase mb-1">Total Nilai Aset</div>
                    <div class="text-2xl font-bold text-gray-800">
                        Rp {{ number_format($totalAssetValue, 0, ',', '.') }}
                    </div>
                    <div class="text-xs text-gray-400 mt-1">Akumulasi harga pembelian</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                    <div class="text-gray-500 text-xs font-bold uppercase mb-1">Aset Dipinjam</div>
                    <div class="text-2xl font-bold text-yellow-600">
                        {{ $activeLoans }} Unit
                    </div>
                    <div class="text-xs text-gray-400 mt-1">Sedang berada di luar</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-orange-500">
                    <div class="text-gray-500 text-xs font-bold uppercase mb-1">Stok BHP Kritis</div>
                    <div class="text-2xl font-bold text-orange-600">
                        {{ $lowStockCount }} Batch
                    </div>
                    <div class="text-xs text-gray-400 mt-1">Sisa stok kurang dari 5</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-gray-500 text-xs font-bold uppercase mb-1">Status Sistem</div>
                    <div class="text-lg font-bold text-green-600">
                        ONLINE
                    </div>
                    <div class="text-xs text-gray-400 mt-1">{{ date('d M Y H:i') }}</div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                
                <div class="bg-white p-6 rounded-lg shadow-sm md:col-span-2">
                    <h3 class="font-bold text-gray-700 mb-4">Tren Peminjaman Tahun {{ date('Y') }}</h3>
                    <div id="chart-loans"></div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="font-bold text-gray-700 mb-4">Kondisi Fisik Aset</h3>
                     <div id="chart-condition"></div>
                </div>

            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-bold text-lg text-red-600 mb-4 flex items-center">
                        ⚠️ Terlambat Mengembalikan (Overdue)
                    </h3>
                    
                    @if($lateLoans->count() > 0)
                        <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-red-50">
                                    <tr>
                                        <th class="px-4 py-2">Peminjam</th>
                                        <th class="px-4 py-2">Barang</th>
                                        <th class="px-4 py-2">Telat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lateLoans as $loan)
                                    <tr class="bg-white border-b hover:bg-red-50">
                                        <td class="px-4 py-2 font-medium text-gray-900">
                                            {{ $loan->borrower_name }}
                                            <div class="text-xs text-gray-500">{{ $loan->phone }}</div>
                                        </td>
                                        <td class="px-4 py-2">{{ $loan->asset->inventory->name }}</td>
                                        <td class="px-4 py-2 text-red-600 font-bold">
                                            {{ \Carbon\Carbon::parse($loan->return_date_plan)->diffForHumans() }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-4 bg-green-50 text-green-700 rounded border border-green-200 text-center">
                            Aman. Tidak ada peminjaman yang terlambat hari ini.
                        </div>
                    @endif
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-bold text-lg text-orange-600 mb-4 flex items-center">
                        📦 Perhatian Stok & Kadaluarsa
                    </h3>

                    <h4 class="text-xs font-bold text-gray-500 uppercase mb-2">Akan Kadaluarsa (30 Hari)</h4>
                    @if($expiringItems->count() > 0)
                        <table class="w-full text-sm text-left text-gray-500 mb-6">
                            <thead class="text-xs text-gray-700 uppercase bg-orange-50">
                                <tr>
                                    <th class="px-4 py-2">Barang</th>
                                    <th class="px-4 py-2">Batch</th>
                                    <th class="px-4 py-2">Exp</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($expiringItems as $item)
                                <tr class="bg-white border-b">
                                    <td class="px-4 py-2 font-medium">{{ $item->consumable->name }}</td>
                                    <td class="px-4 py-2 text-xs">{{ $item->batch_code }}</td>
                                    <td class="px-4 py-2 text-red-600 font-bold">
                                        {{ $item->expiry_date }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-xs text-gray-400 italic mb-6">Tidak ada obat/barang yang mendekati expired.</p>
                    @endif

                    <h4 class="text-xs font-bold text-gray-500 uppercase mb-2">Stok Menipis (< 5)</h4>
                     @if($lowStocks->count() > 0)
                        <ul class="space-y-2">
                            @foreach($lowStocks as $stock)
                            <li class="flex justify-between items-center p-2 bg-gray-50 rounded border border-gray-100">
                                <span class="text-gray-700 font-medium">{{ $stock->consumable->name }}</span>
                                <span class="text-xs font-bold bg-red-100 text-red-800 px-2 py-1 rounded">
                                    Sisa: {{ $stock->current_stock }} {{ $stock->consumable->unit }}
                                </span>
                            </li>
                            @endforeach
                        </ul>
                    @else
                         <p class="text-xs text-gray-400 italic">Stok aman.</p>
                    @endif
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
                height: 300,
                type: 'area',
                toolbar: { show: false }
            },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth' },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
            },
            colors: ['#3b82f6'],
            fill: {
                type: "gradient",
                gradient: { shadeIntensity: 1, opacityFrom: 0.7, opacityTo: 0.9, stops: [0, 90, 100] }
            },
            grid: {
                borderColor: '#f1f1f1'
            }
        };
        
        // Render Grafik 1 jika elemennya ada
        if(document.querySelector("#chart-loans")) {
            var chart1 = new ApexCharts(document.querySelector("#chart-loans"), optionsLoans);
            chart1.render();
        }

        // --- Grafik 2: Kondisi Aset (Donut Chart) ---
        var optionsCondition = {
            series: @json($chartCondition), // Data [Baik, Ringan, Berat]
            chart: {
                type: 'donut',
                height: 320
            },
            labels: ['Baik', 'Rusak Ringan', 'Rusak Berat'],
            colors: ['#22c55e', '#eab308', '#ef4444'], 
            legend: { position: 'bottom' },
            dataLabels: { enabled: true },
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%'
                    }
                }
            }
        };

        // Render Grafik 2 jika elemennya ada
        if(document.querySelector("#chart-condition")) {
            var chart2 = new ApexCharts(document.querySelector("#chart-condition"), optionsCondition);
            chart2.render();
        }
    </script>
    </x-app-layout>