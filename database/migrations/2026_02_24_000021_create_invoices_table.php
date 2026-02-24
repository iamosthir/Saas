<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('merchant_id');
            $table->unsignedBigInteger('invoice_template_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('invoice_number', 255);
            $table->decimal('subtotal', 15, 2)->default(0.00);
            $table->enum('discount_type', ['percentage', 'fixed'])->default('fixed');
            $table->decimal('discount_amount', 15, 2)->default(0.00);
            $table->decimal('extra_charge', 15, 2)->default(0.00);
            $table->decimal('total_amount', 15, 2)->default(0.00);
            $table->enum('payment_type', ['full_payment', 'installment'])->default('full_payment');
            $table->boolean('has_deposit')->default(0);
            $table->decimal('deposit_amount', 15, 2)->default(0.00);
            $table->string('installment_months')  // TODO: raw type int(11;
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
