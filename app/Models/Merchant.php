<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'phone_primary',
        'phone_secondary',
        'logo',
        'address1',
        'address2',
        'city',
        'zip_code',
        'subscription_start_date',
        'subscription_end_date',
        'is_active',
        'subscription_plan_id',
    ];

    protected $casts = [
        'subscription_start_date' => 'datetime',
        'subscription_end_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlans::class, 'subscription_plan_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function isSubscriptionExpired()
    {
        if (!$this->subscription_end_date) {
            return false;
        }
        return now()->greaterThan($this->subscription_end_date);
    }
}
