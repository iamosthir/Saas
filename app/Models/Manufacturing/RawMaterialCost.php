<?php

namespace App\Models\Manufacturing;

use App\Models\Merchant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawMaterialCost extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'raw_material_id',
        'unit_cost',
        'quantity',
        'original_quantity',
        'received_date',
        'reference_type',
        'reference_id',
    ];

    protected $casts = [
        'unit_cost' => 'decimal:4',
        'quantity' => 'decimal:4',
        'original_quantity' => 'decimal:4',
        'received_date' => 'date',
    ];

    // Relationships
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class);
    }

    // Scopes
    public function scopeWithStock($query)
    {
        return $query->where('quantity', '>', 0)
            ->orderBy('received_date', 'asc')
            ->orderBy('id', 'asc');
    }

    public function scopeForMaterial($query, int $rawMaterialId)
    {
        return $query->where('raw_material_id', $rawMaterialId);
    }

    // Helpers
    public function hasStock(): bool
    {
        return $this->quantity > 0;
    }

    public function isFullyConsumed(): bool
    {
        return $this->quantity <= 0;
    }

    public function getTotalValue(): float
    {
        return $this->quantity * $this->unit_cost;
    }

    public function getConsumedQuantity(): float
    {
        return $this->original_quantity - $this->quantity;
    }

    /**
     * Consume a quantity from this cost layer
     * Returns the actual quantity consumed
     */
    public function consume(float $quantity): float
    {
        $consumed = min($quantity, $this->quantity);
        $this->quantity -= $consumed;
        $this->save();
        return $consumed;
    }
}
