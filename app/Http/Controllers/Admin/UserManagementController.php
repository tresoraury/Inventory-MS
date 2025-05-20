<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage users');
    }

    public function registered()
    {
        $users = User::with('roles')->get();
        return view('admin.register', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.user_create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'notify_low_stock' => $request->notify_low_stock ?? 0,
        ]);

        $role = Role::findOrFail($request->role_id);
        $user->assignRole($role);

        return redirect()->route('role.register')->with('success', 'User created successfully.');
    }

    public function registeredit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.registeredit', compact('user', 'roles'));
    }

    public function registerupdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($id);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'notify_low_stock' => $request->notify_low_stock ?? 0,
        ];
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }
        $user->update($data);

        $role = Role::findOrFail($request->role_id);
        $user->syncRoles([$role]);

        return redirect()->route('role.register')->with('success', 'User updated successfully.');
    }

    public function registerdelete($id)
    {
        if ($id == 1) {
            return redirect()->route('role.register')->with('error', 'Cannot delete the primary admin user.');
        }
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('role.register')->with('success', 'User deleted successfully.');
    }
}