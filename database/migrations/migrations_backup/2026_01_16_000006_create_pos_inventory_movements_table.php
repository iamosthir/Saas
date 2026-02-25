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
        Schema::create('pos_inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_variation_id')->nullable()->constrained()->onDelete('cascade');

            $table->enum('movement_type', ['sale', 'adjustment', 'purchase', 'transfer', 'void']);
            $table->integer('quantity'); // Negative for deductions
            $table->integer('quantity_before');
            $table->integer('quantity_after');

            $table->decimal('unit_cost', 15, 2)->nullable();

            // Polymorphic reference
            $table->string('reference_type')->nullable(); // pos_sales, purchase_invoices, etc.
            $table->unsignedBigInteger('reference_id')->nullable();

            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();

            // Indexes (with custom short names)
            $table->index(['merchant_id', 'product_id'], 'pos_inv_mov_merchant_product');
            $table->index(['merchant_id', 'product_variation_id'], 'pos_inv_mov_merchant_variation');
            $table->index(['reference_type', 'reference_id'], 'pos_inv_mov_reference');
            $table->index(['merchant_id', 'created_at'], 'pos_inv_mov_merchant_created');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos_inventory_movements');
    }
};
