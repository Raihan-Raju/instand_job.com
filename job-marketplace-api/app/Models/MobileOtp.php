<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileOtp extends Model
{
    use HasFactory;

    protected $fillable = [
        'mobile',
        'otp_hash',
        'purpose',
        'expires_at',
        'verified_at',
        'attempt_count',
        'last_attempt_at',
    ];

    protected $hidden = [
        'otp_hash',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'verified_at' => 'datetime',
            'last_attempt_at' => 'datetime',
            'attempt_count' => 'integer',
        ];
    }
}