<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
    ];

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }
}
