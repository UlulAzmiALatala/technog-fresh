<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Financial Reports') }}
            </h2>
            <a href="{{ route('admin.founder.reports.export', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                Export CSV
            </a>
        </div>
    </x-slot>

    <div class="mt-4">
        {{-- Date Filter Form --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 text-gray-900">
                <h3 class="text-lg font-semibold mb-2">Filter Reports</h3>
                <form action="{{ route('admin.founder.reports.index') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <div>
                            <label for="start_date" class="block font-medium text-sm text-gray-700">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $startDate }}">
                        </div>
                        <div>
                            <label for="end_date" class="block font-medium text-sm text-gray-700">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $endDate }}">
                        </div>
                        <div>
                            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Grid for financial summary --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
            <div class="bg-white border-l-4 border-green-500 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="text-sm font-medium text-gray-500 truncate">Total Revenue</p>
                <p class="mt-1 text-3xl font-semibold text-gray-900">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white border-l-4 border-red-500 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="text-sm font-medium text-gray-500 truncate">Total Expenses</p>
                <p class="mt-1 text-3xl font-semibold text-gray-900">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mt-6">
            <div class="bg-white border-l-4 border-indigo-500 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="text-sm font-medium text-gray-500 truncate">Net Profit</p>
                <p class="mt-1 text-3xl font-semibold text-gray-900">Rp {{ number_format($labaBersih, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white border-l-4 border-purple-500 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="text-sm font-medium text-gray-500 truncate">Total Management Fee</p>
                <p class="mt-1 text-3xl font-semibold text-gray-900">Rp {{ number_format($totalManagementFee, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- Net Profit Distribution Section --}}
        <div class="mt-8">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Net Profit Distribution Details</h3>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Distribution Chart --}}
                <div class="lg:col-span-1 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold text-gray-700 mb-4">Distribution Visualization</h4>
                        @if($labaBersih > 0)
                            <canvas id="distributionChart"></canvas>
                        @else
                            <p class="text-center text-gray-500 pt-10">Distribution data will appear if there is a net profit.</p>
                        @endif
                    </div>
                </div>
                {{-- Distribution Details --}}
                <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="font-semibold text-gray-900 border-b pb-3">Fixed Profit Sharing</h4>
                            <ul class="mt-4 space-y-3">
                                <li class="flex justify-between items-center text-sm"><span class="text-gray-600">Founder (15%)</span><span class="font-medium">Rp {{ number_format($hasilDistribusi['Founder'], 0, ',', '.') }}</span></li>
                                <li class="flex justify-between items-center text-sm"><span class="text-gray-600">Co-Founder (5%)</span><span class="font-medium">Rp {{ number_format($hasilDistribusi['Co Founder'], 0, ',', '.') }}</span></li>
                                <li class="flex justify-between items-center text-sm"><span class="text-gray-600">Charitable Contribution (7.5%)</span><span class="font-medium">Rp {{ number_format($hasilDistribusi['Allah'], 0, ',', '.') }}</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="font-semibold text-gray-900 border-b pb-3">Operational Fund Allocation</h4>
                            <ul class="mt-4 space-y-3">
                                <li class="flex justify-between items-center text-sm"><span class="text-gray-600">Founder's Return (2.5%)</span><span class="font-medium">Rp {{ number_format($hasilDistribusi['Return Founder'], 0, ',', '.') }}</span></li>
                                <li class="flex justify-between items-center text-sm"><span class="text-gray-600">Co-Founder's Return (7.5%)</span><span class="font-medium">Rp {{ number_format($hasilDistribusi['Return Co Founder'], 0, ',', '.') }}</span></li>
                                <li class="flex justify-between items-center text-sm"><span class="text-gray-600">Admin (15%)</span><span class="font-medium">Rp {{ number_format($hasilDistribusi['Admin'], 0, ',', '.') }}</span></li>
                                <li class="flex justify-between items-center text-sm"><span class="text-gray-600">Development (7.5%)</span><span class="font-medium">Rp {{ number_format($hasilDistribusi['Pengembangan'], 0, ',', '.') }}</span></li>
                                <li class="flex justify-between items-center text-sm"><span class="text-gray-600">Project Executor (40%)</span><span class="font-medium">Rp {{ number_format($hasilDistribusi['Pelaksana Project'], 0, ',', '.') }}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Charts Area --}}
        <div class="mt-8 grid grid-cols-1 lg:grid-cols-5 gap-8">
            <div class="lg:col-span-3 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Financial Trends</h3>
                    <canvas id="financialTrendChart"></canvas>
                </div>
            </div>
            <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Expense Composition</h3>
                    @if($totalPengeluaran > 0)
                        <canvas id="expenseChart"></canvas>
                    @else
                        <p class="text-center text-gray-500 pt-10">No expense data to display.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Details Tables --}}
        <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Revenue Table --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Revenue Details</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($pendapatanDetails as $order)
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">#{{ $order->id }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">{{ $order->user->name }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 text-right">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-2 text-center text-sm text-gray-500">No revenue.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            {{-- Expenses Table --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Expense Details</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($pengeluaranDetails as $expense)
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $expense->description }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 text-right">Rp {{ number_format($expense->amount, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-2 text-center text-sm text-gray-500">No expenses.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Financial Trend Chart (Line)
            const trendCtx = document.getElementById('financialTrendChart');
            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: @json($dates),
                    datasets: [
                        { label: 'Revenue', data: @json($chartPendapatan), borderColor: 'rgb(34, 197, 94)', backgroundColor: 'rgba(34, 197, 94, 0.1)', fill: true, tension: 0.3 },
                        { label: 'Expenses', data: @json($chartPengeluaran), borderColor: 'rgb(239, 68, 68)', backgroundColor: 'rgba(239, 68, 68, 0.1)', fill: true, tension: 0.3 },
                        { label: 'Net Profit', data: @json($chartLabaBersih), borderColor: 'rgb(59, 130, 246)', backgroundColor: 'rgba(59, 130, 246, 0.1)', fill: true, tension: 0.3 }
                    ]
                },
                options: { responsive: true, scales: { y: { beginAtZero: true, ticks: { callback: (value) => 'Rp ' + new Intl.NumberFormat('id-ID').format(value) } } } }
            });

            // Expense Composition Chart (Pie)
            @if($totalPengeluaran > 0)
                const expenseCtx = document.getElementById('expenseChart');
                new Chart(expenseCtx, {
                    type: 'pie',
                    data: {
                        labels: @json($expenseByCategory->keys()),
                        datasets: [{
                            data: @json($expenseByCategory->values()),
                            backgroundColor: ['rgba(59, 130, 246, 0.7)', 'rgba(239, 68, 68, 0.7)', 'rgba(245, 158, 11, 0.7)', 'rgba(34, 197, 94, 0.7)', 'rgba(139, 92, 246, 0.7)'],
                            borderColor: '#fff',
                            borderWidth: 2
                        }]
                    },
                    options: { responsive: true, plugins: { legend: { position: 'top' } } }
                });
            @endif

            // Profit Distribution Chart (Doughnut)
            @if($labaBersih > 0)
                const distCtx = document.getElementById('distributionChart');
                new Chart(distCtx, {
                    type: 'doughnut',
                    data: {
                        labels: @json(array_keys($hasilDistribusi)),
                        datasets: [{
                            data: @json(array_values($hasilDistribusi)),
                            backgroundColor: ['#4f46e5', '#6366f1', '#818cf8', '#a5b4fc', '#c7d2fe', '#10b981', '#34d399', '#6ee7b7'],
                            borderColor: '#fff',
                            borderWidth: 2
                        }]
                    },
                    options: { responsive: true, plugins: { legend: { display: false } } }
                });
            @endif
        });
    </script>
</x-admin-layout>
