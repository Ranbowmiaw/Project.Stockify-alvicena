<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\product;
use App\Models\category;
use App\Models\User;

class StockTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'type',
        'quantity',
        'date',
        'status',
        'note',
    ];

    public function product()
    {
        return $this->belongsTo(product::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function opname()
    {
        return $this->hasOne(\App\Models\StockOpname::class, 'stock_transaction_id');
    }

    public function latestOpname()
    {
        return $this->hasOne(\App\Models\StockOpname::class)->latestOfMany('date');
    }
}
