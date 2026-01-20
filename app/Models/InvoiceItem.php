<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'product_id',
        'product_variation_id',
        'product_name',
        'variation_name',
        'quantity',
        'original_price',
        'custom_price',
        'unit_cost',
        'line_total',
        'custom_fields',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'original_price' => 'decimal:2',
        'custom_price' => 'decimal:2',
        'unit_cost' => 'decimal:2',
        'line_total' => 'decimal:2',
        'custom_fields' => 'array',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productVariation()
    {
        return $this->belongsTo(ProductVariation::class);
    }
}
