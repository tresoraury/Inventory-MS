<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sale;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['materiaux_id', 'quantity', 'client_name', 'total'];

    public function materiaux()
    {
        return $this->belongsTo(Materiaux::class);
    }
}
