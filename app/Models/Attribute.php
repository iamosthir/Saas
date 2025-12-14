<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'merchant_id',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationship to merchant
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
}
