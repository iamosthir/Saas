<?php

namespace App\Models\Pos;

use App\Models\Merchant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosOfflineQueue extends Model
{
    use HasFactory;

    protected $table = 'pos_offline_queue';

    protected $fillable = [
        'merchant_id',
        'offline_id',
        'action_type',
        'payload',
        'status',
        'error_message',
        'retry_count',
        'created_offline_at',
    ];

    protected $casts = [
        'payload' => 'array',
        'retry_count' => 'integer',
        'created_offline_at' => 'datetime',
    ];

    const MAX_RETRIES = 3;

    /**
     * Boot method for auto-filling merchant_id
     */
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

    // Scopes

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeRetryable($query)
    {
        return $query->where('status', 'failed')
            ->where('retry_count', '<', self::MAX_RETRIES);
    }

    // Status management

    public function markAsProcessing(): void
    {
        $this->update(['status' => 'processing']);
    }

    public function markAsCompleted(): void
    {
        $this->update(['status' => 'completed']);
    }

    public function markAsFailed(string $errorMessage): void
    {
        $this->update([
            'status' => 'failed',
            'error_message' => $errorMessage,
            'retry_count' => $this->retry_count + 1,
        ]);
    }

    public function resetForRetry(): void
    {
        $this->update([
            'status' => 'pending',
            'error_message' => null,
        ]);
    }

    // Helper methods

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isProcessing(): bool
    {
        return $this->status === 'processing';
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function canRetry(): bool
    {
        return $this->isFailed() && $this->retry_count < self::MAX_RETRIES;
    }

    public function hasExceededRetries(): bool
    {
        return $this->retry_count >= self::MAX_RETRIES;
    }
}
