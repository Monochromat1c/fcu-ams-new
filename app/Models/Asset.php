<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'asset_image',
        'asset_name',
        'brand',
        'model',
        'serial_number',
        'cost',
        'supplier_id',
        'site_id',
        'location_id',
        'category_id',
        'department_id',
        'purchase_date',
        'condition',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function editHistory()
    {
        return $this->hasMany(AssetEditHistory::class);
    }
}
