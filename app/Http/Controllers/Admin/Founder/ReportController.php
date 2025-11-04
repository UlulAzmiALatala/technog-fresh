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
        // --- 1. Tentukan Periode Saat Ini ---
        $startDate = Carbon::parse($request->input('start_date', now()->startOfMonth()))->startOfDay();
        $endDate = Carbon::parse($request->input('end_date', now()->endOfMonth()))->endOfDay();

        // --- 2. Tentukan Periode Sebelumnya ---
        $durationInDays = $startDate->diffInDays($endDate);
        $prevStartDate = $startDate->copy()->subDays($durationInDays + 1);
        $prevEndDate = $endDate->copy()->subDays($durationInDays + 1);

        // --- 3. Hitung Metrik Periode Saat Ini ---
        $pendapatanDetails = Order::where('status', 'Selesai')->whereBetween('updated_at', [$startDate, $endDate])->with('user')->get();
        $pengeluaranDetails = Expense::with('category')->whereBetween('expense_date', [$startDate, $endDate])->get();

        $totalPendapatan = $pendapatanDetails->sum('total_price');
        $totalPengeluaran = $pengeluaranDetails->sum('amount');
        $labaBersih = $totalPendapatan - $totalPengeluaran;
        $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])->count();

        // --- 4. Hitung Metrik Periode Sebelumnya ---
        $prevTotalPendapatan = Order::where('status', 'Selesai')->whereBetween('updated_at', [$prevStartDate, $prevEndDate])->sum('total_price');
        $prevTotalPengeluaran = Expense::whereBetween('expense_date', [$prevStartDate, $prevEndDate])->sum('amount');
        $prevLabaBersih = $prevTotalPendapatan - $prevTotalPengeluaran;
        $prevTotalOrders = Order::whereBetween('created_at', [$prevStartDate, $prevEndDate])->count();

        // --- 5. Hitung Persentase Perubahan ---
        // Logika ini mencegah error "division by zero"
        $pendapatanChange = ($prevTotalPendapatan > 0) ? (($totalPendapatan - $prevTotalPendapatan) / $prevTotalPendapatan) * 100 : ($totalPendapatan > 0 ? 100 : 0);
        $pengeluaranChange = ($prevTotalPengeluaran > 0) ? (($totalPengeluaran - $prevTotalPengeluaran) / $prevTotalPengeluaran) * 100 : ($totalPengeluaran > 0 ? 100 : 0);
        $labaBersihChange = ($prevLabaBersih != 0) ? (($labaBersih - $prevLabaBersih) / abs($prevLabaBersih)) * 100 : ($labaBersih != 0 ? 100 : 0);
        $ordersChange = ($prevTotalOrders > 0) ? (($totalOrders - $prevTotalOrders) / $prevTotalOrders) * 100 : ($totalOrders > 0 ? 100 : 0);

        // --- 6. Data untuk Grafik (Kode Anda yang sudah ada, sedikit disesuaikan) ---
        $expenseByCategory = $pengeluaranDetails->groupBy('category.name')->map(fn($group) => $group->sum('amount'));

        $period = CarbonPeriod::create($startDate->toDateString(), $endDate->toDateString());
        $dates = collect($period)->map(fn($date) => $date->format('d M'));

        $pendapatanPerHari = $pendapatanDetails->groupBy(fn($order) => Carbon::parse($order->updated_at)->format('d M'))
            ->map(fn($group) => $group->sum('total_price'));

        $pengeluaranPerHari = $pengeluaranDetails->groupBy(fn($expense) => Carbon::parse($expense->expense_date)->format('d M'))
            ->map(fn($group) => $group->sum('amount'));

        $chartPendapatan = $dates->map(fn($date) => $pendapatanPerHari->get($date, 0))->values();
        $chartPengeluaran = $dates->map(fn($date) => $pengeluaranPerHari->get($date, 0))->values();
        $chartLabaBersih = $chartPendapatan->map(fn($p, $i) => $p - $chartPengeluaran[$i]);

        // --- 7. Logika Distribusi & Management Fee (Kode Anda yang sudah ada) ---
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
        $totalManagementFee = $hasilDistribusi['Founder'] + $hasilDistribusi['Co Founder'] + $hasilDistribusi['Allah'];

        // --- 8. Kirim semua variabel ke view ---
        return view('admin.founder.reports.index', compact(
            'startDate',
            'endDate',
            'totalPendapatan',
            'totalPengeluaran',
            'labaBersih',
            'totalManagementFee',
            'totalOrders',
            'pendapatanChange',
            'pengeluaranChange',
            'labaBersihChange',
            'ordersChange',
            'pendapatanDetails',
            'pengeluaranDetails',
            'expenseByCategory',
            'dates',
            'chartPendapatan',
            'chartPengeluaran',
            'chartLabaBersih',
            'hasilDistribusi'
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
            fputcsv($file, ['Tanggal', 'Tipe', 'Deskripsi', 'Kategori/Klien', 'Jumlah ($)']);

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
