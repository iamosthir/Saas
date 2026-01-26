<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionBatchIngredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_id',
        'raw_material_id',
        'unit_id',
        'required_quantity',
        'actual_quantity',
        'unit_cost',
        'total_cost',
    ];

    protected $casts = [
        'required_quantity' => 'decimal:4',
        'actual_quantity' => 'decimal:4',
        'unit_cost' => 'decimal:4',
        'total_cost' => 'decimal:2',
    ];

    // Relationships
    public function batch()
    {
        return $this->belongsTo(ProductionBatch::class, 'batch_id');
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
     * Get required quantity in base unit
     */
    public function getRequiredQuantityInBaseUnit(): float
    {
        return $this->unit->toBaseUnit($this->required_quantity);
    }

    /**
     * Get actual quantity in base unit
     */
    public function getActualQuantityInBaseUnit(): float
    {
        if ($this->actual_quantity === null) {
            return $this->getRequiredQuantityInBaseUnit();
        }
        return $this->unit->toBaseUnit($this->actual_quantity);
    }

    /**
     * Calculate variance between required and actual
     */
    public function getVariance(): float
    {
        if ($this->actual_quantity === null) {
            return 0;
        }
        return $this->actual_quantity - $this->required_quantity;
    }

    /**
     * Get variance percentage
     */
    public function getVariancePercentage(): float
    {
        if ($this->required_quantity == 0) {
            return 0;
        }
        return ($this->getVariance() / $this->required_quantity) * 100;
    }

    /**
     * Check if actual usage exceeds required
     */
    public function hasOverage(): bool
    {
        return $this->getVariance() > 0;
    }

    /**
     * Check if actual usage is less than required
     */
    public function hasSavings(): bool
    {
        return $this->getVariance() < 0;
    }
}
