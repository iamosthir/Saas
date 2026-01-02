<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'product_id',
        'var_name',
        'attribute_values',
        'quantity',
        'price',
        'installment_price',
        'purchase_price',
        'average_price',
    ];

    protected $casts = [
        'attribute_values' => 'array',
        'price' => 'decimal:2',
        'installment_price' => 'decimal:2',
        'purchase_price' => 'decimal:2',
        'average_price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get price based on payment type
     */
    public function getPriceForPaymentType($paymentType)
    {
        return $paymentType === 'full_payment' ? $this->price : $this->installment_price;
    }
}
