<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'profit_percent',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'profit_percent' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get all monthly settlements for this partner.
     */
    public function monthlySettlements()
    {
        return $this->hasMany(PartnerMonthlySettlement::class);
    }

    /**
     * Get only active partners.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Format profit percent as percentage.
     */
    public function getFormattedProfitPercentAttribute()
    {
        return $this->profit_percent . '%';
    }

    /**
     * Get total amount paid to this partner.
     */
    public function getTotalPaidAttribute()
    {
        return $this->monthlySettlements()
            ->where('status', 'paid')
            ->sum('partner_amount');
    }

    /**
     * Get total amount pending for this partner.
     */
    public function getTotalPendingAttribute()
    {
        return $this->monthlySettlements()
            ->where('status', 'pending')
            ->sum('partner_amount');
    }
}
