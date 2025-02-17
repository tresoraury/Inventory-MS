<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produits extends Model
{
    public $timestamps = false;
    protected $table = 'operationss';
    protected $primaryKey = 'id_operation';
    protected $fillable = ['id_operation','materiel_id','type_operation','designation','partenaire','date_operation','quantite'];

    public function materiel()
    {
        return $this->belongsTo(Materiaux::class, 'materiel_id');
    }

    public function type()
    {
        return $this->belongsTo(OperationType::class, 'type_operation');
    }
}
