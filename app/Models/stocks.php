<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class stocks extends Model
{
    public $timestamps = false;
    protected $table = 'stocks';
    protected $primaryKey = 'id_stock';
    protected $fillable = ['id_stock','id_materiaux','quantite','quantite_detaille'];
}
