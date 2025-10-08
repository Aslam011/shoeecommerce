<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Customer extends Model implements Authenticatable, CanResetPasswordContract
{
    use HasFactory, Notifiable, AuthenticatableTrait, CanResetPassword;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'otp_code',
        'is_verified',
        'email_verified_at',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_verified' => 'boolean',
    ];

    public function addresses()
{
    return $this->hasMany(Address::class, 'customer_id');
}

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'customer_id');
    }
}
