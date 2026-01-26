<?php

namespace App\Models\Manufacturing;

use App\Models\Merchant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitOfMeasure extends Model
{
    use HasFactory;

    protected $table = 'units_of_measure';

    protected $fillable = [
        'merchant_id',
        'name',
        'symbol',
        'category',
        'conversion_factor',
        'is_base_unit',
        'is_active',
    ];

    protected $casts = [
        'conversion_factor' => 'decimal:6',
        'is_base_unit' => 'boolean',
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

    public function rawMaterials()
    {
        return $this->hasMany(RawMaterial::class, 'unit_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    // Helpers

    /**
     * Convert quantity from this unit to base unit
     */
    public function toBaseUnit(float $quantity): float
    {
        return $quantity * $this->conversion_factor;
    }

    /**
     * Convert quantity from base unit to this unit
     */
    public function fromBaseUnit(float $quantity): float
    {
        return $this->conversion_factor > 0 ? $quantity / $this->conversion_factor : 0;
    }

    /**
     * Convert quantity from this unit to another unit
     */
    public function convertTo(float $quantity, UnitOfMeasure $targetUnit): float
    {
        if ($this->category !== $targetUnit->category) {
            throw new \InvalidArgumentException('Cannot convert between different unit categories');
        }

        $baseQuantity = $this->toBaseUnit($quantity);
        return $targetUnit->fromBaseUnit($baseQuantity);
    }

    /**
     * Get base unit for a category
     */
    public static function getBaseUnitForCategory(int $merchantId, string $category): ?self
    {
        return static::where('merchant_id', $merchantId)
            ->where('category', $category)
            ->where('is_base_unit', true)
            ->first();
    }

    /**
     * Get all units for a category
     */
    public static function getUnitsForCategory(int $merchantId, string $category)
    {
        return static::where('merchant_id', $merchantId)
            ->where('category', $category)
            ->active()
            ->orderBy('is_base_unit', 'desc')
            ->orderBy('name')
            ->get();
    }
}
