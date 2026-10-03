<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'mobile',
        'password',
        'mobile_verified_at',
        'status',
        'user_type',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'mobile_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'status' => 'integer',
        ];
    }

    /**
     * Common User Profile
     */
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * NID / KYC Verification
     */
    public function verification()
    {
        return $this->hasOne(UserVerification::class);
    }

    /**
     * Job Seeker Profile
     */
    public function jobSeekerProfile()
    {
        return $this->hasOne(JobSeekerProfile::class);
    }

    /**
     * Job Hire / Employer Profile
     */
    public function employerProfile()
    {
        return $this->hasOne(EmployerProfile::class);
    }
}