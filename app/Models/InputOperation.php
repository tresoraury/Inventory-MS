<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InputOperation extends Model
{
    use HasFactory;

    protected $fillable = ['materiel_id', 'quantite'];

    public function materiel()
    {
        return $this->belongsTo(Materiaux::class, 'materiel_id');
    }
}
