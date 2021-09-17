<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partenaires extends Model
{
    public $timestamps = false;
    protected $table = 'partenaires';
    protected $primaryKey = 'id_partenaire';
    protected $fillable = ['id_partenaire','type_partenaire','nom_partenaire','departement','operation','date_operation',];
}
