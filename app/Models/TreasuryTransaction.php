<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreasuryTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'type',
        'category',
        'amount',
        'description',
        'transactionable_id',
        'transactionable_type',
        'transaction_date',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_date' => 'date',
    ];

    // Relationships
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function transactionable()
    {
        return $this->morphTo();
    }

    // Scopes
    public function scopeIncome($query)
    {
        return $query->where('type', 'income');
    }

    public function scopeExpense($query)
    {
        return $query->where('type', 'expense');
    }

    public function scopeForMonth($query, $year, $month)
    {
        return $query->whereYear('transaction_date', $year)
                     ->whereMonth('transaction_date', $month);
    }

    public function scopeForYear($query, $year)
    {
        return $query->whereYear('transaction_date', $year);
    }

    // Boot method to auto-set merchant_id
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            if (!$transaction->merchant_id && auth()->check()) {
                $transaction->merchant_id = auth()->user()->merchant_id;
            }
        });
    }
}
