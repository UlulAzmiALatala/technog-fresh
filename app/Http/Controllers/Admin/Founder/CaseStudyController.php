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
        $categories = Category::where('type', 'case-study')->orderBy('name')->get();
        $query = CaseStudy::with('category')->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('client_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        $caseStudies = $query->paginate(15)->withQueryString();

        return view('admin.founder.case-studies.index', compact('caseStudies', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:case_studies,title',
            'client_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'problem' => 'required|string',
            'solution' => 'required|string',
            'result' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'modal_form' => 'required|string',
        ]);

        $data = $request->except(['image', 'modal_form']);
        $data['slug'] = Str::slug($request->title) . '-' . time();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('case_study_images', 'public');
        }

        CaseStudy::create($data);

        return redirect()->route('admin.founder.case-studies.index')
            ->with('success', 'Studi kasus baru berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $case_study = CaseStudy::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255|unique:case_studies,title,' . $case_study->id,
            'client_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'problem' => 'required|string',
            'solution' => 'required|string',
            'result' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'modal_form' => 'required|string',
        ]);

        $data = $request->except(['image', 'modal_form']);

        if ($case_study->title !== $request->title) {
            $data['slug'] = Str::slug($request->title) . '-' . $case_study->id;
        }

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

    public function destroy($id)
    {
        $case_study = CaseStudy::findOrFail($id);

        if ($case_study->image) {
            Storage::disk('public')->delete($case_study->image);
        }

        $case_study->delete();

        return redirect()->route('admin.founder.case-studies.index')
            ->with('success', 'Studi kasus berhasil dihapus.');
    }
}
