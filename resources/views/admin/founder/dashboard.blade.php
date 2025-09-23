{{-- Lokasi: resources/views/founder/dashboard.blade.php --}}

<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Founder Dashboard') }}
        </h2>
    </x-slot>

    <div class="mt-4">
        {{-- Kartu Statistik yang Diperbarui --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Kartu Total Pendapatan --}}
            <div class="bg-white border-l-4 border-green-500 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <p class="text-sm font-medium text-gray-500 truncate">Total Pendapatan</p>
                    <p class="mt-1 text-3xl font-semibold text-gray-900">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Kartu Total Pengeluaran --}}
            <div class="bg-white border-l-4 border-red-500 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <p class="text-sm font-medium text-gray-500 truncate">Total Pengeluaran</p>
                    <p class="mt-1 text-3xl font-semibold text-gray-900">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Kartu Jumlah Client --}}
            <div class="bg-white border-l-4 border-blue-500 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <p class="text-sm font-medium text-gray-500 truncate">Jumlah Client</p>
                    <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $jumlahClient }}</p>
                </div>
            </div>

            {{-- Kartu Jumlah Pesanan --}}
            <div class="bg-white border-l-4 border-yellow-500 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <p class="text-sm font-medium text-gray-500 truncate">Jumlah Pesanan</p>
                    <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $jumlahPesanan }}</p>
                </div>
            </div>
        </div>

        {{-- Layout Dua Kolom untuk Grafik --}}
        <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Grafik Keuangan --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Ringkasan Keuangan (7 Hari Terakhir)</h3>
                    <canvas id="financialChart"></canvas>
                </div>
            </div>

            {{-- Grafik Margin Keuntungan --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Margin Keuntungan (%)</h3>
                    <canvas id="marginChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Script untuk Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Grafik Keuangan (Line)
        const financialCtx = document.getElementById('financialChart');
        new Chart(financialCtx, {
            type: 'line',
            data: {
                labels: @json($chartPendapatan->keys()),
                datasets: [
                    {
                        label: 'Pendapatan',
                        data: @json($chartPendapatan->values()),
                        borderColor: 'rgb(34, 197, 94)',
                        backgroundColor: 'rgba(34, 197, 94, 0.2)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Pengeluaran',
                        data: @json($chartPengeluaran->values()),
                        borderColor: 'rgb(239, 68, 68)',
                        backgroundColor: 'rgba(239, 68, 68, 0.2)',
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                scales: { y: { beginAtZero: true, ticks: { callback: (value) => 'Rp ' + new Intl.NumberFormat('id-ID').format(value) } } }
            }
        });

        // Grafik Margin (Bar)
        const marginCtx = document.getElementById('marginChart');
        new Chart(marginCtx, {
            type: 'bar',
            data: {
                labels: @json($chartMargin->keys()),
                datasets: [{
                    label: 'Margin Keuntungan (%)',
                    data: @json($chartMargin->values()),
                    backgroundColor: 'rgba(59, 130, 246, 0.6)',
                    borderColor: 'rgb(59, 130, 246)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: { y: { beginAtZero: true, ticks: { callback: (value) => value + '%' } } },
                plugins: { legend: { display: false } }
            }
        });
    </script>
</x-admin-layout>
