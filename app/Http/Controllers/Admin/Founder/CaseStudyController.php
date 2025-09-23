<?php

namespace App\Http\Controllers\Admin\Founder;

use App\Http\Controllers\Controller;
use App\Models\CaseStudy;
use App\Models\Category; // PERBAIKAN: Import model Category
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CaseStudyController extends Controller
{
    public function index(Request $request)
    {
        // Eager load relasi kategori untuk performa
        $query = CaseStudy::with('category')->latest();

        // Ambil kategori dari tabel Category, bukan dari CaseStudy
        $categories = Category::where('type', 'case-study')->get();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('client_name', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan category_id
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $caseStudies = $query->get();

        return view('admin.founder.case-studies.index', compact('caseStudies', 'categories'));
    }

    public function create()
    {
        // PERBAIKAN: Ambil dan kirim kategori ke view
        $categories = Category::where('type', 'case-study')->get();
        return view('admin.founder.case-studies.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id', // Validasi ke category_id
            'problem' => 'required|string',
            'solution' => 'required|string',
            'result' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('image');
        $data['slug'] = Str::slug($request->title) . '-' . time();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('case_study_images', 'public');
        }

        CaseStudy::create($data);

        return redirect()->route('admin.founder.case-studies.index')
            ->with('success', 'Studi kasus baru berhasil ditambahkan.');
    }

    public function edit(CaseStudy $caseStudy)
    {
        // PERBAIKAN: Ambil dan kirim kategori ke view
        $categories = Category::where('type', 'case-study')->get();
        return view('admin.founder.case-studies.edit', compact('caseStudy', 'categories'));
    }

    public function update(Request $request, CaseStudy $caseStudy)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id', // Validasi ke category_id
            'problem' => 'required|string',
            'solution' => 'required|string',
            'result' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('image');
        $data['slug'] = Str::slug($request->title) . '-' . $caseStudy->id;

        if ($request->hasFile('image')) {
            if ($caseStudy->image) {
                Storage::disk('public')->delete($caseStudy->image);
            }
            $data['image'] = $request->file('image')->store('case_study_images', 'public');
        }

        $caseStudy->update($data);

        return redirect()->route('admin.founder.case-studies.index')
            ->with('success', 'Studi kasus berhasil diperbarui.');
    }

    public function destroy(CaseStudy $caseStudy)
    {
        if ($caseStudy->image) {
            Storage::disk('public')->delete($caseStudy->image);
        }

        $caseStudy->delete();

        return redirect()->route('admin.founder.case-studies.index')
            ->with('success', 'Studi kasus berhasil dihapus.');
    }
}
