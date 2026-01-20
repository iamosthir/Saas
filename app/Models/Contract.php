<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'merchant_id',
        'contract_template_id',
        'contract_number',
        'title',
        'description',
        'custom_fields',
        'footer_text',
        'status',
        'start_date',
        'end_date',
        'created_by',
        'signed_at',
    ];

    protected $casts = [
        'custom_fields' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'signed_at' => 'datetime',
    ];

    /**
     * Boot method for auto-generating contract number
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($contract) {
            if (!$contract->contract_number) {
                $contract->contract_number = static::generateContractNumber($contract->merchant_id);
            }
        });
    }

    /**
     * Generate unique contract number
     */
    public static function generateContractNumber($merchantId)
    {
        $prefix = 'CON';
        $year = date('Y');
        $month = date('m');

        $lastContract = static::where('merchant_id', $merchantId)
            ->where('contract_number', 'LIKE', "{$prefix}-{$year}{$month}-%")
            ->orderBy('id', 'desc')
            ->first();

        if ($lastContract) {
            $lastNumber = intval(substr($lastContract->contract_number, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return "{$prefix}-{$year}{$month}-{$newNumber}";
    }

    /**
     * Get the merchant that owns the contract.
     */
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    /**
     * Get the template this contract was created from.
     */
    public function template()
    {
        return $this->belongsTo(ContractTemplate::class, 'contract_template_id');
    }

    /**
     * Get the user who created the contract.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope a query to only include contracts for a specific merchant.
     */
    public function scopeForMerchant($query, $merchantId)
    {
        return $query->where('merchant_id', $merchantId);
    }
}
