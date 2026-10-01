<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkerSkill extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_seeker_profile_id',
        'skill_id',
    ];

    public function jobSeekerProfile(): BelongsTo
    {
        return $this->belongsTo(
            JobSeekerProfile::class,
            'job_seeker_profile_id'
        );
    }

    public function skill(): BelongsTo
    {
        return $this->belongsTo(
            Skill::class,
            'skill_id'
        );
    }
}