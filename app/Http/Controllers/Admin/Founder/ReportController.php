<?php

namespace App\Http\Controllers\Admin\Founder;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Tentukan rentang tanggal
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        // --- Data untuk Kartu & Tabel ---
        $pendapatanDetails = Order::where('status', 'Selesai')
            ->whereBetween('updated_at', [$startDate, Carbon::parse($endDate)->endOfDay()])
            ->with('user')
            ->get();

        $pengeluaranDetails = Expense::with('category')
            ->whereBetween('expense_date', [$startDate, $endDate])
            ->get();

        $totalPendapatan = $pendapatanDetails->sum('total_price');
        $totalPengeluaran = $pengeluaranDetails->sum('amount');
        $labaBersih = $totalPendapatan - $totalPengeluaran;

        // --- Data untuk Grafik ---
        // 1. Grafik Komposisi Pengeluaran (Pie Chart)
        $expenseByCategory = $pengeluaranDetails->groupBy('category.name')
            ->map(fn($group) => $group->sum('amount'));

        // 2. Grafik Tren Keuangan (Line Chart)
        $period = CarbonPeriod::create($startDate, $endDate);
        $dates = collect($period)->map(fn($date) => $date->format('d M'));

        $datesWithData = $dates->mapWithKeys(fn($date) => [$date => ['pendapatan' => 0, 'pengeluaran' => 0]]);

        $pendapatanPerHari = Order::where('status', 'Selesai')
            ->whereBetween('updated_at', [$startDate, Carbon::parse($endDate)->endOfDay()])
            ->get()
            ->groupBy(fn($order) => Carbon::parse($order->updated_at)->format('d M'))
            ->map(fn($group) => $group->sum('total_price'));

        $pengeluaranPerHari = Expense::whereBetween('expense_date', [$startDate, $endDate])
            ->get()
            ->groupBy(fn($expense) => Carbon::parse($expense->expense_date)->format('d M'))
            ->map(fn($group) => $group->sum('amount'));

        $mergedData = $datesWithData->map(function ($value, $key) use ($pendapatanPerHari, $pengeluaranPerHari) {
            $value['pendapatan'] = $pendapatanPerHari->get($key, 0);
            $value['pengeluaran'] = $pengeluaranPerHari->get($key, 0);
            return $value;
        });

        $chartPendapatan = $mergedData->pluck('pendapatan');
        $chartPengeluaran = $mergedData->pluck('pengeluaran');
        $chartLabaBersih = $mergedData->map(fn($data) => $data['pendapatan'] - $data['pengeluaran']);

        // Logika untuk Management Fee
        $distribusi = [
            'Founder' => 0.15,
            'Co Founder' => 0.05,
            'Allah' => 0.075,
            'Return Founder' => 0.025,
            'Return Co Founder' => 0.075,
            'Admin' => 0.15,
            'Pengembangan' => 0.075,
            'Pelaksana Project' => 0.40,
        ];

        $hasilDistribusi = [];
        foreach ($distribusi as $pos => $persentase) {
            $hasilDistribusi[$pos] = $labaBersih > 0 ? $labaBersih * $persentase : 0;
        }

        // PERBAIKAN: Hitung total management fee
        $totalManagementFee = $hasilDistribusi['Founder'] + $hasilDistribusi['Co Founder'] + $hasilDistribusi['Allah'];

        return view('admin.founder.reports.index', compact(
            'startDate',
            'endDate',
            'pendapatanDetails',
            'pengeluaranDetails',
            'totalPendapatan',
            'totalPengeluaran',
            'labaBersih',
            'expenseByCategory',
            'dates',
            'chartPendapatan',
            'chartPengeluaran',
            'chartLabaBersih',
            'hasilDistribusi',
            'totalManagementFee' // Kirim data baru
        ));
    }

    public function export(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        $pendapatanDetails = Order::where('status', 'Selesai')
            ->whereBetween('updated_at', [$startDate, Carbon::parse($endDate)->endOfDay()])
            ->with('user')->get();

        $pengeluaranDetails = Expense::whereBetween('expense_date', [$startDate, $endDate])
            ->with('category')->get();

        $totalPendapatan = $pendapatanDetails->sum('total_price');
        $totalPengeluaran = $pengeluaranDetails->sum('amount');
        $labaBersih = $totalPendapatan - $totalPengeluaran;

        $fileName = 'laporan_keuangan_' . $startDate . '_-_' . $endDate . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function () use ($pendapatanDetails, $pengeluaranDetails, $totalPendapatan, $totalPengeluaran, $labaBersih) {
            $file = fopen('php://output', 'w');

            // Header CSV
            fputcsv($file, ['Tanggal', 'Tipe', 'Deskripsi', 'Kategori/Klien', 'Jumlah (Rp)']);

            // Data Pendapatan
            foreach ($pendapatanDetails as $order) {
                fputcsv($file, [
                    Carbon::parse($order->updated_at)->format('Y-m-d'),
                    'Pendapatan',
                    'Pesanan #' . $order->id,
                    $order->user->name,
                    $order->total_price
                ]);
            }

            // Data Pengeluaran
            foreach ($pengeluaranDetails as $expense) {
                fputcsv($file, [
                    $expense->expense_date,
                    'Pengeluaran',
                    $expense->description,
                    $expense->category->name ?? 'N/A',
                    $expense->amount
                ]);
            }

            // Ringkasan
            fputcsv($file, []); // Baris kosong
            fputcsv($file, ['Ringkasan Keuangan']);
            fputcsv($file, ['Total Pendapatan', $totalPendapatan]);
            fputcsv($file, ['Total Pengeluaran', $totalPengeluaran]);
            fputcsv($file, ['Laba Bersih', $labaBersih]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
