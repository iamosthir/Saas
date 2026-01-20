<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItemCustomField extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_template_id',
        'field_key',
        'field_label',
        'field_type',
        'select_options',
        'is_required',
        'display_order',
    ];

    protected $casts = [
        'select_options' => 'array',
        'is_required' => 'boolean',
        'display_order' => 'integer',
    ];

    /**
     * Get the template that owns the custom field.
     */
    public function template()
    {
        return $this->belongsTo(InvoiceTemplate::class, 'invoice_template_id');
    }
}
