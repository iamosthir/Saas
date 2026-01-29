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
        'can_access_pos',
        'can_access_contracts',
        'can_access_manufacturing',
        'subscription_plan_id',
        'currency',
    ];

    protected $casts = [
        'subscription_start_date' => 'datetime',
        'subscription_end_date' => 'datetime',
        'is_active' => 'boolean',
        'can_access_pos' => 'boolean',
        'can_access_contracts' => 'boolean',
        'can_access_manufacturing' => 'boolean',
    ];

    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlans::class, 'subscription_plan_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function invoiceTemplates()
    {
        return $this->hasMany(InvoiceTemplate::class);
    }

    public function isSubscriptionExpired()
    {
        if (!$this->subscription_end_date) {
            return false;
        }
        return now()->greaterThan($this->subscription_end_date);
    }

    /**
     * Check if merchant can access POS system.
     */
    public function canAccessPos(): bool
    {
        return $this->can_access_pos ?? false;
    }

    /**
     * Check if merchant can access Contract Management.
     */
    public function canAccessContracts(): bool
    {
        return $this->can_access_contracts ?? false;
    }

    /**
     * Check if merchant can access Manufacturing system.
     */
    public function canAccessManufacturing(): bool
    {
        return $this->can_access_manufacturing ?? false;
    }
}
