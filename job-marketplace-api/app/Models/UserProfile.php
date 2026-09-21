<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'profile_photo',
        'date_of_birth',
        'gender',
        'present_address',
        'permanent_address',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'gender' => 'integer',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}