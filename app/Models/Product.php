<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'designation',
        'quantity',
        'unit_price',
        'image_url'
    ];

    public function invoiceLines()
    {
        return $this->hasMany(InvoiceLine::class);
    }
}