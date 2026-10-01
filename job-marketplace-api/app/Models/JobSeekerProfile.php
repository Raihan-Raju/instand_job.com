<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobSeekerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'professional_title',
        'about',
        'experience_years',
        'hourly_rate',
        'daily_rate',
        'is_available',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'experience_years' => 'integer',
            'hourly_rate' => 'decimal:2',
            'daily_rate' => 'decimal:2',
            'is_available' => 'boolean',
            'status' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | User
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Worker Categories
    |--------------------------------------------------------------------------
    */

    public function workerCategories(): HasMany
    {
        return $this->hasMany(
            WorkerCategory::class,
            'job_seeker_profile_id'
        );
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            JobCategory::class,
            'worker_categories',
            'job_seeker_profile_id',
            'job_category_id'
        )->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | Worker Skills
    |--------------------------------------------------------------------------
    */

    public function workerSkills(): HasMany
    {
        return $this->hasMany(
            WorkerSkill::class,
            'job_seeker_profile_id'
        );
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(
            Skill::class,
            'worker_skills',
            'job_seeker_profile_id',
            'skill_id'
        )->withTimestamps();
    }
}