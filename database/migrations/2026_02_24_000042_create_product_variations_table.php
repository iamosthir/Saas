<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('merchant_id')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->string('var_name', 255);
            $table->string('sku', 255)->nullable();
            $table->string('barcode', 255)->nullable();
            $table->longText('attribute_values')->nullable();
            $table->unsignedInteger('quantity')->default(0);
            $table->double('price')->default(0);
            $table->decimal('installment_price', 15, 2)->default(0.00);
            $table->decimal('purchase_price', 10, 2)->default(0.00);
            $table->double('average_price')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variations');
    }
};
