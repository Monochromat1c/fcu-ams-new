<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'maintenance_title',
        'maintenance_detail',
        'maintenance_due_date',
        'maintenance_by',
        'maintenance_status',
        'date_completed',
        'maintenance_cost',
    ];
}
