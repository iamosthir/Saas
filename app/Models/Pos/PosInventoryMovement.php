<?php

namespace App\Models\Pos;

use App\Models\Merchant;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosInventoryMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'product_id',
        'product_variation_id',
        'movement_type',
        'quantity',
        'quantity_before',
        'quantity_after',
        'unit_cost',
        'reference_type',
        'reference_id',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'quantity_before' => 'integer',
        'quantity_after' => 'integer',
        'unit_cost' => 'decimal:2',
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

    // Relationships

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productVariation()
    {
        return $this->belongsTo(ProductVariation::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the reference model (polymorphic)
     */
    public function reference()
    {
        if ($this->reference_type && $this->reference_id) {
            return $this->morphTo('reference', 'reference_type', 'reference_id');
        }
        return null;
    }

    // Scopes

    public function scopeSales($query)
    {
        return $query->where('movement_type', 'sale');
    }

    public function scopeAdjustments($query)
    {
        return $query->where('movement_type', 'adjustment');
    }

    public function scopePurchases($query)
    {
        return $query->where('movement_type', 'purchase');
    }

    // Helper methods

    public function isDeduction(): bool
    {
        return $this->quantity < 0;
    }

    public function isAddition(): bool
    {
        return $this->quantity > 0;
    }

    /**
     * Get movement type display name
     */
    public function getTypeName(): string
    {
        $names = [
            'sale' => 'Sale',
            'adjustment' => 'Adjustment',
            'purchase' => 'Purchase',
            'transfer' => 'Transfer',
            'void' => 'Void',
        ];

        return $names[$this->movement_type] ?? $this->movement_type;
    }
}
