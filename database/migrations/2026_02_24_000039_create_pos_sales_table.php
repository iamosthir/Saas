<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pos_sales', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('merchant_id');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('sale_number', 255);
            $table->enum('status', ['draft', 'parked', 'completed', 'voided'])->default('draft');
            $table->decimal('subtotal', 15, 2)->default(0.00);
            $table->string('discount_type')  // TODO: raw type enum('percentage','fixed';
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pos_sales');
    }
};
