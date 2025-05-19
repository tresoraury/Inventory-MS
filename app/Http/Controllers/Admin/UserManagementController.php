<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    public function registered()
    {
        $users = User::all();
        return view('admin.register', compact('users'));
    }

    public function registeredit(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.register-edit', compact('user', 'roles'));
    }

    public function registerupdate(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->syncRoles($request->roles);
        $user->save();
        return redirect()->route('role.register')->with('status', 'User updated successfully.');
    }

    public function registerdelete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('role.register')->with('status', 'User deleted successfully.');
    }
}