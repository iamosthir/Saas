<?php

namespace App\Models\Manufacturing;

use App\Models\Merchant;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionBatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'recipe_id',
        'product_id',
        'product_variation_id',
        'batch_number',
        'planned_quantity',
        'actual_quantity',
        'material_cost',
        'labor_cost',
        'overhead_cost',
        'total_cost',
        'unit_cost',
        'status',
        'production_date',
        'expiry_date',
        'notes',
        'created_by',
        'completed_by',
        'completed_at',
    ];

    protected $casts = [
        'planned_quantity' => 'decimal:4',
        'actual_quantity' => 'decimal:4',
        'material_cost' => 'decimal:2',
        'labor_cost' => 'decimal:2',
        'overhead_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'unit_cost' => 'decimal:4',
        'production_date' => 'date',
        'expiry_date' => 'date',
        'completed_at' => 'datetime',
    ];

    const STATUS_DRAFT = 'draft';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->batch_number) {
                $model->batch_number = static::generateBatchNumber($model->merchant_id);
            }
            if (auth()->check()) {
                $model->created_by = $model->created_by ?? auth()->id();
                $model->merchant_id = $model->merchant_id ?? auth()->user()->merchant_id;
            }
        });
    }

    // Relationships
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function recipe()
    {
        return $this->belongsTo(ProductRecipe::class, 'recipe_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productVariation()
    {
        return $this->belongsTo(ProductVariation::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function completedBy()
    {
        return $this->belongsTo(User::class, 'completed_by');
    }

    public function ingredients()
    {
        return $this->hasMany(ProductionBatchIngredient::class, 'batch_id');
    }

    // Scopes
    public function scopeDraft($query)
    {
        return $query->where('status', self::STATUS_DRAFT);
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', self::STATUS_IN_PROGRESS);
    }

    public function scopePending($query)
    {
        return $query->whereIn('status', [self::STATUS_DRAFT, self::STATUS_IN_PROGRESS]);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    public function scopeForMerchant($query, int $merchantId)
    {
        return $query->where('merchant_id', $merchantId);
    }

    // Helpers
    public static function generateBatchNumber(int $merchantId): string
    {
        $prefix = 'BATCH';
        $date = now()->format('Ymd');
        $sequence = static::where('merchant_id', $merchantId)
            ->whereDate('created_at', now()->toDateString())
            ->count() + 1;
        return sprintf('%s-%s-%04d', $prefix, $date, $sequence);
    }

    public function calculateCosts(): void
    {
        $this->material_cost = $this->ingredients->sum('total_cost');
        $this->total_cost = $this->material_cost + $this->labor_cost + $this->overhead_cost;
        $this->unit_cost = $this->actual_quantity > 0
            ? $this->total_cost / $this->actual_quantity
            : 0;
    }

    public function isDraft(): bool
    {
        return $this->status === self::STATUS_DRAFT;
    }

    public function isInProgress(): bool
    {
        return $this->status === self::STATUS_IN_PROGRESS;
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function canBeEdited(): bool
    {
        return in_array($this->status, [self::STATUS_DRAFT, self::STATUS_IN_PROGRESS]);
    }

    public function canBeCompleted(): bool
    {
        return in_array($this->status, [self::STATUS_DRAFT, self::STATUS_IN_PROGRESS]);
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, [self::STATUS_DRAFT, self::STATUS_IN_PROGRESS]);
    }

    public function getStatusName(): string
    {
        $names = [
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_IN_PROGRESS => 'In Progress',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_CANCELLED => 'Cancelled',
        ];

        return $names[$this->status] ?? $this->status;
    }

    public function getStatusColor(): string
    {
        $colors = [
            self::STATUS_DRAFT => 'secondary',
            self::STATUS_IN_PROGRESS => 'primary',
            self::STATUS_COMPLETED => 'success',
            self::STATUS_CANCELLED => 'danger',
        ];

        return $colors[$this->status] ?? 'secondary';
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
