<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    protected $fillable = [
        'product_id', 'operation_type_id', 'supplier_id', 'quantity', 'operation_date'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function operationType()
    {
        return $this->belongsTo(OperationType::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}