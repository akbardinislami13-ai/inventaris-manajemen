<?php

namespace App\Http\Controllers;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Tampilkan daftar pengguna beserta role-nya.
     */
    public function index(): View
    {
        $users = User::with('roles')->orderBy('name')->paginate(10);

        $roles = Role::orderBy('name')->pluck('name');

        return view('users.index', compact('users', 'roles'));
    }

    /**
     * Ubah role seorang pengguna.
     */
    public function updateRole(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'role' => ['required', Rule::in(array_keys(RolePermissionSeeder::ROLE_PERMISSIONS))],
        ]);

        $user->syncRoles([$data['role']]);

        return back()->with(
            'success',
            "Role {$user->name} berhasil diubah menjadi {$data['role']}."
        );
    }
}
