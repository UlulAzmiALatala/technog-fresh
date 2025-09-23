<?php

namespace App\Http\Controllers\Admin\Founder;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard untuk Founder dengan data statistik dan grafik.
     */
    public function index()
    {
        // --- Data untuk Kartu Statistik ---
        $totalPendapatan = Order::where('status', 'Selesai')->sum('total_price');
        $totalPengeluaran = Expense::sum('amount');
        $jumlahClient = User::role('Client')->count();
        $jumlahPesanan = Order::count();

        // --- Data untuk Grafik ---
        $dates = collect();
        for ($i = 6; $i >= 0; $i--) {
            $dates->put(Carbon::now()->subDays($i)->format('d M'), 0);
        }

        // Ambil pendapatan 7 hari terakhir
        $pendapatanPerHari = Order::where('status', 'Selesai')
            ->where('updated_at', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->get()
            ->groupBy(function ($order) {
                return Carbon::parse($order->updated_at)->format('d M');
            })
            ->map(function ($group) {
                return $group->sum('total_price');
            });

        // Ambil pengeluaran 7 hari terakhir
        $pengeluaranPerHari = Expense::where('expense_date', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->get()
            ->groupBy(function ($expense) {
                return Carbon::parse($expense->expense_date)->format('d M');
            })
            ->map(function ($group) {
                return $group->sum('amount');
            });

        $chartPendapatan = $dates->merge($pendapatanPerHari);
        $chartPengeluaran = $dates->merge($pengeluaranPerHari);

        // MODIFIKASI: Hitung data untuk Grafik Margin Keuntungan
        $chartMargin = collect();
        foreach ($chartPendapatan as $date => $pendapatan) {
            $pengeluaran = $chartPengeluaran->get($date, 0);
            if ($pendapatan > 0) {
                $margin = (($pendapatan - $pengeluaran) / $pendapatan) * 100;
                $chartMargin->put($date, round($margin, 2));
            } else {
                $chartMargin->put($date, 0);
            }
        }

        // Kirim semua data ke view
        return view('admin.founder.dashboard', compact(
            'totalPendapatan',
            'totalPengeluaran',
            'jumlahClient',
            'jumlahPesanan',
            'chartPendapatan',
            'chartPengeluaran',
            'chartMargin' // Kirim data baru ke view
        ));
    }
}
