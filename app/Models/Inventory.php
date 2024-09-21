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
        'stocks',
        'unit',
        'items_specs',
        'unit_price',
        'deleted_at',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function generateUniqueTag()
    {
        $firstLetter = substr($this->name, 0, 1);
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
    }
}
