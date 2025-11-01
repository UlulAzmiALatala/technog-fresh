<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Management Fee & Profit Distribution') }}
        </h2>
    </x-slot>

    <div class="mt-4">
        {{-- Date Filter Form --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 text-gray-900">
                <form action="{{ route('admin.founder.management-fee.index') }}" method="GET" id="filterForm">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
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
                                Apply Filter
                            </button>
                        </div>
                        <div>
                            <a href="{{ route('admin.founder.management-fee.export', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Export CSV
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Distribution Content --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left Column: Net Profit & Details --}}
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-500">Net Profit (Selected Period)</p>
                        <p class="mt-1 text-4xl font-bold text-indigo-600">$ {{ number_format($labaBersih, 0, ',', '.') }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="font-semibold text-gray-900 border-b pb-3">Fixed Profit Sharing</h4>
                            <ul class="mt-4 space-y-3">
                                <li class="flex justify-between items-center text-sm"><span class="text-gray-600">Founder (15%)</span><span class="font-medium">$ {{ number_format($hasilDistribusi['Founder'], 0, ',', '.') }}</span></li>
                                <li class="flex justify-between items-center text-sm"><span class="text-gray-600">Co-Founder (5%)</span><span class="font-medium">$ {{ number_format($hasilDistribusi['Co Founder'], 0, ',', '.') }}</span></li>
                                <li class="flex justify-between items-center text-sm"><span class="text-gray-600">Charitable Contribution (7.5%)</span><span class="font-medium">$ {{ number_format($hasilDistribusi['Allah'], 0, ',', '.') }}</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="font-semibold text-gray-900 border-b pb-3">Operational Fund Allocation</h4>
                            <ul class="mt-4 space-y-3">
                                <li class="flex justify-between items-center text-sm"><span class="text-gray-600">Founder's Return (2.5%)</span><span class="font-medium">$ {{ number_format($hasilDistribusi['Return Founder'], 0, ',', '.') }}</span></li>
                                <li class="flex justify-between items-center text-sm"><span class="text-gray-600">Co-Founder's Return (7.5%)</span><span class="font-medium">$ {{ number_format($hasilDistribusi['Return Co Founder'], 0, ',', '.') }}</span></li>
                                <li class="flex justify-between items-center text-sm"><span class="text-gray-600">Admin (15%)</span><span class="font-medium">$ {{ number_format($hasilDistribusi['Admin'], 0, ',', '.') }}</span></li>
                                <li class="flex justify-between items-center text-sm"><span class="text-gray-600">Development (7.5%)</span><span class="font-medium">$ {{ number_format($hasilDistribusi['Pengembangan'], 0, ',', '.') }}</span></li>
                                <li class="flex justify-between items-center text-sm"><span class="text-gray-600">Project Executor (40%)</span><span class="font-medium">$ {{ number_format($hasilDistribusi['Pelaksana Project'], 0, ',', '.') }}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Right Column: Chart --}}
            <div class="lg:col-span-1 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Distribution Visualization</h3>
                    @if($labaBersih > 0)
                        <canvas id="distributionChart"></canvas>
                    @else
                        <p class="text-center text-gray-500 pt-10">Distribution data will appear if there is a net profit.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if($labaBersih > 0)
                const distCtx = document.getElementById('distributionChart');
                new Chart(distCtx, {
                    type: 'doughnut',
                    data: {
                        labels: @json(array_keys($hasilDistribusi)),
                        datasets: [{
                            data: @json(array_values($hasilDistribusi)),
                            backgroundColor: ['#4338ca', '#4f46e5', '#6366f1', '#a5b4fc', '#c7d2fe', '#10b981', '#34d399', '#6ee7b7'],
                            borderColor: '#fff',
                            borderWidth: 2
                        }]
                    },
                    options: { 
                        responsive: true, 
                        plugins: { 
                            legend: { position: 'bottom' } 
                        } 
                    }
                });
            @endif
        });
    </script>
</x-admin-layout>
