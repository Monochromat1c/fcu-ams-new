<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetEditHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'user_id',
        'changes',
    ];

    // public function asset()
    // {
    //     return $this->belongsTo(Asset::class);
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function asset()
    {
    return $this->belongsTo(Asset::class, 'asset_id');
    }
}
