<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = 'purchases';

    protected $fillable = [
        'Supplier_id',
        'total_amount',
    ];

    public function Supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function purchaseLines()
    {
        return $this->hasMany(PurchaseLine::class);
    }
}