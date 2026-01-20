<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'merchant_id',
        'name',
        'description',
        'is_default',
        'is_active',
        'template_config',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_active' => 'boolean',
        'template_config' => 'array',
    ];

    protected $attributes = [
        'template_config' => '{"header":{"show_logo":true,"show_company_name":true,"show_phone":true,"show_email":true,"show_address":true,"title":"INVOICE","subtitle":""},"table":{"columns":[{"key":"index","label":"#","width":"5%","enabled":true},{"key":"product_name","label":"Item Name","width":"35%","enabled":true},{"key":"variation","label":"Variation","width":"15%","enabled":true},{"key":"quantity","label":"Quantity","width":"10%","enabled":true},{"key":"price","label":"Unit Price","width":"15%","enabled":true},{"key":"total","label":"Total","width":"20%","enabled":true}]},"summary":{"fields":[{"key":"subtotal","label":"Subtotal","enabled":true},{"key":"discount","label":"Discount","enabled":true},{"key":"tax","label":"Tax","enabled":false,"rate":0},{"key":"shipping","label":"Shipping","enabled":false},{"key":"extra_charge","label":"Extra Charges","enabled":true},{"key":"total","label":"Total","enabled":true}]},"footer":{"show_customer_signature":true,"customer_signature_label":"Customer Signature","show_authorized_signature":true,"authorized_signature_label":"Authorized Signature","footer_note":"Thank you for your business"}}',
    ];

    /**
     * Get the merchant that owns the template.
     */
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    /**
     * Get the invoices using this template.
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Get the invoice header custom fields for this template.
     */
    public function headerFields()
    {
        return $this->hasMany(InvoiceCustomField::class)->orderBy('display_order');
    }

    /**
     * Get the invoice item custom fields for this template.
     */
    public function itemFields()
    {
        return $this->hasMany(InvoiceItemCustomField::class)->orderBy('display_order');
    }

    /**
     * Scope a query to only include templates for a specific merchant.
     */
    public function scopeForMerchant($query, $merchantId)
    {
        return $query->where('merchant_id', $merchantId);
    }

    /**
     * Scope a query to only include active templates.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
