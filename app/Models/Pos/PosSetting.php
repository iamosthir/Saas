<?php

namespace App\Models\Pos;

use App\Models\Merchant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'tax_rate',
        'costing_method',
        'allow_negative_stock',
        'show_stock_warning',
        'receipt_header',
        'receipt_footer',
        'print_receipt_auto',
        'receipt_size',
        'keyboard_shortcuts',
        'require_customer',
        'payment_methods',
    ];

    protected $casts = [
        'tax_rate' => 'decimal:2',
        'allow_negative_stock' => 'boolean',
        'show_stock_warning' => 'boolean',
        'print_receipt_auto' => 'boolean',
        'require_customer' => 'boolean',
        'keyboard_shortcuts' => 'array',
        'payment_methods' => 'array',
    ];

    /**
     * Default settings
     */
    public static function defaults(): array
    {
        return [
            'tax_rate' => 0,
            'costing_method' => 'average',
            'allow_negative_stock' => false,
            'show_stock_warning' => true,
            'receipt_header' => null,
            'receipt_footer' => 'Thank you for your purchase!',
            'print_receipt_auto' => true,
            'receipt_size' => '80mm',
            'require_customer' => false,
            'payment_methods' => ['cash', 'card', 'wallet', 'bank_transfer'],
            'keyboard_shortcuts' => [
                'F1' => 'focus_search',
                'F2' => 'new_cart',
                'F3' => 'switch_cart',
                'F4' => 'park_sale',
                'F5' => 'view_parked',
                'F8' => 'apply_discount',
                'F9' => 'select_customer',
                'F10' => 'open_payment',
                'F12' => 'quick_cash',
            ],
        ];
    }

    /**
     * Get settings for a merchant, creating defaults if not exists
     */
    public static function getForMerchant($merchantId): self
    {
        return self::firstOrCreate(
            ['merchant_id' => $merchantId],
            self::defaults()
        );
    }

    // Relationships

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    // Helper methods

    public function usesFifo(): bool
    {
        return $this->costing_method === 'fifo';
    }

    public function usesAverage(): bool
    {
        return $this->costing_method === 'average';
    }

    public function allowsNegativeStock(): bool
    {
        return $this->allow_negative_stock;
    }

    public function isPaymentMethodEnabled(string $method): bool
    {
        $methods = $this->payment_methods ?? ['cash'];
        return in_array($method, $methods);
    }

    /**
     * Get keyboard shortcut for action
     */
    public function getShortcut(string $action): ?string
    {
        $shortcuts = $this->keyboard_shortcuts ?? [];
        $flipped = array_flip($shortcuts);
        return $flipped[$action] ?? null;
    }
}
