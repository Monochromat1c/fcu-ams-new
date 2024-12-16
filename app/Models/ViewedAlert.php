<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewedAlert extends Model
{
    protected $fillable = ['user_id', 'asset_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
