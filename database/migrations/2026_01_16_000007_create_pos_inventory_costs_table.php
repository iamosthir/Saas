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
        Schema::create('pos_inventory_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_variation_id')->nullable()->constrained()->onDelete('cascade');

            $table->decimal('unit_cost', 15, 2);
            $table->integer('quantity'); // Remaining quantity at this cost
            $table->integer('original_quantity');
            $table->date('received_date');

            // Reference to source (purchase invoice, etc.)
            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();

            $table->timestamps();

            // Indexes for FIFO queries (with custom short names)
            $table->index(['merchant_id', 'product_id', 'received_date'], 'pos_inv_costs_merchant_product_date');
            $table->index(['merchant_id', 'product_variation_id', 'received_date'], 'pos_inv_costs_merchant_variation_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos_inventory_costs');
    }
};
