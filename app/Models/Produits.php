<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produits extends Model
{
    public $timestamps = false;
    protected $table = 'operationss';
    protected $primaryKey = 'id_operation';
    protected $fillable = ['id_operation','materiel_id','type_operation','designation','partenaire','date_operation','quantite'];
}
