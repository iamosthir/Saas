<?php

namespace App\Models\Manufacturing;

use App\Models\Merchant;
use App\Models\Category;
use App\Models\Suppliers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RawMaterial extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'merchant_id',
        'category_id',
        'supplier_id',
        'unit_id',
        'name',
        'sku',
        'barcode',
        'description',
        'image',
        'current_stock',
        'min_stock_level',
        'purchase_price',
        'average_price',
        'is_active',
        'track_inventory',
    ];

    protected $casts = [
        'current_stock' => 'decimal:4',
        'min_stock_level' => 'decimal:4',
        'purchase_price' => 'decimal:2',
        'average_price' => 'decimal:4',
        'is_active' => 'boolean',
        'track_inventory' => 'boolean',
    ];

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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Suppliers::class, 'supplier_id');
    }

    public function unit()
    {
        return $this->belongsTo(UnitOfMeasure::class, 'unit_id');
    }

    public function movements()
    {
        return $this->hasMany(RawMaterialMovement::class);
    }

    public function costLayers()
    {
        return $this->hasMany(RawMaterialCost::class);
    }

    public function recipeIngredients()
    {
        return $this->hasMany(RecipeIngredient::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeLowStock($query)
    {
        return $query->whereColumn('current_stock', '<=', 'min_stock_level');
    }

    public function scopeForMerchant($query, int $merchantId)
    {
        return $query->where('merchant_id', $merchantId);
    }

    // Helpers
    public function isLowStock(): bool
    {
        return $this->current_stock <= $this->min_stock_level;
    }

    public function getStockValue(): float
    {
        return $this->current_stock * $this->average_price;
    }

    public function hasAvailableStock(float $quantity): bool
    {
        return $this->current_stock >= $quantity;
    }

    /**
     * Get stock with available cost layers (for FIFO)
     */
    public function getAvailableCostLayers()
    {
        return $this->costLayers()
            ->where('quantity', '>', 0)
            ->orderBy('received_date', 'asc')
            ->orderBy('id', 'asc')
            ->get();
    }

    /**
     * Get formatted stock display
     */
    public function getFormattedStock(): string
    {
        return number_format($this->current_stock, 2) . ' ' . ($this->unit->symbol ?? '');
    }
}
