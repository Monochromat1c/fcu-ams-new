<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplyRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'request_id',
        'request_group_id',
        'department_id',
        'inventory_id',
        'requester',
        'quantity',
        'request_date',
        'item_name',
        'notes',
        'status',
        'is_approved'
    ];

    protected $casts = [
        'request_date' => 'date',
        'is_approved' => 'boolean'
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
