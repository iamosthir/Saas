<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('raw_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->foreignId('unit_id')->constrained('units_of_measure')->onDelete('restrict');

            $table->string('name');
            $table->string('sku')->nullable();
            $table->string('barcode')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();

            $table->decimal('current_stock', 15, 4)->default(0);
            $table->decimal('min_stock_level', 15, 4)->default(0);
            $table->decimal('purchase_price', 15, 2)->default(0);
            $table->decimal('average_price', 15, 4)->default(0);

            $table->boolean('is_active')->default(true);
            $table->boolean('track_inventory')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['merchant_id', 'name']);
            $table->index(['merchant_id', 'sku']);
            $table->index(['merchant_id', 'barcode']);

            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raw_materials');
    }
};
