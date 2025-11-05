<?php

namespace App\Http\Controllers\Admin\Founder;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SocialLinkController extends Controller
{
    /**
     * Menampilkan halaman index (tabel) untuk sosmed.
     * --- PERUBAHAN DI SINI ---
     */
    public function index()
    {
        // Kita adopsi pola dari DiscountController
        $data = [
            'socialLinks' => SocialLink::orderBy('sort_order')->get(),
            // Kirim sinyal error ke view
            'openEditModalId' => session('open_edit_modal_id_on_error', 0),
            'openAddModal' => session('open_add_modal_on_error', false),
        ];

        return view('admin.founder.settings.socials.index', $data);
    }

    /**
     * Menyimpan data sosmed baru dari modal.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:social_links,name',
            'url' => 'required|url|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                // --- PERUBAHAN DI SINI ---
                ->with('open_add_modal_on_error', true); // Sinyal untuk buka modal ADD
        }

        SocialLink::create($validator->validated());

        return back()->with('success', 'Social media link successfully added.');
    }

    /**
     * Mengupdate data sosmed dari modal edit.
     */
    public function update(Request $request, SocialLink $socialLink)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', Rule::unique('social_links')->ignore($socialLink->id)],
            'url' => 'required|url|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                // --- PERUBAHAN DI SINI ---
                ->with('open_edit_modal_id_on_error', $socialLink->id); // Sinyal untuk buka modal EDIT
        }

        $socialLink->update($validator->validated());

        return back()->with('success', 'Social media link successfully updated.');
    }

    /**
     * Menghapus data sosmed dari modal delete.
     */
    public function destroy(SocialLink $socialLink)
    {
        $socialLink->delete();
        return back()->with('success', 'Social media link successfully deleted.');
    }
}
