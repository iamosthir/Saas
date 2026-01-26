<?php

namespace App\Models\Manufacturing;

use App\Models\Merchant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawMaterialMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'raw_material_id',
        'movement_type',
        'quantity',
        'quantity_before',
        'quantity_after',
        'unit_cost',
        'reference_type',
        'reference_id',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'quantity_before' => 'decimal:4',
        'quantity_after' => 'decimal:4',
        'unit_cost' => 'decimal:4',
    ];

    const TYPE_PURCHASE = 'purchase';
    const TYPE_PRODUCTION = 'production';
    const TYPE_ADJUSTMENT = 'adjustment';
    const TYPE_WASTE = 'waste';
    const TYPE_TRANSFER = 'transfer';

    // Relationships
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the reference model (polymorphic)
     */
    public function reference()
    {
        if (!$this->reference_type || !$this->reference_id) {
            return null;
        }

        $modelMap = [
            'production_batches' => ProductionBatch::class,
            // Add more reference types as needed
        ];

        $modelClass = $modelMap[$this->reference_type] ?? null;
        if ($modelClass) {
            return $modelClass::find($this->reference_id);
        }

        return null;
    }

    // Scopes
    public function scopePurchases($query)
    {
        return $query->where('movement_type', self::TYPE_PURCHASE);
    }

    public function scopeProduction($query)
    {
        return $query->where('movement_type', self::TYPE_PRODUCTION);
    }

    public function scopeAdjustments($query)
    {
        return $query->where('movement_type', self::TYPE_ADJUSTMENT);
    }

    public function scopeForMaterial($query, int $rawMaterialId)
    {
        return $query->where('raw_material_id', $rawMaterialId);
    }

    // Helpers
    public function isDeduction(): bool
    {
        return $this->quantity < 0;
    }

    public function isAddition(): bool
    {
        return $this->quantity > 0;
    }

    public function getTypeName(): string
    {
        $names = [
            self::TYPE_PURCHASE => 'Purchase',
            self::TYPE_PRODUCTION => 'Production',
            self::TYPE_ADJUSTMENT => 'Adjustment',
            self::TYPE_WASTE => 'Waste',
            self::TYPE_TRANSFER => 'Transfer',
        ];

        return $names[$this->movement_type] ?? $this->movement_type;
    }

    public function getTypeColor(): string
    {
        $colors = [
            self::TYPE_PURCHASE => 'success',
            self::TYPE_PRODUCTION => 'info',
            self::TYPE_ADJUSTMENT => 'warning',
            self::TYPE_WASTE => 'danger',
            self::TYPE_TRANSFER => 'primary',
        ];

        return $colors[$this->movement_type] ?? 'secondary';
    }
}
