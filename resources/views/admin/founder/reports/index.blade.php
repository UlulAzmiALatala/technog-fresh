<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard & Reports') }}
            </h2>
            <form action="{{ route('admin.founder.reports.index') }}" method="GET" class="flex items-center gap-x-2">
                <input type="date" name="start_date" class="block w-full h-9 text-sm rounded-md border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 shadow-sm" value="{{ $startDate }}">
                <span class="text-gray-500">-</span>
                <input type="date" name="end_date" class="block w-full h-9 text-sm rounded-md border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 shadow-sm" value="{{ $endDate }}">
                <button type="submit" class="h-9 inline-flex items-center px-3 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700"><i class="fas fa-filter"></i></button>
                <a href="{{ route('admin.founder.reports.export', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="h-9 inline-flex items-center px-3 py-2 bg-slate-800 dark:bg-slate-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-slate-800 uppercase tracking-widest hover:bg-slate-700 dark:hover:bg-white"><i class="fas fa-file-csv"></i></a>
            </form>
        </div>
    </x-slot>

    <div x-data="{ animate: false }" x-init="setTimeout(() => animate = true, 100)" class="space-y-8">
        
        {{-- [PERUBAHAN TOTAL] Tata Letak Kartu Statistik dengan Perbandingan --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Kartu Utama: Laba Bersih --}}
            <div class="fade-in-item lg:col-span-1 bg-gradient-to-br from-indigo-500 to-blue-600 text-white p-6 rounded-2xl shadow-lg flex flex-col justify-between" :class="animate ? 'in-view' : ''">
                <div>
                    <p class="text-lg font-medium text-indigo-200">Net Profit</p>
                    <p class="mt-2 text-5xl font-bold">${{ number_format($labaBersih, 0, ',', '.') }}</p>
                </div>
                <div class="mt-4 text-sm font-semibold flex items-center {{ $labaBersihChange >= 0 ? 'text-green-300' : 'text-red-300' }}">
                    <i class="fas {{ $labaBersihChange >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} mr-1.5"></i>
                    {{ number_format(abs($labaBersihChange), 1) }}% vs previous period
                </div>
            </div>

            {{-- Kartu Pendukung & Sekunder --}}
            <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="fade-in-item bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700" :class="animate ? 'in-view' : ''" style="transition-delay: 0.1s;">
                    <p class="text-sm font-medium text-gray-500 dark:text-slate-400">Total Revenue</p>
                    <p class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">${{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                    <p class="mt-2 text-xs font-semibold flex items-center {{ $pendapatanChange >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        <i class="fas {{ $pendapatanChange >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} mr-1"></i>
                        {{ number_format(abs($pendapatanChange), 1) }}%
                    </p>
                </div>
                <div class="fade-in-item bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700" :class="animate ? 'in-view' : ''" style="transition-delay: 0.2s;">
                    <p class="text-sm font-medium text-gray-500 dark:text-slate-400">Total Expenses</p>
                    <p class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">${{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
                     <p class="mt-2 text-xs font-semibold flex items-center {{ $pengeluaranChange <= 0 ? 'text-green-600' : 'text-red-600' }}">
                        <i class="fas {{ $pengeluaranChange <= 0 ? 'fa-arrow-down' : 'fa-arrow-up' }} mr-1"></i>
                        {{ number_format(abs($pengeluaranChange), 1) }}%
                    </p>
                </div>
                 <div class="fade-in-item bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700" :class="animate ? 'in-view' : ''" style="transition-delay: 0.3s;">
                    <p class="text-sm font-medium text-gray-500 dark:text-slate-400">Total Orders</p>
                    <p class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">{{ $totalOrders }}</p>
                     <p class="mt-2 text-xs font-semibold flex items-center {{ $ordersChange >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        <i class="fas {{ $ordersChange >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} mr-1"></i>
                        {{ number_format(abs($ordersChange), 1) }}%
                    </p>
                </div>
                <div class="fade-in-item bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700" :class="animate ? 'in-view' : ''" style="transition-delay: 0.4s;">
                    <p class="text-sm font-medium text-gray-500 dark:text-slate-400">Management Fee</p>
                    <p class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">${{ number_format($totalManagementFee, 0, ',', '.') }}</p>
                    <p class="mt-2 text-xs text-gray-400">&nbsp;</p> {{-- Placeholder agar sejajar --}}
                </div>
            </div>
        </div>
        
        {{-- Charts Area --}}
        <div class="mt-8 grid grid-cols-1 lg:grid-cols-5 gap-8">
            <div class="fade-in-item lg:col-span-3 bg-white dark:bg-slate-800 overflow-hidden shadow-lg sm:rounded-2xl border border-slate-200 dark:border-slate-700 transition-all duration-300" :class="animate ? 'in-view' : ''" style="transition-delay: 0.5s;">
                <div class="p-6 text-gray-900 dark:text-slate-200">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-slate-300 mb-4">Financial Trends</h3>
                    <canvas id="financialTrendChart"></canvas>
                </div>
            </div>
            <div class="fade-in-item lg:col-span-2 bg-white dark:bg-slate-800 overflow-hidden shadow-lg sm:rounded-2xl border border-slate-200 dark:border-slate-700 transition-all duration-300" :class="animate ? 'in-view' : ''" style="transition-delay: 0.6s;">
                <div class="p-6 text-gray-900 dark:text-slate-200">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-slate-300 mb-4">Expense Composition</h3>
                    @if($totalPengeluaran > 0)
                        <canvas id="expenseChart"></canvas>
                    @else
                        <p class="text-center text-gray-500 dark:text-slate-400 pt-10">No expense data to display.</p>
                    @endif
                </div>
            </div>
        </div>
        
        {{-- Net Profit Distribution Section --}}
        <div class="fade-in-item mt-8 bg-white dark:bg-slate-800 overflow-hidden shadow-lg sm:rounded-2xl border border-slate-200 dark:border-slate-700 transition-all duration-300" :class="animate ? 'in-view' : ''" style="transition-delay: 0.7s;">
            <div class="p-6 border-b border-gray-200 dark:border-slate-700">
                <h3 class="text-xl font-bold text-gray-800 dark:text-slate-200">Net Profit Distribution Details</h3>
            </div>
            <div class="p-6 grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Distribution Chart --}}
                <div class="lg:col-span-1">
                    @if($labaBersih > 0)
                        <canvas id="distributionChart"></canvas>
                    @else
                        <p class="text-center text-gray-500 dark:text-slate-400 pt-10">Distribution data will appear if there is a net profit.</p>
                    @endif
                </div>
                {{-- Distribution Details --}}
                <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-slate-50 dark:bg-slate-700/50 p-6 rounded-lg">
                        <h4 class="font-semibold text-gray-900 dark:text-white border-b dark:border-slate-600 pb-3">Fixed Profit Sharing</h4>
                        <ul class="mt-4 space-y-3 text-sm">
                            <li class="flex justify-between items-center"><span class="text-gray-600 dark:text-slate-400">Founder (15%)</span><span class="font-medium text-gray-900 dark:text-white">${{ number_format($hasilDistribusi['Founder'], 0, ',', '.') }}</span></li>
                            <li class="flex justify-between items-center text-sm"><span class="text-gray-600 dark:text-slate-400">Co-Founder (5%)</span><span class="font-medium text-gray-900 dark:text-white">${{ number_format($hasilDistribusi['Co Founder'], 0, ',', '.') }}</span></li>
                            <li class="flex justify-between items-center text-sm"><span class="text-gray-600 dark:text-slate-400">Charitable (7.5%)</span><span class="font-medium text-gray-900 dark:text-white">${{ number_format($hasilDistribusi['Allah'], 0, ',', '.') }}</span></li>
                        </ul>
                    </div>
                    <div class="bg-slate-50 dark:bg-slate-700/50 p-6 rounded-lg">
                        <h4 class="font-semibold text-gray-900 dark:text-white border-b dark:border-slate-600 pb-3">Operational Fund</h4>
                        <ul class="mt-4 space-y-3 text-sm">
                            <li class="flex justify-between items-center"><span class="text-gray-600 dark:text-slate-400">Founder's Return (2.5%)</span><span class="font-medium text-gray-900 dark:text-white">${{ number_format($hasilDistribusi['Return Founder'], 0, ',', '.') }}</span></li>
                            <li class="flex justify-between items-center"><span class="text-gray-600 dark:text-slate-400">Co-Founder's Return (7.5%)</span><span class="font-medium text-gray-900 dark:text-white">${{ number_format($hasilDistribusi['Return Co Founder'], 0, ',', '.') }}</span></li>
                            <li class="flex justify-between items-center"><span class="text-gray-600 dark:text-slate-400">Admin (15%)</span><span class="font-medium text-gray-900 dark:text-white">${{ number_format($hasilDistribusi['Admin'], 0, ',', '.') }}</span></li>
                            <li class="flex justify-between items-center"><span class="text-gray-600 dark:text-slate-400">Development (7.5%)</span><span class="font-medium text-gray-900 dark:text-white">${{ number_format($hasilDistribusi['Pengembangan'], 0, ',', '.') }}</span></li>
                            <li class="flex justify-between items-center"><span class="text-gray-600 dark:text-slate-400">Project Executor (40%)</span><span class="font-medium text-gray-900 dark:text-white">${{ number_format($hasilDistribusi['Pelaksana Project'], 0, ',', '.') }}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Details Tables --}}
        <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Revenue Table --}}
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-lg sm:rounded-2xl border border-slate-200 dark:border-slate-700">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-200 mb-4">Revenue Details</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                            <thead class="bg-gray-50 dark:bg-slate-700/50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Order ID</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Client</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                                @forelse ($pendapatanDetails as $order)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50">
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-slate-200">#{{ $order->id }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400">{{ $order->user->name }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-slate-200 text-right">${{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-2 text-center text-sm text-gray-500 dark:text-slate-400">No revenue data for this period.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- Expenses Table --}}
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-lg sm:rounded-2xl border border-slate-200 dark:border-slate-700">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-200 mb-4">Expense Details</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                            <thead class="bg-gray-50 dark:bg-slate-700/50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Date</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Description</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                                @forelse ($pengeluaranDetails as $expense)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50">
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400">{{ \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-slate-200">{{ $expense->description }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-slate-200 text-right">${{ number_format($expense->amount, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-2 text-center text-sm text-gray-500 dark:text-slate-400">No expense data for this period.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- [WAJIB] Ganti script lama dengan ini untuk support Dark Mode --}}
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const darkMode = document.documentElement.classList.contains('dark');
            const gridColor = darkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
            const textColor = darkMode ? '#cbd5e1' : '#4b5563'; // slate-300 | gray-600

            // Financial Trend Chart (Line)
            const trendCtx = document.getElementById('financialTrendChart');
            if (trendCtx) {
                new Chart(trendCtx, {
                    type: 'line',
                    data: {
                        labels: @json($dates),
                        datasets: [
                            { label: 'Revenue', data: @json($chartPendapatan), borderColor: 'rgb(34, 197, 94)', backgroundColor: 'rgba(34, 197, 94, 0.2)', fill: true, tension: 0.3 },
                            { label: 'Expenses', data: @json($chartPengeluaran), borderColor: 'rgb(239, 68, 68)', backgroundColor: 'rgba(239, 68, 68, 0.2)', fill: true, tension: 0.3 },
                            { label: 'Net Profit', data: @json($chartLabaBersih), borderColor: 'rgb(59, 130, 246)', backgroundColor: 'rgba(59, 130, 246, 0.2)', fill: true, tension: 0.3 }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: { 
                                beginAtZero: true, 
                                ticks: { 
                                    color: textColor, 
                                    // [PERUBAHAN] Mengubah format mata uang ke Dolar
                                    callback: (value) => '$ ' + new Intl.NumberFormat('en-US').format(value) 
                                }, 
                                grid: { color: gridColor } 
                            },
                            x: { 
                                ticks: { color: textColor }, 
                                grid: { color: gridColor } 
                            }
                        },
                        plugins: { 
                            legend: { 
                                labels: { 
                                    color: textColor 
                                } 
                            } 
                        }
                    }
                });
            }

            // Expense Composition Chart (Pie)
            @if($totalPengeluaran > 0)
                const expenseCtx = document.getElementById('expenseChart');
                if(expenseCtx) {
                    new Chart(expenseCtx, {
                        type: 'pie',
                        data: {
                            labels: @json($expenseByCategory->keys()),
                            datasets: [{
                                data: @json($expenseByCategory->values()),
                                backgroundColor: ['#3b82f6', '#ef4444', '#f97316', '#22c55e', '#8b5cf6', '#14b8a6'],
                                borderColor: darkMode ? '#1e293b' : '#fff',
                                borderWidth: 2
                            }]
                        },
                        options: { 
                            responsive: true, 
                            plugins: { 
                                legend: { 
                                    position: 'top', 
                                    labels: { color: textColor } 
                                } 
                            } 
                        }
                    });
                }
            @endif

            // Profit Distribution Chart (Doughnut)
            @if($labaBersih > 0)
                const distCtx = document.getElementById('distributionChart');
                if(distCtx) {
                    // [PERUBAHAN] Menerjemahkan label distribusi
                    const distributionLabels = @json(array_keys($hasilDistribusi)).map(label => {
                        switch(label) {
                            case 'Return Founder': return "Founder's Return";
                            case 'Return Co Founder': return "Co-Founder's Return";
                            case 'Pengembangan': return 'Development';
                            case 'Pelaksana Project': return 'Project Executor';
                            case 'Allah': return 'Charitable'; // atau 'Charitable Contribution'
                            default: return label;
                        }
                    });

                    new Chart(distCtx, {
                        type: 'doughnut',
                        data: {
                            labels: distributionLabels,
                            datasets: [{
                                data: @json(array_values($hasilDistribusi)),
                                backgroundColor: ['#4f46e5', '#6366f1', '#818cf8', '#a5b4fc', '#c7d2fe', '#10b981', '#34d399', '#6ee7b7'],
                                borderColor: darkMode ? '#1e293b' : '#fff',
                                borderWidth: 4
                            }]
                        },
                        options: { 
                            responsive: true, 
                            cutout: '70%', 
                            plugins: { 
                                legend: { display: false } 
                            } 
                        }
                    });
                }
            @endif
        });
    </script>
    @endpush

    {{-- CSS untuk animasi fade-in --}}
    <style>
        .fade-in-item { opacity: 0; transform: translateY(20px); transition: opacity 0.6s ease-out, transform 0.6s ease-out; }
        .fade-in-item.in-view { opacity: 1; transform: translateY(0); }
    </style>
</x-admin-layout>