<?php

namespace App\Http\Controllers\Admin\Founder;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator; // <-- 1. IMPORT VALIDATOR

class LogoController extends Controller
{
    /**
     * Menampilkan halaman index (tabel) untuk Logos.
     * --- REFRACTOR DI SINI ---
     */
    public function index()
    {
        // 2. Adopsi pola dari 'Discounts'/'Social Links'
        $data = [
            'logos' => Logo::latest()->paginate(10),
            'openEditModalId' => session('open_edit_modal_id_on_error', 0),
            'openAddModal' => session('open_add_modal_on_error', false),
        ];

        return view('admin.founder.settings.logos.index', $data);
    }

    /**
     * Menyimpan logo baru dari modal.
     * --- REFRACTOR DI SINI ---
     */
    public function store(Request $request)
    {
        // 3. Validasi manual
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:logos,name',
            'logo_file' => 'required|image|mimes:png,jpg,jpeg,svg|max:2048',
            'is_active' => 'required|boolean',
        ]);

        // 4. Kirim sinyal jika gagal
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('open_add_modal_on_error', true); // Sinyal untuk buka modal ADD
        }

        // Ambil data yang tervalidasi
        $validated = $validator->validated();

        // 5. Lanjutkan logika sukses (tidak berubah)
        $path = $request->file('logo_file')->store('logos', 'public');

        if ($validated['is_active']) {
            Logo::where('name', $validated['name'])->update(['is_active' => false]);
        }

        Logo::create([
            'name' => $validated['name'],
            'path' => $path,
            'is_active' => $validated['is_active'],
        ]);

        return back()->with('success', 'Logo has been successfully uploaded.');
    }

    /**
     * Mengupdate logo dari modal edit.
     * --- REFRACTOR DI SINI ---
     */
    public function update(Request $request, Logo $logo)
    {
        // 3. Validasi manual
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', Rule::unique('logos')->ignore($logo->id)],
            'logo_file' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048', // 'nullable' saat edit
            'is_active' => 'required|boolean',
        ]);

        // 4. Kirim sinyal jika gagal
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('open_edit_modal_id_on_error', $logo->id); // Sinyal untuk buka modal EDIT
        }

        // Ambil data yang tervalidasi
        $validated = $validator->validated();

        // 5. Lanjutkan logika sukses (tidak berubah)
        $path = $logo->path;

        if ($request->hasFile('logo_file')) {
            Storage::disk('public')->delete($logo->path);
            $path = $request->file('logo_file')->store('logos', 'public');
        }

        if ($validated['is_active']) {
            Logo::where('name', $validated['name'])->where('id', '!=', $logo->id)->update(['is_active' => false]);
        }

        $logo->update([
            'name' => $validated['name'],
            'path' => $path,
            'is_active' => $validated['is_active'],
        ]);

        return back()->with('success', 'Logo has been successfully updated.');
    }

    /**
     * Menghapus logo dari modal delete.
     * (Tidak perlu diubah, sudah benar)
     */
    public function destroy(Logo $logo)
    {
        $logo->delete();
        return back()->with('success', 'Logo has been successfully deleted.');
    }
}
