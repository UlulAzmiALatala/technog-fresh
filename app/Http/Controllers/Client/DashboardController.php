<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order; // Pastikan model Order ada

class DashboardController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        // Jika user baru mendaftar dalam 5 menit terakhir, anggap ini kunjungan pertama.
        $isFirstVisit = $user->created_at->diffInMinutes(now()) < 5;
        $greeting = $isFirstVisit ? "Selamat Datang" : "Selamat Datang Kembali";

        // Mengambil semua pesanan milik klien dalam satu query untuk efisiensi
        $allOrders = Order::where('user_id', $user->id)
            ->with('detailOrders.service') // Eager load untuk menghindari N+1 query
            ->latest('updated_at')         // Urutkan dari yang terbaru untuk data relevan
            ->get();

        // --- 1. Menghitung Statistik Kinerja ---

        // Menghitung Proyek Selesai
        $completedOrders = $allOrders->where('status', 'Selesai');
        $completedProjectsCount = $completedOrders->count();

        // Menghitung Proyek Aktif
        $activeProjectsCount = $allOrders->where('status', 'Diproses')->count();

        // Menghitung Proyek yang Menunggu Persetujuan Klien
        // PENTING: Ganti 'Menunggu Persetujuan' dengan status yang Anda gunakan di sistem Anda.
        $pendingApprovalCount = $allOrders->where('status', 'Menunggu Persetujuan')->count();

        // --- 2. Menghitung Tingkat Penyelesaian Tepat Waktu ---

        // PENTING: Ini mengasumsikan model Order Anda memiliki kolom `due_date` dan `completed_at`.
        $onTimeProjectsCount = $completedOrders->filter(function ($order) {
            return $order->completed_at && $order->due_date && $order->completed_at->lte($order->due_date);
        })->count();

        // Menghitung persentase dan menghindari pembagian dengan nol
        $onTimeCompletionRate = ($completedProjectsCount > 0)
            ? round(($onTimeProjectsCount / $completedProjectsCount) * 100)
            : 0; // Default 0% jika belum ada proyek selesai

        // --- 3. Menyiapkan Data untuk Tampilan ---

        // Mengambil 1 proyek aktif teratas untuk ditampilkan di kolom kanan
        // PENTING: Ini mengasumsikan model Order Anda memiliki kolom `progress` (integer 0-100).
        $activeProject = $allOrders->where('status', 'Diproses')->first();

        // Mengambil 5 pesanan terbaru untuk ditampilkan di tabel riwayat
        $recentOrders = $allOrders->take(5);

        // --- 4. Mengirim data ke View ---
        return view('client.dashboard', compact(
            'greeting', // Variabel sapaan baru ditambahkan
            'completedProjectsCount',
            'activeProjectsCount',
            'onTimeCompletionRate',
            'pendingApprovalCount',
            'activeProject',
            'recentOrders'
        ));
    }
}
