<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        return view('admin.roles', compact('roles', 'permissions'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        foreach ($request->input('permissions', []) as $roleId => $permissionIds) {
            $role = Role::findOrFail($roleId);
            $role->syncPermissions($permissionIds);
        }

        return redirect()->route('roles.index')->with('success', 'Permissions updated successfully.');
    }
}