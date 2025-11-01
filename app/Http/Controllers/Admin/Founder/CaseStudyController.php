<?php

namespace App\Http\Controllers\Admin\Founder;

use App\Http\Controllers\Controller;
use App\Models\CaseStudy;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
// [REFACTOR] Import class ValidationException
use Illuminate\Validation\ValidationException;

class CaseStudyController extends Controller
{
    /**
     * Display a listing of the resource.
     * (Method ini sudah benar dan siap untuk modal)
     */
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

        // Gunakan paginate() agar links() di view berfungsi
        $caseStudies = $query->paginate(15)->withQueryString();

        return view('admin.founder.case-studies.index', compact('caseStudies', 'categories'));
    }

    /**
     * [REFACTOR] Method create() sudah tidak diperlukan.
     * Form "add" sekarang ada di dalam modal di halaman index.
     */
    // public function create() { ... }


    /**
     * Store a newly created resource in storage.
     * (Dimodifikasi untuk menangani validation redirect ke modal)
     */
    public function store(Request $request)
    {
        try {
            // Validasi data
            $validatedData = $request->validate([
                'title' => 'required|string|max:255|unique:case_studies,title',
                'client_name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'problem' => 'required|string',
                'solution' => 'required|string',
                'result' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'modal_form' => 'required|string', // Pastikan modal_form ada
            ]);

            $data = $validatedData;
            $data['slug'] = Str::slug($request->title) . '-' . time();

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('case_study_images', 'public');
            }

            CaseStudy::create($data);

            return redirect()->route('admin.founder.case-studies.index')
                ->with('success', 'Studi kasus baru berhasil ditambahkan.');
        } catch (ValidationException $e) {
            // [REFACTOR] Jika validasi gagal:
            // 1. Redirect kembali ke 'index' (bukan 'create')
            // 2. Kirim errors-nya
            // 3. Kirim input lama
            // 4. Kirim session 'modal_form' agar Alpine tahu modal mana yang harus dibuka
            return redirect()->route('admin.founder.case-studies.index')
                ->withErrors($e->errors())
                ->withInput()
                ->with('modal_form', $request->input('modal_form', 'add'));
        }
    }


    /**
     * [REFACTOR] Method edit() sudah tidak diperlukan.
     * Form "edit" sekarang ada di dalam modal di halaman index.
     */
    // public function edit($id) { ... }


    /**
     * Update the specified resource in storage.
     * (Dimodifikasi untuk menangani validation redirect ke modal)
     */
    public function update(Request $request, $id)
    {
        // Kita tetap menggunakan findOrFail($id) karena Model menggunakan 'slug'
        $case_study = CaseStudy::findOrFail($id);

        try {
            // Validasi data
            $validatedData = $request->validate([
                // Pastikan 'unique' mengabaikan ID saat ini
                'title' => 'required|string|max:255|unique:case_studies,title,' . $case_study->id,
                'client_name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'problem' => 'required|string',
                'solution' => 'required|string',
                'result' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'modal_form' => 'required|string',
            ]);

            $data = $validatedData;
            // Update slug hanya jika title berubah
            if ($case_study->title !== $request->title) {
                $data['slug'] = Str::slug($request->title) . '-' . $case_study->id;
            }

            if ($request->hasFile('image')) {
                // Hapus gambar lama jika ada
                if ($case_study->image) {
                    Storage::disk('public')->delete($case_study->image);
                }
                // Simpan gambar baru
                $data['image'] = $request->file('image')->store('case_study_images', 'public');
            }

            $case_study->update($data);

            return redirect()->route('admin.founder.case-studies.index')
                ->with('success', 'Studi kasus berhasil diperbarui.');
        } catch (ValidationException $e) {
            // [REFACTOR] Jika validasi gagal, redirect ke index
            // dan kirim session 'modal_form' = 'edit'
            return redirect()->route('admin.founder.case-studies.index')
                ->withErrors($e->errors())
                ->withInput()
                ->with('modal_form', $request->input('modal_form', 'edit'));
        }
    }

    /**
     * Remove the specified resource from storage.
     * (Method ini sudah benar dan siap untuk modal)
     */
    public function destroy($id)
    {
        // Kita tetap menggunakan findOrFail($id)
        $case_study = CaseStudy::findOrFail($id);

        if ($case_study->image) {
            Storage::disk('public')->delete($case_study->image);
        }

        $case_study->delete();

        return redirect()->route('admin.founder.case-studies.index')
            ->with('success', 'Studi kasus berhasil dihapus.');
    }
}
