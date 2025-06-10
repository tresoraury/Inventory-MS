<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleTransaction extends Model
{
    protected $fillable = ['customer_id', 'total_amount', 'created_at', 'updated_at'];

    public function sales()
    {
        return $this->hasMany(Sale::class, 'sale_transaction_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}