<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_out_id',
        'inventory_id',
        'quantity',
        'department_id',
        'stock_out_date',
        'receiver',
        'created_by'
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
