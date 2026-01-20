<?php

namespace App\Models\Pos;

use App\Models\Merchant;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosInventoryCost extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'product_id',
        'product_variation_id',
        'unit_cost',
        'quantity',
        'original_quantity',
        'received_date',
        'reference_type',
        'reference_id',
    ];

    protected $casts = [
        'unit_cost' => 'decimal:2',
        'quantity' => 'integer',
        'original_quantity' => 'integer',
        'received_date' => 'date',
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

    /**
     * Get cost layers with remaining quantity, ordered by FIFO (oldest first)
     */
    public function scopeWithStock($query)
    {
        return $query->where('quantity', '>', 0)
            ->orderBy('received_date', 'asc')
            ->orderBy('id', 'asc');
    }

    /**
     * Filter by product
     */
    public function scopeForProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    /**
     * Filter by product variation
     */
    public function scopeForVariation($query, $variationId)
    {
        return $query->where('product_variation_id', $variationId);
    }

    // Helper methods

    public function hasStock(): bool
    {
        return $this->quantity > 0;
    }

    public function isFullyConsumed(): bool
    {
        return $this->quantity <= 0;
    }

    /**
     * Get total value of remaining inventory at this cost
     */
    public function getTotalValue(): float
    {
        return $this->quantity * $this->unit_cost;
    }
}
