<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('admin.roles', compact('roles'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'array',
            'permissions.*' => 'array',
            'permissions.*' => 'array',
            
        ]);

        foreach ($request->permissions as $roleId => $permissions) {
            $role = Role::find($roleId);
            
            if ($role) {
                foreach ($permissions as $permission => $value) {
                    
                    $permissionId = Permission::where('name', $permission)->value('id');

                    if ($value && $permissionId) {
                        
                        $role->permissions()->attach($permissionId);
                    } elseif (!$value && $permissionId) {
                        
                        $role->permissions()->detach($permissionId);
                    }
                }
            }
        }

        return redirect()->back()->with('status', 'Permissions updated successfully!');
    }
}
