<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkerCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_seeker_profile_id',
        'job_category_id',
    ];

    public function jobSeekerProfile(): BelongsTo
    {
        return $this->belongsTo(
            JobSeekerProfile::class,
            'job_seeker_profile_id'
        );
    }

    public function jobCategory(): BelongsTo
    {
        return $this->belongsTo(
            JobCategory::class,
            'job_category_id'
        );
    }
}