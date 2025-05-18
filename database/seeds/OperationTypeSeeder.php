<?php

namespace Database\Seeds;

use Illuminate\Database\Seeder;
use App\Models\OperationType;

class OperationTypeSeeder extends Seeder
{
    public function run()
    {
        OperationType::firstOrCreate(['name' => 'purchase'], ['description' => 'Stock purchase']);
        OperationType::firstOrCreate(['name' => 'sale'], ['description' => 'Stock sale']);
        OperationType::firstOrCreate(['name' => 'adjustment'], ['description' => 'Stock adjustment']);
    }
}