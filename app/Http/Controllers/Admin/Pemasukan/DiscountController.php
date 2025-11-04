<?php

namespace App\Http\Controllers\Admin\Pemasukan;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // <-- Tambahkan ini
use Illuminate\Validation\Rule;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::latest()->paginate(10);
        // Data ini dikirim untuk 'menangkap' error modal edit
        $data = [
            'discounts' => $discounts,
            // Cek jika ada error di session 'open_edit_modal'
            'openEditModalId' => session('open_edit_modal', 0),
            // Ambil data 'old' jika validasi gagal
            'oldInput' => session('_old_input'),
        ];
        return view('admin.pemasukan.discounts.index', $data);
    }

    // METHOD BARU: Untuk menyimpan data dari add-modal
    public function store(Request $request)
    {
        // --- PERUBAHAN: Validasi manual untuk 'add' ---
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|unique:discounts,code',
            'amount' => 'required|numeric|min:0',
            'expires_at' => 'nullable|date',
            'is_active' => 'required|boolean',
            'max_uses' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput()
                ->with('open_add_modal', true); // <-- Kirim sinyal untuk 'add'
        }

        Discount::create([
            'code' => $request->code,
            'amount' => $request->amount,
            'expires_at' => $request->expires_at,
            'is_active' => $request->boolean('is_active'),
            'max_uses' => $request->max_uses,
        ]);

        return back()->with('success', 'Discount code has been successfully created.');
    }

    // METHOD BARU: Untuk mengupdate data dari edit-modal
    public function update(Request $request, Discount $discount)
    {
        // --- PERUBAHAN BESAR: Validasi Manual & Logika 'lte' Cerdas ---

        $validator = Validator::make($request->all(), [
            'code' => ['required', 'string', Rule::unique('discounts')->ignore($discount->id)],
            'amount' => 'required|numeric|min:0',
            'expires_at' => 'nullable|date',
            'is_active' => 'required|boolean',
            'max_uses' => 'nullable|integer|min:0',
            'current_uses' => 'required|integer|min:0', // Aturan 'lte' dihapus dari sini
        ]);

        // Logika validasi 'lte' Cerdas
        $validator->after(function ($validator) use ($request) {
            // Kita hanya validasi 'lte' jika max_uses diisi (BUKAN NULL)
            if ($request->filled('max_uses')) {
                $maxUses = (int) $request->max_uses;
                $currentUses = (int) $request->current_uses;

                if ($currentUses > $maxUses) {
                    $validator->errors()->add(
                        'current_uses',
                        'Current uses cannot be greater than max uses.'
                    );
                }
            }
        });

        // Cek jika validasi gagal
        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput()
                ->with('open_edit_modal', $discount->id); // <-- INI KUNCINYA
        }

        // --- Akhir Perubahan ---

        $discount->update([
            'code' => $request->code,
            'amount' => $request->amount,
            'expires_at' => $request->expires_at,
            'is_active' => $request->boolean('is_active'),
            'max_uses' => $request->max_uses,
            'current_uses' => $request->current_uses,
        ]);

        return back()->with('success', 'Discount code has been successfully updated.');
    }

    // METHOD BARU: Untuk menghapus data dari delete-modal
    public function destroy(Discount $discount)
    {
        $discount->delete();
        return back()->with('success', 'Discount code has been successfully deleted.');
    }
}
