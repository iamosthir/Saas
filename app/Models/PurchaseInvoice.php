<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvoice extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function supplier()
    {
        return $this->belongsTo(Suppliers::class);
    }

    // In PurchaseInvoice model
    public function payments() {
        return $this->hasMany(PurchasePayments::class, 'invoice_id');
    }

}
