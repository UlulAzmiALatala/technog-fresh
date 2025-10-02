<?php

namespace App\Http\Controllers\Admin\Pemasukan;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * Menampilkan daftar layanan.
     */
    public function index(Request $request)
    {
        // [BAGIAN BARU] Menghitung data statistik
        $totalServices = Service::count();
        $totalCategories = Category::where('type', 'service')->count();

        // Logika query Anda yang sudah ada
        $query = Service::with('category')->latest();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('package_plan')) {
            $query->where('package_plan', $request->package_plan);
        }

        // [MODIFIKASI] Menambahkan withQueryString() agar filter tidak hilang saat ganti halaman
        $services = $query->paginate(10)->withQueryString();

        // [MODIFIKASI] Mengirim semua variabel (termasuk statistik) ke view
        // dan menyesuaikan path view Anda
        return view('admin.pemasukan.index', compact(
            'services',
            'totalServices',
            'totalCategories'
        ));
    }

    /**
     * Menampilkan form untuk membuat layanan baru.
     */
    public function create()
    {
        $categories = Category::where('type', 'service')->get();

        return view('admin.pemasukan.create', compact('categories'));
    }

    /**
     * Menyimpan layanan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'package_plan' => 'required|in:Silver Plan,Gold Plan,Platinum Sphere,Diamond Class,Ultima Partnership,Custom Engagement',
            'price' => 'required|numeric|min:0',
            'estimated_duration' => 'required|integer|min:1',
            'duration_unit' => 'required|in:Hari,Minggu,Bulan',
            'features' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('service_images', 'public');
        }

        Service::create($data);

        return redirect()->route('admin.pemasukan.services.index')
            ->with('success', 'Layanan baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit layanan.
     */
    public function edit(Service $service)
    {
        $categories = Category::where('type', 'service')->get();
        return view('admin.pemasukan.edit', compact('service', 'categories'));
    }

    /**
     * Memperbarui layanan di database.
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'package_plan' => 'required|in:Silver Plan,Gold Plan,Platinum Sphere,Diamond Class,Ultima Partnership,Custom Engagement',
            'price' => 'required|numeric|min:0',
            'estimated_duration' => 'required|integer|min:1',
            'duration_unit' => 'required|in:Hari,Minggu,Bulan',
            'features' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $data['image'] = $request->file('image')->store('service_images', 'public');
        }

        $service->update($data);

        return redirect()->route('admin.pemasukan.services.index')
            ->with('success', 'Layanan berhasil diperbarui.');
    }

    /**
     * Menghapus layanan dari database.
     */
    public function destroy(Service $service)
    {
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }
        $service->delete();
        return redirect()->route('admin.pemasukan.services.index')
            ->with('success', 'Layanan berhasil dihapus.');
    }
}
