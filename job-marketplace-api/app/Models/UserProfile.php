<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'profile_photo',
        'date_of_birth',
        'gender',
        'division_id',
        'district_id',
        'upazila_id',
        'present_address',
        'permanent_address',
    ];

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'date_of_birth' => 'date:Y-m-d',
            'division_id' => 'integer',
            'district_id' => 'integer',
            'upazila_id' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function upazila(): BelongsTo
    {
        return $this->belongsTo(Upazila::class);
    }
}