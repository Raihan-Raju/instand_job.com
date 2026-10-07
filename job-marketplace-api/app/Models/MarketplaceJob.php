<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketplaceJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'hirer_id',
        'job_category_id',
        'title',
        'description',
        'job_type',
        'rate_type',
        'rate_amount',
        'workers_required',
        'hire_mode',
        'search_mode',
        'latitude',
        'longitude',
        'search_radius_km',
        'location_address',
        'scheduled_at',
        'status',
        'started_at',
        'completed_at',
        'worked_minutes',
        'cancelled_at',
        'cancellation_reason',
    ];

    protected function casts(): array
    {
        return [
            'rate_amount' => 'decimal:2',
            'workers_required' => 'integer',

            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'search_radius_km' => 'decimal:2',

            'scheduled_at' => 'datetime',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
            'cancelled_at' => 'datetime',

            'worked_minutes' => 'integer',
        ];
    }

    /**
     * User who created the job in Job Hire mode.
     */
    public function hirer()
    {
        return $this->belongsTo(User::class, 'hirer_id');
    }

    /**
     * Category selected for this job.
     */
    public function category()
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id');
    }
}