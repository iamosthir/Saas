<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSaleInvoice extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(CustomerSalePayments::class, 'customer_sale_invoice_id');
    }
}
