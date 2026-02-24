<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_invoices', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('merchant_id')->nullable();
            $table->unsignedBigInteger('supplier_id');
            $table->text('note')->nullable();
            $table->longText('products');
            $table->decimal('total_price', 15, 2)->default(0.00);
            $table->string('payment_status', 255)->default('pending');
            $table->string('order_status', 255)->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_invoices');
    }
};
