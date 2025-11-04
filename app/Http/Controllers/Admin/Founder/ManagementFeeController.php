<?php

namespace App\Http\Controllers\Admin\Founder;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ManagementFeeController extends Controller
{
    public function index(Request $request)
    {
        // 1. Tentukan rentang tanggal dari filter, atau default ke bulan ini
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        // 2. Hitung Laba Bersih berdasarkan rentang tanggal
        $totalPendapatan = Order::where('status', 'Selesai')
            ->whereBetween('updated_at', [$startDate, Carbon::parse($endDate)->endOfDay()])
            ->sum('total_price');

        $totalPengeluaran = Expense::whereBetween('expense_date', [$startDate, $endDate])->sum('amount');

        $labaBersih = $totalPendapatan - $totalPengeluaran;

        // 3. Tentukan Persentase Distribusi
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

        // 4. Hitung Nilai Rupiah untuk Setiap Pos
        $hasilDistribusi = [];
        foreach ($distribusi as $pos => $persentase) {
            $hasilDistribusi[$pos] = $labaBersih > 0 ? $labaBersih * $persentase : 0;
        }

        return view('admin.founder.management-fee.index', compact(
            'labaBersih',
            'hasilDistribusi',
            'startDate',
            'endDate'
        ));
    }

    /**
     * METHOD BARU: Mengekspor data distribusi laba ke CSV.
     */
    public function export(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        $totalPendapatan = Order::where('status', 'Selesai')
            ->whereBetween('updated_at', [$startDate, Carbon::parse($endDate)->endOfDay()])
            ->sum('total_price');
        $totalPengeluaran = Expense::whereBetween('expense_date', [$startDate, $endDate])->sum('amount');
        $labaBersih = $totalPendapatan - $totalPengeluaran;

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

        $fileName = 'distribusi_laba_' . $startDate . '_-_' . $endDate . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function () use ($labaBersih, $distribusi) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Pos Distribusi', 'Persentase', 'Jumlah ($)']);

            foreach ($distribusi as $pos => $persentase) {
                $jumlah = $labaBersih > 0 ? $labaBersih * $persentase : 0;
                fputcsv($file, [$pos, ($persentase * 100) . '%', $jumlah]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
