<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeIngredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipe_id',
        'raw_material_id',
        'unit_id',
        'quantity',
        'waste_percentage',
        'sort_order',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'waste_percentage' => 'decimal:2',
    ];

    // Relationships
    public function recipe()
    {
        return $this->belongsTo(ProductRecipe::class, 'recipe_id');
    }

    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class);
    }

    public function unit()
    {
        return $this->belongsTo(UnitOfMeasure::class, 'unit_id');
    }

    // Helpers

    /**
     * Get quantity converted to raw material's base unit
     */
    public function getQuantityInBaseUnit(): float
    {
        $quantityInRecipeUnit = $this->quantity;
        $quantityInBase = $this->unit->toBaseUnit($quantityInRecipeUnit);

        // Apply waste percentage
        $wasteMultiplier = 1 + ($this->waste_percentage / 100);
        return $quantityInBase * $wasteMultiplier;
    }

    /**
     * Get the effective quantity including waste
     */
    public function getEffectiveQuantity(): float
    {
        $wasteMultiplier = 1 + ($this->waste_percentage / 100);
        return $this->quantity * $wasteMultiplier;
    }

    /**
     * Calculate cost for this ingredient
     */
    public function calculateCost(): float
    {
        $quantityInBase = $this->getQuantityInBaseUnit();
        return $quantityInBase * $this->rawMaterial->average_price;
    }

    /**
     * Check if raw material has sufficient stock
     */
    public function hasSufficientStock(float $multiplier = 1): bool
    {
        $requiredQty = $this->getQuantityInBaseUnit() * $multiplier;
        return $this->rawMaterial->current_stock >= $requiredQty;
    }

    /**
     * Get shortage amount (0 if sufficient stock)
     */
    public function getShortage(float $multiplier = 1): float
    {
        $requiredQty = $this->getQuantityInBaseUnit() * $multiplier;
        $available = $this->rawMaterial->current_stock;
        return max(0, $requiredQty - $available);
    }
}
