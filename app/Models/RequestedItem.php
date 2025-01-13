<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestedItem extends Model
{
    protected $fillable = [
        'brand_id',
        'items_specs',
        'unit_id',
        'quantity',
        'unit_price',
        'supplier_id',
        'status',
        'remarks'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
