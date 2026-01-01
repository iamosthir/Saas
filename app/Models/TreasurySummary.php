<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreasurySummary extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'year',
        'month',
        'opening_balance',
        'total_income',
        'total_expense',
        'closing_balance',
    ];

    protected $casts = [
        'year' => 'integer',
        'month' => 'integer',
        'opening_balance' => 'decimal:2',
        'total_income' => 'decimal:2',
        'total_expense' => 'decimal:2',
        'closing_balance' => 'decimal:2',
    ];

    // Relationships
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    // Methods
    public function calculateBalance()
    {
        $this->closing_balance = $this->opening_balance + $this->total_income - $this->total_expense;
        return $this->closing_balance;
    }

    public function getMonthlyReport()
    {
        return [
            'period' => "{$this->year}-{$this->month}",
            'opening_balance' => $this->opening_balance,
            'total_income' => $this->total_income,
            'total_expense' => $this->total_expense,
            'closing_balance' => $this->closing_balance,
            'net_change' => $this->total_income - $this->total_expense,
        ];
    }
}
