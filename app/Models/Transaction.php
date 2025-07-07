<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'transaction_id',
        'product_id',
        'quantity',
        'price',
        'date'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
