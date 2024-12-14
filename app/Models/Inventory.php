<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'unique_tag',
        'stock_image',
        'quantity',
        'unit_id',
        'brand_id',
        'items_specs',
        'unit_price',
        'deleted_at',
        'department_id',
        'stock_out_date',
        'created_by',
        'deleted_by',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function editHistory()
    {
        return $this->hasMany(InventoryEditHistory::class);
    }

    public function generateUniqueTag()
    {
        $firstLetter = substr($this->items_specs, 0, 1);
        $existingTags = self::where('unique_tag', 'like', 'S-' . $firstLetter . '%')->get();
        $nextNumber = count($existingTags) + 1;

        return 'S-' . $firstLetter . $nextNumber;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($supply) {
            $supply->unique_tag = $supply->generateUniqueTag();
        });

        // Add the new methods for tracking created_by and deleted_by
        static::creating(function ($inventory) {
            $inventory->created_by = auth()->id(); 
        });

        static::deleting(function ($inventory) {
            $inventory->deleted_by = auth()->id(); 
            $inventory->save();
        });
    }
}
