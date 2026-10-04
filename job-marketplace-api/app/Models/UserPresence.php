<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPresence extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'is_online',
        'last_seen_at',
        'last_activity_at',
    ];

    protected function casts(): array
    {
        return [
            'is_online' => 'boolean',
            'last_seen_at' => 'datetime',
            'last_activity_at' => 'datetime',
        ];
    }

    /**
     * Presence owner.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}