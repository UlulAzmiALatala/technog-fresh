<?php

namespace App\Http\Controllers\Admin\Pemasukan;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $totalServices = Service::count();
        $totalCategories = Category::where('type', 'service')->count();
        $categories = Category::where('type', 'service')->get();

        $query = Service::with('category')->latest();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('package_plan')) {
            $query->where('package_plan', $request->package_plan);
        }

        $services = $query->paginate(10)->withQueryString();

        return view('admin.pemasukan.services.index', compact(
            'services',
            'totalServices',
            'totalCategories',
            'categories'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'project_type' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'package_plan' => 'required|in:Silver Plan,Gold Plan,Platinum Sphere,Diamond Class,Ultima Partnership,Custom Engagement',
            'price' => 'required|numeric|min:0',
            'estimated_duration' => 'required|integer|min:1',
            'duration_unit' => 'required|in:Hari,Minggu,Bulan',
            'use_case' => 'nullable|string', // <-- TAMBAHAN BARU
            'workflow' => 'nullable|string', // <-- TAMBAHAN BARU
            'features' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'modal_form' => 'nullable|string',
        ]);

        $data = $request->except(['image', 'modal_form']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('service_images', 'public');
        }

        Service::create($data);

        return back()->with('success', 'Layanan baru berhasil ditambahkan.');
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'project_type' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'package_plan' => 'required|in:Silver Plan,Gold Plan,Platinum Sphere,Diamond Class,Ultima Partnership,Custom Engagement',
            'price' => 'required|numeric|min:0',
            'estimated_duration' => 'required|integer|min:1',
            'duration_unit' => 'required|in:Hari,Minggu,Bulan',
            'use_case' => 'nullable|string', // <-- TAMBAHAN BARU
            'workflow' => 'nullable|string', // <-- TAMBAHAN BARU
            'features' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'modal_form' => 'nullable|string',
        ]);

        $data = $request->except(['image', 'modal_form']);

        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $data['image'] = $request->file('image')->store('service_images', 'public');
        }

        $service->update($data);

        return back()->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Service $service)
    {
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }
        $service->delete();

        return back()->with('success', 'Layanan berhasil dihapus.');
    }
}
