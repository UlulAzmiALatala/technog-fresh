<?php

namespace App\Http\Controllers\Admin\Founder;

use App\Http\Controllers\Controller;
use App\Models\CaseStudy;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CaseStudyController extends Controller
{
    public function index(Request $request)
    {
        $query = CaseStudy::with('category')->latest();
        $categories = Category::where('type', 'case-study')->get();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('client_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $caseStudies = $query->get();

        return view('admin.founder.case-studies.index', compact('caseStudies', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('type', 'case-study')->get();
        return view('admin.founder.case-studies.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
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

    // =========================================================================
    // PERBAIKAN FINAL DI SINI
    // =========================================================================
    public function edit($id)
    {
        // BARIS YANG HILANG SEBELUMNYA: Cari data berdasarkan ID dari URL.
        $case_study = CaseStudy::findOrFail($id);

        // Setelah data ditemukan dan disimpan di variabel $case_study, baru kita bisa lanjut.
        $categories = Category::where('type', 'case-study')->get();
        return view('admin.founder.case-studies.edit', compact('case_study', 'categories'));
    }

    public function update(Request $request, CaseStudy $case_study)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'problem' => 'required|string',
            'solution' => 'required|string',
            'result' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('image');
        $data['slug'] = Str::slug($request->title) . '-' . $case_study->id;

        if ($request->hasFile('image')) {
            if ($case_study->image) {
                Storage::disk('public')->delete($case_study->image);
            }
            $data['image'] = $request->file('image')->store('case_study_images', 'public');
        }

        $case_study->update($data);

        return redirect()->route('admin.founder.case-studies.index')
            ->with('success', 'Studi kasus berhasil diperbarui.');
    }

    public function destroy(CaseStudy $case_study)
    {
        if ($case_study->image) {
            Storage::disk('public')->delete($case_study->image);
        }

        $case_study->delete();

        return redirect()->route('admin.founder.case-studies.index')
            ->with('success', 'Studi kasus berhasil dihapus.');
    }
}
