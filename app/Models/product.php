<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\category;
use App\Models\suppliers;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'kode_product',
        'category_id',
        'supplier_id',
        'name',
        'sku',
        'description',
        'purchase_price',
        'selling_price',
        'minimum_stock',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(suppliers::class, 'supplier_id');
    }

    public function latestOpname()
    {
        return $this->hasOne(\App\Models\StockOpname::class)->latestOfMany();
    }

    public function opnames()
    {
        return $this->hasMany(\App\Models\StockOpname::class);
    }

    public function stockTransactions()
    {
        return $this->hasMany(\App\Models\StockTransaction::class);
    }
}
