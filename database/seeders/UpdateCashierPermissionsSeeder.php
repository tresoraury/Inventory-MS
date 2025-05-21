<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UpdateCashierPermissionsSeeder extends Seeder
{
    public function run()
    {
        $role = Role::findById(2, 'web'); // cashier
        $permissions = [1, 2, 3, 4, 5, 6, 7, 8]; // all permissions
        $role->syncPermissions($permissions); // Sync to avoid duplicates
    }
}