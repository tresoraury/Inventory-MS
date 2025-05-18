<?php

namespace Database\Seeds;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\OperationType;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RolePermissionSeeder::class,
            OperationTypeSeeder::class,
        ]);

        Category::create(['name' => 'Electronics', 'description' => 'Electronic products']);
        Category::create(['name' => 'Clothing', 'description' => 'Clothing items']);

        Supplier::create([
            'name' => 'Tech Supplier',
            'email' => 'tech@supplier.com',
            'phone' => '1234567890',
            'address' => '123 Tech St'
        ]);

        Product::create([
            'code' => 'ELEC001',
            'name' => 'Smartphone',
            'unit' => 'unit',
            'price' => 599.99,
            'stock_quantity' => 100,
            'category_id' => 1,
            'supplier_id' => 1
        ]);
    }
}