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
        Schema::create('pos_sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pos_sale_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('restrict');
            $table->foreignId('product_variation_id')->nullable()->constrained()->onDelete('restrict');

            // Snapshot at sale time
            $table->string('product_name');
            $table->string('variation_name')->nullable();
            $table->string('sku')->nullable();
            $table->string('barcode')->nullable();

            // Quantity and pricing
            $table->integer('quantity');
            $table->decimal('unit_price', 15, 2);
            $table->decimal('unit_cost', 15, 2)->default(0); // For profit calculation

            // Item-level discount
            $table->enum('discount_type', ['percentage', 'fixed'])->nullable();
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('discount_value', 15, 2)->default(0); // Calculated discount

            // Line total
            $table->decimal('line_total', 15, 2);

            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('pos_sale_id');
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos_sale_items');
    }
};
