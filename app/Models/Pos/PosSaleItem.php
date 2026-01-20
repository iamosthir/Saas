<?php

namespace App\Models\Pos;

use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosSaleItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'pos_sale_id',
        'product_id',
        'product_variation_id',
        'product_name',
        'variation_name',
        'sku',
        'barcode',
        'quantity',
        'unit_price',
        'unit_cost',
        'discount_type',
        'discount_amount',
        'discount_value',
        'line_total',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'unit_cost' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'discount_value' => 'decimal:2',
        'line_total' => 'decimal:2',
    ];

    // Relationships

    public function sale()
    {
        return $this->belongsTo(PosSale::class, 'pos_sale_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productVariation()
    {
        return $this->belongsTo(ProductVariation::class);
    }

    // Helper methods

    /**
     * Calculate the line total based on quantity, price, and discount
     */
    public function calculateLineTotal(): float
    {
        $subtotal = $this->quantity * $this->unit_price;

        if ($this->discount_type && $this->discount_amount > 0) {
            if ($this->discount_type === 'percentage') {
                $this->discount_value = ($subtotal * $this->discount_amount) / 100;
            } else {
                $this->discount_value = $this->discount_amount;
            }
        } else {
            $this->discount_value = 0;
        }

        return $subtotal - $this->discount_value;
    }

    /**
     * Get profit for this line item
     */
    public function getProfit(): float
    {
        return $this->line_total - ($this->unit_cost * $this->quantity);
    }
}
