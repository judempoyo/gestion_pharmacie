<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseLine extends Model
{
    protected $table = 'purchase_lines';

    protected $fillable = [
        'purchase_id',
        'product_id',
        'quantity',
        'unit_price',
    ];

    public function Purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}