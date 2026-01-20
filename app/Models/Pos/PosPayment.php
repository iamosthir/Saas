<?php

namespace App\Models\Pos;

use App\Models\Merchant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'pos_sale_id',
        'payment_method',
        'amount',
        'tendered_amount',
        'change_given',
        'reference_number',
        'metadata',
        'processed_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'tendered_amount' => 'decimal:2',
        'change_given' => 'decimal:2',
        'metadata' => 'array',
    ];

    /**
     * Boot method for auto-filling merchant_id
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (auth()->check() && !$model->merchant_id) {
                $model->merchant_id = auth()->user()->merchant_id;
            }
            if (auth()->check() && !$model->processed_by) {
                $model->processed_by = auth()->id();
            }
        });
    }

    // Relationships

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function sale()
    {
        return $this->belongsTo(PosSale::class, 'pos_sale_id');
    }

    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    // Helper methods

    public function isCash(): bool
    {
        return $this->payment_method === 'cash';
    }

    public function isCard(): bool
    {
        return $this->payment_method === 'card';
    }

    public function isWallet(): bool
    {
        return $this->payment_method === 'wallet';
    }

    public function isBankTransfer(): bool
    {
        return $this->payment_method === 'bank_transfer';
    }

    /**
     * Get payment method display name
     */
    public function getMethodName(): string
    {
        $names = [
            'cash' => 'Cash',
            'card' => 'Card',
            'wallet' => 'Wallet',
            'bank_transfer' => 'Bank Transfer',
            'other' => 'Other',
        ];

        return $names[$this->payment_method] ?? $this->payment_method;
    }
}
