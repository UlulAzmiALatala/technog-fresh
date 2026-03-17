<?php

namespace App\Http\Controllers\Admin\Pemasukan;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DiscountController extends Controller
{
    public function index(Request $request)
    {
        $query = Discount::latest();

        // 1. Fitur Search (berdasarkan kode diskon)
        if ($request->filled('search')) {
            $query->where('code', 'like', '%' . $request->search . '%');
        }

        // 2. Fitur Filter Status (Active / Inactive)
        if ($request->filled('status')) {
            if ($request->status == 'active') {
                $query->where('is_active', true)
                    ->where(function ($q) {
                        $q->whereNull('expires_at')->orWhere('expires_at', '>=', now());
                    })
                    ->where(function ($q) {
                        $q->whereNull('max_uses')->orWhereRaw('current_uses < max_uses');
                    });
            } elseif ($request->status == 'inactive') {
                $query->where(function ($q) {
                    $q->where('is_active', false)
                        ->orWhere('expires_at', '<', now())
                        ->orWhereRaw('max_uses IS NOT NULL AND current_uses >= max_uses');
                });
            }
        }

        // 3. Eksekusi query dengan paginasi
        $discounts = $query->paginate(10)->withQueryString();

        // 4. Return ke view dengan tetap menjaga session logic bawaanmu
        return view('admin.pemasukan.discounts.index', [
            'discounts' => $discounts,
            'openEditModalId' => session('open_edit_modal', 0),
            'oldInput' => session('_old_input'),
        ]);
    }

    public function store(Request $request)
    {
        // 1. NORMALISASI: Ubah ke uppercase sebelum validasi agar 'unique' akurat
        $input = $request->all();
        if ($request->has('code')) {
            $input['code'] = strtoupper($request->code);
        }

        // 2. VALIDASI
        $validator = Validator::make($input, [
            'code' => 'required|string|unique:discounts,code',
            'amount' => 'required|numeric|min:0',
            'expires_at' => 'nullable|date',
            'is_active' => 'required|boolean',
            'max_uses' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput()
                ->with('open_add_modal', true);
        }

        // 3. SIMPAN (Mutator di Model akan memastikan format tetap konsisten)
        Discount::create([
            'code' => $input['code'],
            'amount' => $request->amount,
            'expires_at' => $request->expires_at,
            'is_active' => $request->boolean('is_active'),
            'max_uses' => $request->max_uses,
        ]);

        return back()->with('success', 'Discount code has been successfully created.');
    }

    public function update(Request $request, Discount $discount)
    {
        // 1. NORMALISASI
        $input = $request->all();
        if ($request->has('code')) {
            $input['code'] = strtoupper($request->code);
        }

        // 2. VALIDASI
        $validator = Validator::make($input, [
            'code' => ['required', 'string', Rule::unique('discounts')->ignore($discount->id)],
            'amount' => 'required|numeric|min:0',
            'expires_at' => 'nullable|date',
            'is_active' => 'required|boolean',
            'max_uses' => 'nullable|integer|min:0',
            'current_uses' => 'required|integer|min:0',
        ]);

        // Logika validasi 'lte' Cerdas milikmu
        $validator->after(function ($validator) use ($request) {
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

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput()
                ->with('open_edit_modal', $discount->id);
        }

        // 3. UPDATE
        $discount->update([
            'code' => $input['code'],
            'amount' => $request->amount,
            'expires_at' => $request->expires_at,
            'is_active' => $request->boolean('is_active'),
            'max_uses' => $request->max_uses,
            'current_uses' => $request->current_uses,
        ]);

        return back()->with('success', 'Discount code has been successfully updated.');
    }

    public function destroy(Discount $discount)
    {
        $discount->delete();
        return back()->with('success', 'Discount code has been successfully deleted.');
    }
}
