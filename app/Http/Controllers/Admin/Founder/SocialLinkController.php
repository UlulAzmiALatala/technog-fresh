<?php

namespace App\Http\Controllers\Admin\Founder;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\Request;

class SocialLinkController extends Controller
{
    public function index()
    {
        $socialLinks = SocialLink::orderBy('sort_order')->get();
        return view('admin.founder.settings.socials.index', compact('socialLinks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:social_links,name',
            'url' => 'required|url|max:255',
            'sort_order' => 'nullable|integer',
            'modal_form' => 'required|string', // Menangkap state modal
        ]);

        SocialLink::create($request->except('modal_form'));

        return back()->with('success', 'Social media link successfully added.');
    }

    public function update(Request $request, SocialLink $socialLink)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:social_links,name,' . $socialLink->id,
            'url' => 'required|url|max:255',
            'sort_order' => 'nullable|integer',
            'modal_form' => 'required|string',
        ]);

        $socialLink->update($request->except('modal_form'));

        return back()->with('success', 'Social media link successfully updated.');
    }

    public function destroy(SocialLink $socialLink)
    {
        $socialLink->delete();
        return back()->with('success', 'Social media link successfully deleted.');
    }
}
