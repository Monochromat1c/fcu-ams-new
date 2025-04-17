<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetReturnHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'returned_by',
        'received_by',
        'condition_id',
        'return_date',
        'remarks',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }
} 