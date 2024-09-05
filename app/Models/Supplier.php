<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier',
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
