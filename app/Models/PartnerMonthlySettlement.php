<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerMonthlySettlement extends Model
{
    use HasFactory;

    protected $fillable = [
        'partner_id',
        'period_year',
        'period_month',
        'net_profit',
        'partner_percent',
        'partner_amount',
        'status',
        'generated_at',
        'paid_at',
        'notes',
    ];

    protected $casts = [
        'net_profit' => 'decimal:2',
        'partner_percent' => 'decimal:2',
        'partner_amount' => 'decimal:2',
        'period_year' => 'integer',
        'period_month' => 'integer',
        'generated_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    /**
     * Get the partner that owns the settlement.
     */
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    /**
     * Get formatted period (e.g., "2025-12").
     */
    public function getFormattedPeriodAttribute()
    {
        return sprintf('%04d-%02d', $this->period_year, $this->period_month);
    }

    /**
     * Get formatted month name.
     */
    public function getMonthNameAttribute()
    {
        return date('F', mktime(0, 0, 0, $this->period_month, 1));
    }

    /**
     * Get formatted partner amount with currency.
     */
    public function getFormattedPartnerAmountAttribute()
    {
        return number_format($this->partner_amount, 2);
    }

    /**
     * Get formatted net profit with currency.
     */
    public function getFormattedNetProfitAttribute()
    {
        return number_format($this->net_profit, 2);
    }

    /**
     * Scope for pending settlements.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for paid settlements.
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * Mark settlement as paid.
     */
    public function markAsPaid()
    {
        $this->status = 'paid';
        $this->paid_at = now();
        $this->save();
    }

    /**
     * Check if settlement is paid.
     */
    public function isPaid()
    {
        return $this->status === 'paid';
    }
}
