<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materiaux extends Model
{
     public $timestamps = false;
    protected $table = 'materiaux';
    protected $fillable = ['No_code', 'designation', 'unite_emploie', 'rangement', 'quantite', 'price'];

    public function operations()
    {
        return $this->hasMany(Produits::class, 'materiel_id');
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
}