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
        'discount_type',
        'discount_amount',
        'total_stock',
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'sell_price' => 'decimal:2',
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
}
