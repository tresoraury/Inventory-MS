<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OperationType;

class OperationTypeSeeder extends Seeder
{
    public function run()
    {
        OperationType::create(['name' => 'ENTREE']);
        OperationType::create(['name' => 'SORTIE']);
        OperationType::create(['name' => 'TRANSFERT']);
        OperationType::create(['name' => 'VENTE']);
        OperationType::create(['name' => 'REQUISITION']);
        OperationType::create(['name' => 'PRET']);
    }
}