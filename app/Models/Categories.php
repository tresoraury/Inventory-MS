<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    public $timestamps = false;
    protected $table = 'categories';
    protected $primaryKey = 'id_categorie';
    protected $fillable = ['id_categorie','nom_categorie','departement','rangement','type_produit','quantite',];
}
