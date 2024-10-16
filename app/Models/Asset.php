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
        'asset_tag_id',
        'brand',
        'model',
        'specs',
        'serial_number',
        'cost',
        'supplier_id',
        'site_id',
        'location_id',
        'category_id',
        'brand_id',
        'department_id',
        'maintenance_start_date',
        'maintenance_end_date',
        'purchase_date',
        'condition_id',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
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

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function editHistory()
    {
        return $this->hasMany(AssetEditHistory::class);
    }

    public function updateStatusToLeased()
    {
        $leasedStatus = Status::where('status', 'Leased')->first();
        $this->status_id = $leasedStatus->id;
        $this->save();
    }

    public function updateStatusToAvailable()
    {
        $this->status_id = Status::where('status', 'Available')->first()->id;
        $this->save();
    }

    public function updateConditionToUsed()
    {
        $this->condition_id = Condition::where('condition', 'Used')->first()->id;
        $this->save();
    }

}
