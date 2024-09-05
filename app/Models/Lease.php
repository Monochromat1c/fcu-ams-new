<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lease extends Model
{
    use HasFactory;

    protected $fillable = [
        'lease_date',
        'lease_expiration',
        'customer',
        'note',
    ];

    public function leaseItems()
    {
        return $this->hasMany(LeaseItem::class);
    }

    public function assets()
    {
        return $this->belongsToMany(Asset::class, 'lease_items');
    }
}
