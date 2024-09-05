<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'stock_image',
        'stocks',
        'unit',
        'items_specs',
        'unit_price',
        'deleted_at',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
