<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // List semua user
    public function index()
    {
        $users = User::with('roles')->get();
        return view('admin.user.index', compact('users'));
    }

    // Form create user
    public function create()
    {
        $roles = Roles::all();
        return view('admin.user.create', compact('roles'));
    }

    // Simpan user baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // simpan ke pivot
        $user->roles()->attach($request->role);

        return redirect()->route('user.index')->with('success', 'User berhasil dibuat.');
    }

    // Form edit user
    public function edit(User $user)
    {
        $roles = Roles::all();
        $userRole = $user->roles->pluck('id')->toArray();
        return view('admin.user.edit', compact('user', 'roles', 'userRole'));
    }

    // Update user
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|exists:roles,id',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        // update role di pivot
        $user->roles()->sync([$request->role]);

        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui.');
    }

    // Hapus user
    public function destroy(User $user)
    {
        $user->roles()->detach();
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus.');
    }
}
