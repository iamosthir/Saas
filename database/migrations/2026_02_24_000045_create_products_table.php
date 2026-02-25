<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('merchant_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->integer('supplier_id')->nullable();
            $table->string('name', 255);
            $table->string('sku', 255)->nullable();
            $table->string('barcode', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('model_name', 255)->nullable();
            $table->double('default_price')->default(0);
            $table->decimal('purchase_price', 10, 2)->default(0.00);
            $table->decimal('sell_price', 10, 2)->default(0.00);
            $table->decimal('installment_price', 15, 2)->default(0.00);
            $table->string('discount_type', 255)->nullable();
            $table->decimal('discount_amount', 10, 2)->default(0.00);
            $table->integer('total_stock')->default(0);
            $table->integer('low_stock_threshold')->default(10);
            $table->string('image', 255)->nullable();
            $table->string('thumbnail', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
