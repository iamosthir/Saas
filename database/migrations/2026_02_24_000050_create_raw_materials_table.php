<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('raw_materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('merchant_id');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('unit_id');
            $table->string('name', 255);
            $table->string('sku', 255)->nullable();
            $table->string('barcode', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('image', 255)->nullable();
            $table->decimal('current_stock', 15, 4)->default(0.0000);
            $table->decimal('min_stock_level', 15, 4)->default(0.0000);
            $table->decimal('purchase_price', 15, 2)->default(0.00);
            $table->decimal('average_price', 15, 4)->default(0.0000);
            $table->boolean('is_active')->default(1);
            $table->boolean('track_inventory')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('raw_materials');
    }
};
