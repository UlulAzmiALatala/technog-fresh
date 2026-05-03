<?php

namespace App\Http\Controllers\Admin\Founder;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class LogoController extends Controller
{
    public function index()
    {
        $logos = Logo::latest()->paginate(10);
        return view('admin.founder.settings.logos.index', compact('logos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:logos,name',
            'logo_file' => 'required|image|mimes:png,jpg,jpeg,svg|max:2048',
            'is_active' => 'required|boolean',
            'modal_form' => 'required|string', // Menangkap state modal
        ]);

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

    public function update(Request $request, Logo $logo)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('logos')->ignore($logo->id)],
            'logo_file' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'is_active' => 'required|boolean',
            'modal_form' => 'required|string',
        ]);

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

    public function destroy(Logo $logo)
    {
        if ($logo->path) {
            Storage::disk('public')->delete($logo->path);
        }
        $logo->delete();
        return back()->with('success', 'Logo has been successfully deleted.');
    }
}
