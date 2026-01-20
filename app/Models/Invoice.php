<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'merchant_id',
        'customer_id',
        'invoice_number',
        'invoice_template_id',
        'subtotal',
        'discount_type',
        'discount_amount',
        'extra_charge',
        'total_amount',
        'payment_type',
        'installment_months',
        'has_deposit',
        'deposit_amount',
        'paid_amount',
        'remaining_amount',
        'payment_status',
        'is_fully_paid',
        'notes',
        'custom_fields',
        'created_by',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'extra_charge' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
        'is_fully_paid' => 'boolean',
        'installment_months' => 'integer',
        'custom_fields' => 'array',
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function installmentSchedules()
    {
        return $this->hasMany(InstallmentSchedule::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function activityLogs()
    {
        return $this->hasMany(InvoiceActivityLog::class)->orderBy('created_at', 'desc');
    }

    public function template()
    {
        return $this->belongsTo(InvoiceTemplate::class, 'invoice_template_id');
    }

    public function hasCustomFields()
    {
        return !is_null($this->invoice_template_id) && !empty($this->custom_fields);
    }

    public static function generateInvoiceNumber()
    {
        $lastInvoice = self::latest()->first();
        $number = $lastInvoice ? (int)substr($lastInvoice->invoice_number, 4) + 1 : 1;
        return 'INV-' . str_pad($number, 6, '0', STR_PAD_LEFT);
    }
}
