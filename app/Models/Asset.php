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
        'assigned_to',
        'issued_date',
        'returned_at',
        'notes',
        'created_by',
        'deleted_by',
        'status_id'
    ];

    protected $appends = ['current_value', 'months_elapsed'];

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

    public function viewedAlerts()
    {
        return $this->hasMany(ViewedAlert::class);
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

    // Optional: Method to restore a soft-deleted asset
    public function restore()
    {
        $this->deleted_at = null;
        $this->deleted_by = null;
        $this->save();
    }

    // In Asset model
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($asset) {
            if (empty($asset->created_by) && auth()->check()) {
                $asset->created_by = auth()->id();
            }
        });

        static::deleting(function ($asset) {
            if (empty($asset->deleted_by) && auth()->check()) {
                $asset->deleted_by = auth()->id();
            }
        });
    }

    public function getCurrentValueAttribute()
    {
        // Get months elapsed since purchase
        $monthsElapsed = $this->getMonthsElapsedAttribute();
        
        // Total depreciation period in months (5 years = 60 months)
        $totalDepreciationPeriod = 60;
        
        // If more than 5 years have passed, value is 0
        if ($monthsElapsed >= $totalDepreciationPeriod) {
            return 0;
        }
        
        // Calculate remaining value using straight-line depreciation
        $monthlyDepreciationRate = 1 / $totalDepreciationPeriod;
        $totalDepreciationPercentage = $monthsElapsed * $monthlyDepreciationRate;
        $remainingValue = $this->cost * (1 - $totalDepreciationPercentage);
        
        return max(0, $remainingValue);
    }

    public function getMonthsElapsedAttribute()
    {
        $purchaseDate = \Carbon\Carbon::parse($this->purchase_date);
        $now = \Carbon\Carbon::now();
        return $purchaseDate->diffInMonths($now);
    }

    public function turnoverHistory()
    {
        return $this->hasMany(AssetTurnoverHistory::class);
    }
}
