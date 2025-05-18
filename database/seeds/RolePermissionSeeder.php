<?php

namespace Database\Seeds;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = ['manage products', 'manage stock'];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions(['manage products', 'manage stock']);

        $cashier = Role::firstOrCreate(['name' => 'cashier']);
        $cashier->syncPermissions(['manage stock']);

        $warehouse = Role::firstOrCreate(['name' => 'warehouse_manager']);
        $warehouse->syncPermissions(['manage products', 'manage stock']);
    }
}