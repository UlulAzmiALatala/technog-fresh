<?php

namespace App\Http\Controllers\Admin\Founder;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $totalUsers = User::count();
        $newUsersThisMonth = User::where('created_at', '>=', now()->startOfMonth())->count();
        $totalClients = User::role('Client')->count();
        $totalAdmins = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'Client');
        })->count();

        $roles = Role::all();
        $query = User::where('id', '!=', Auth::id())->with('roles');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        $users = $query->latest()->paginate(12)->withQueryString();

        return view('admin.founder.users.index', compact(
            'users',
            'roles',
            'totalUsers',
            'newUsersThisMonth',
            'totalClients',
            'totalAdmins'
        ));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
            'modal_form' => 'required|string', // Menangkap state modal
        ]);

        $user->syncRoles($request->role);

        return back()->with('success', 'Peran pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return back()->with('success', 'Pengguna berhasil dihapus.');
    }
}
