<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
            'sort_order' => 'integer',
        ];
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
            'skill_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Job Seekers
    |--------------------------------------------------------------------------
    */

    public function jobSeekers(): BelongsToMany
    {
        return $this->belongsToMany(
            JobSeekerProfile::class,
            'worker_skills',
            'skill_id',
            'job_seeker_profile_id'
        )->withTimestamps();
    }
}