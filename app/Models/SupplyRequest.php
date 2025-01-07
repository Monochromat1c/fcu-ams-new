<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'department_id',
        'inventory_id',
        'requester',
        'quantity',
        'status',
        'notes',
        'request_date'
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
