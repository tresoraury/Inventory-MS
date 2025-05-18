<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'address'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function operations()
    {
        return $this->hasMany(Operation::class);
    }
}