<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractCustomField extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_template_id',
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
     * Get the contract template that owns the custom field.
     */
    public function template()
    {
        return $this->belongsTo(ContractTemplate::class, 'contract_template_id');
    }
}
