<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperationType extends Model
{
    protected $fillable = ['name', 'description', 'created_at', 'updated_at'];

    public function operations()
    {
        return $this->hasMany(Operation::class, 'operation_type_id');
    }
}