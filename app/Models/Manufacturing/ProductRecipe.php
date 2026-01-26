<?php

namespace App\Models\Manufacturing;

use App\Models\Merchant;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRecipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'product_id',
        'product_variation_id',
        'name',
        'output_quantity',
        'labor_cost',
        'overhead_cost',
        'instructions',
        'prep_time_minutes',
        'is_active',
    ];

    protected $casts = [
        'output_quantity' => 'decimal:4',
        'labor_cost' => 'decimal:2',
        'overhead_cost' => 'decimal:2',
        'is_active' => 'boolean',
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

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productVariation()
    {
        return $this->belongsTo(ProductVariation::class);
    }

    public function ingredients()
    {
        return $this->hasMany(RecipeIngredient::class, 'recipe_id')->orderBy('sort_order');
    }

    public function productionBatches()
    {
        return $this->hasMany(ProductionBatch::class, 'recipe_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForProduct($query, int $productId, ?int $variationId = null)
    {
        $query->where('product_id', $productId);

        if ($variationId) {
            $query->where('product_variation_id', $variationId);
        }

        return $query;
    }

    // Helpers

    /**
     * Calculate total material cost for one batch (using current material prices)
     */
    public function calculateMaterialCost(): float
    {
        $cost = 0;
        foreach ($this->ingredients as $ingredient) {
            $material = $ingredient->rawMaterial;
            $quantityInBase = $ingredient->getQuantityInBaseUnit();
            $cost += $quantityInBase * $material->average_price;
        }
        return $cost;
    }

    /**
     * Calculate total cost including labor and overhead
     */
    public function calculateTotalCost(): float
    {
        return $this->calculateMaterialCost() + $this->labor_cost + $this->overhead_cost;
    }

    /**
     * Calculate unit cost per output item
     */
    public function calculateUnitCost(): float
    {
        $totalCost = $this->calculateTotalCost();
        return $this->output_quantity > 0 ? $totalCost / $this->output_quantity : 0;
    }

    /**
     * Check if all ingredients have sufficient stock for given multiplier
     */
    public function canProduce(float $multiplier = 1): bool
    {
        foreach ($this->ingredients as $ingredient) {
            $requiredQty = $ingredient->getQuantityInBaseUnit() * $multiplier;
            if ($ingredient->rawMaterial->current_stock < $requiredQty) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get maximum producible batches based on current stock
     */
    public function getMaxProducibleBatches(): float
    {
        $maxBatches = PHP_FLOAT_MAX;

        foreach ($this->ingredients as $ingredient) {
            $requiredQty = $ingredient->getQuantityInBaseUnit();
            if ($requiredQty > 0) {
                $availableStock = $ingredient->rawMaterial->current_stock;
                $possibleBatches = $availableStock / $requiredQty;
                $maxBatches = min($maxBatches, $possibleBatches);
            }
        }

        return $maxBatches === PHP_FLOAT_MAX ? 0 : floor($maxBatches);
    }

    /**
     * Get ingredient availability details
     */
    public function getIngredientAvailability(float $multiplier = 1): array
    {
        $availability = [];

        foreach ($this->ingredients as $ingredient) {
            $requiredQty = $ingredient->getQuantityInBaseUnit() * $multiplier;
            $availableQty = $ingredient->rawMaterial->current_stock;
            $sufficient = $availableQty >= $requiredQty;

            $availability[] = [
                'raw_material_id' => $ingredient->raw_material_id,
                'name' => $ingredient->rawMaterial->name,
                'unit' => $ingredient->rawMaterial->unit->symbol ?? '',
                'required' => round($requiredQty, 4),
                'available' => round($availableQty, 4),
                'sufficient' => $sufficient,
                'shortage' => $sufficient ? 0 : round($requiredQty - $availableQty, 4),
            ];
        }

        return $availability;
    }

    /**
     * Get the product name (with variation if applicable)
     */
    public function getProductName(): string
    {
        $name = $this->product->name ?? '';
        if ($this->productVariation) {
            $name .= ' - ' . $this->productVariation->var_name;
        }
        return $name;
    }
}
