<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstallmentSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'installment_number',
        'due_date',
        'amount',
        'paid_amount',
        'status',
        'paid_date',
        'notes',
    ];

    protected $casts = [
        'installment_number' => 'integer',
        'amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'due_date' => 'date',
        'paid_date' => 'date',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
