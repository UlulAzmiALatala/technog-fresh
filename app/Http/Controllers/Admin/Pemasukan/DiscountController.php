<?php

namespace App\Http\Controllers\Admin\Pemasukan;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::latest()->paginate(10);
        return view('admin.pemasukan.discounts.index', compact('discounts'));
    }

    // METHOD BARU: Untuk menyimpan data dari add-modal
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:discounts,code',
            'amount' => 'required|numeric|min:0',
            'expires_at' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        Discount::create([
            'code' => $request->code,
            'amount' => $request->amount,
            'expires_at' => $request->expires_at,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Discount code has been successfully created.');
    }

    // METHOD BARU: Untuk mengupdate data dari edit-modal
    public function update(Request $request, Discount $discount)
    {
        $request->validate([
            'code' => 'required|string|unique:discounts,code,' . $discount->id,
            'amount' => 'required|numeric|min:0',
            'expires_at' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        $discount->update([
            'code' => $request->code,
            'amount' => $request->amount,
            'expires_at' => $request->expires_at,
            'is_active' => $request->has('is_active'),
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
