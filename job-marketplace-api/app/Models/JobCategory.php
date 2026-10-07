<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'parent_id',
        'sort_order',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'parent_id' => 'integer',
            'sort_order' => 'integer',
            'status' => 'boolean',
        ];
    }

    /**
     * Parent Category
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(
            JobCategory::class,
            'parent_id'
        );
    }

    /**
     * Child Categories
     */
    public function children(): HasMany
    {
        return $this->hasMany(
            JobCategory::class,
            'parent_id'
        )->orderBy('sort_order')
         ->orderBy('name');
    }

    /**
     * Worker Categories
     */
    public function workerCategories(): HasMany
    {
        return $this->hasMany(
            WorkerCategory::class,
            'job_category_id'
        );
    }

    /**
     * Job Seekers registered under this category
     */
    public function jobSeekers(): BelongsToMany
    {
        return $this->belongsToMany(
            JobSeekerProfile::class,
            'worker_categories',
            'job_category_id',
            'job_seeker_profile_id'
        )->withTimestamps();
    }

    /**
     * Marketplace Jobs under this category
     */
    public function marketplaceJobs(): HasMany
    {
        return $this->hasMany(
            MarketplaceJob::class,
            'job_category_id'
        );
    }
}