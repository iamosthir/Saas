<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'base_currency',
        'target_currency',
        'rate',
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
}
