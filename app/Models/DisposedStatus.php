<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DisposedStatus extends Model
{
    protected $fillable = [
        'status'
    ];

    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class, 'disposed_status_id');
    }
}
