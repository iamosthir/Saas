<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'supplier_id',
        'category_id',
        'name',
        'model_name',
        'description',
        'image',
        'thumbnail',
        'default_price',
        'purchase_price',
        'sell_price',
        'cash_price',
        'installment_price',
        'discount_type',
        'discount_amount',
        'total_stock',
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'sell_price' => 'decimal:2',
        'cash_price' => 'decimal:2',
        'installment_price' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_stock' => 'integer',
    ];

    public function variation()
    {
        return $this->hasMany(ProductVariation::class, "product_id", "id");
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    /**
     * Get price based on payment type
     */
    public function getPriceForPaymentType($paymentType)
    {
        return $paymentType === 'full_payment' ? $this->cash_price : $this->installment_price;
    }
}
