<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'name',
        'email',
        'country_code',
        'mobile',
        'password',
        'location',
        'otp',
        'email_verified',
        'role',
        'status',
        'logged_in',
    ];

    /**
     * Hidden attributes
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'email_verified' => 'boolean',
        'logged_in'      => 'boolean',
        'password'       => 'hashed',
    ];
}
