<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    protected $fillable = [
    'stock_transaction_id',
    'product_id',
    'user_id',
    'real_in_quantity',
    'real_out_quantity',
    'note',
    'date'
    ];

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function transaction()
    {
        return $this->belongsTo(\App\Models\StockTransaction::class, 'stock_transaction_id');
    }


}
