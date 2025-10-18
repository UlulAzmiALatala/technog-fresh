<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientDashboardController extends Controller
{
    /**
     * Menampilkan dashboard utama untuk klien.
     */
    public function index()
    {
        $user = Auth::user();

        // Mengubah sapaan ke Bahasa Inggris agar konsisten dengan view
        $greeting = "Welcome Back";
        if ($user->created_at->diffInMinutes(now()) < 5) {
            $greeting = "Welcome";
        }

        // Mengambil semua pesanan milik klien dalam satu query untuk efisiensi
        $allOrders = Order::where('user_id', $user->id)
            ->with('detailOrders.service') // Eager load untuk menghindari N+1 query
            ->latest('updated_at')        // Urutkan dari yang terbaru untuk data relevan
            ->get();

        // --- 1. Menghitung Statistik Kinerja ---
        $completedProjectsCount = $allOrders->where('status', 'Selesai')->count();
        $activeProjectsCount = $allOrders->where('status', 'Diproses')->count();
        $pendingApprovalCount = $allOrders->where('status', 'Menunggu Persetujuan')->count();

        // Menghitung total belanja untuk proyek yang telah selesai
        $totalSpending = $allOrders->where('status', 'Selesai')->sum('total_price');

        // --- 2. Menyiapkan Data untuk Tampilan ---

        // Mengambil SEMUA proyek aktif sebagai koleksi untuk komponen tab "Your Projects"
        $activeProjects = $allOrders->where('status', 'Diproses');

        // --- 3. Mengirim data ke View ---
        return view('client.dashboard', compact(
            'greeting',
            'completedProjectsCount',
            'activeProjectsCount',
            'pendingApprovalCount',
            'activeProjects', // Mengirim koleksi proyek aktif
            'totalSpending'   // Mengirim data total investasi
        ));
    }
}
