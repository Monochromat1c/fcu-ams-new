<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetTurnoverHistory extends Model
{
    protected $table = 'asset_turnover_history';

    protected $fillable = [
        'asset_id',
        'previous_assignee',
        'new_assignee',
        'turnover_date',
        'assignment_start_date',
        'notes',
        'user_id'
    ];

    protected $casts = [
        'turnover_date' => 'datetime',
        'assignment_start_date' => 'date'
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 