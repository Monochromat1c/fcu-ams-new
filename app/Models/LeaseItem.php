<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaseItem extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'lease_id',
        'asset_id',
    ];

    public function lease()
    {
        return $this->belongsTo(Lease::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
