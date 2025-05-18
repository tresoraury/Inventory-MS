<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'code', 'name', 'description', 'unit', 'price', 'stock_quantity',
        'category_id', 'supplier_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function operations()
    {
        return $this->hasMany(Operation::class);
    }
}