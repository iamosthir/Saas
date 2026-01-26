<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'merchant_id',
        'full_name',
        'phone',
        'job_title',
        'monthly_salary',
        'status',
        'hire_date',
        'notes',
    ];

    protected $casts = [
        'monthly_salary' => 'decimal:2',
        'hire_date' => 'date',
    ];

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (auth()->check() && !$model->merchant_id) {
                $model->merchant_id = auth()->user()->merchant_id;
            }
        });
    }

    // Relationships
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', self::STATUS_INACTIVE);
    }

    public function scopeForMerchant($query, int $merchantId)
    {
        return $query->where('merchant_id', $merchantId);
    }

    // Helpers
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isInactive(): bool
    {
        return $this->status === self::STATUS_INACTIVE;
    }

    public function getStatusName(): string
    {
        return $this->status === self::STATUS_ACTIVE ? 'Active' : 'Inactive';
    }

    public function getStatusColor(): string
    {
        return $this->status === self::STATUS_ACTIVE ? 'success' : 'secondary';
    }

    public function getFormattedSalary(): string
    {
        return number_format($this->monthly_salary, 2);
    }

    /**
     * Get tenure in months
     */
    public function getTenureInMonths(): ?int
    {
        if (!$this->hire_date) {
            return null;
        }
        return $this->hire_date->diffInMonths(now());
    }

    /**
     * Get tenure formatted string
     */
    public function getFormattedTenure(): string
    {
        $months = $this->getTenureInMonths();
        if ($months === null) {
            return 'N/A';
        }

        $years = floor($months / 12);
        $remainingMonths = $months % 12;

        if ($years > 0 && $remainingMonths > 0) {
            return "{$years} year(s), {$remainingMonths} month(s)";
        } elseif ($years > 0) {
            return "{$years} year(s)";
        } else {
            return "{$remainingMonths} month(s)";
        }
    }
}
