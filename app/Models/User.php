<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Contracts\Auth\Access\Authorizable;

class User extends Authenticatable implements Authorizable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'merchant_id',
        'role',
        'currency'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function orders()
    {
        return $this->hasMany(Order::class,"admin_id","id");
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    /**
     * Check if user has pos_only role
     */
    public function isPosOnly(): bool
    {
        return $this->role === 'pos_only';
    }

    /**
     * Check if user has super role
     */
    public function isSuper(): bool
    {
        return $this->role === 'super';
    }

    /**
     * Check if user has staff role
     */
    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }
}
