<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'marketplace_job_id',
        'worker_id',
        'status',
        'request_type',
        'requested_at',
        'responded_at',
        'expires_at',
        'accepted_at',
        'rejected_at',
        'started_at',
        'completed_at',
        'rejection_reason',
        'cancellation_reason',
    ];

    protected $casts = [
        'requested_at' => 'datetime',
        'responded_at' => 'datetime',
        'expires_at' => 'datetime',
        'accepted_at' => 'datetime',
        'rejected_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function marketplaceJob(): BelongsTo
    {
        return $this->belongsTo(MarketplaceJob::class);
    }

    public function worker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'worker_id');
    }
}
