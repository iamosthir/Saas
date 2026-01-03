<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'installment_schedule_id',
        'user_id',
        'action_type',
        'description',
        'amount',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    // Relationships
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function installmentSchedule()
    {
        return $this->belongsTo(InstallmentSchedule::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
