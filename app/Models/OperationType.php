<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperationType extends Model
{
    
    public $timestamps = false;
    protected $table = 'operation_types';
    protected $fillable = ['name']; 

    public function operations()
    {
        return $this->hasMany(Produits::class, 'type_operation');
    }
}