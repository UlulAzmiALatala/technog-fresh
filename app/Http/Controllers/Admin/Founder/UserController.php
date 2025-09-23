<?php

namespace App\Http\Controllers\Admin\Founder;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Menampilkan daftar pengguna dengan fungsionalitas filter dan pencarian.
     */
    public function index(Request $request)
    {
        $roles = Role::all();
        // Mulai query, ambil semua user kecuali diri sendiri
        $query = User::where('id', '!=', Auth::id())->with('roles');

        // Filter berdasarkan pencarian nama atau email
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Filter berdasarkan peran (role)
        if ($request->filled('role')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        $users = $query->latest()->get();

        return view('admin.founder.users.index', compact('users', 'roles'));
    }

    /**
     * [BARU] Menampilkan halaman detail pengguna.
     */
    public function show(User $user)
    {
        return view('admin.founder.users.show', compact('user'));
    }

    /**
     * Menampilkan form untuk mengedit peran pengguna.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.founder.users.edit', compact('user', 'roles'));
    }

    /**
     * Memperbarui peran pengguna.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        $user->syncRoles($request->role);

        return redirect()->route('admin.founder.users.index')
            ->with('success', 'Peran pengguna berhasil diperbarui.');
    }



    /**
     * Menghapus pengguna dari database.
     */
    public function destroy(User $user)
    {
        // Tambahan keamanan: pastikan founder tidak bisa menghapus dirinya sendiri
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.founder.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.founder.users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
