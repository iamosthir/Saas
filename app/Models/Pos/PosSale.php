<?php

namespace App\Models\Pos;

use App\Models\Customer;
use App\Models\Merchant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PosSale extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'merchant_id',
        'customer_id',
        'sale_number',
        'status',
        'subtotal',
        'discount_type',
        'discount_amount',
        'discount_value',
        'tax_rate',
        'tax_amount',
        'total_amount',
        'paid_amount',
        'change_amount',
        'park_name',
        'notes',
        'offline_id',
        'synced',
        'created_by',
        'completed_by',
        'completed_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'discount_value' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'change_amount' => 'decimal:2',
        'synced' => 'boolean',
        'completed_at' => 'datetime',
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
            if (auth()->check() && !$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
    }

    /**
     * Generate unique sale number
     */
    public static function generateSaleNumber($merchantId): string
    {
        $lastSale = self::where('merchant_id', $merchantId)
            ->orderBy('id', 'desc')
            ->first();

        $lastNumber = $lastSale ? intval(substr($lastSale->sale_number, 4)) : 0;
        return 'POS-' . str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
    }

    // Relationships

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(PosSaleItem::class);
    }

    public function payments()
    {
        return $this->hasMany(PosPayment::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function completedBy()
    {
        return $this->belongsTo(User::class, 'completed_by');
    }

    // Scopes

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeParked($query)
    {
        return $query->where('status', 'parked');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeVoided($query)
    {
        return $query->where('status', 'voided');
    }

    public function scopeUnsynced($query)
    {
        return $query->where('synced', false);
    }

    // Helper methods

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isParked(): bool
    {
        return $this->status === 'parked';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isVoided(): bool
    {
        return $this->status === 'voided';
    }

    public function canBeModified(): bool
    {
        return in_array($this->status, ['draft', 'parked']);
    }
}
