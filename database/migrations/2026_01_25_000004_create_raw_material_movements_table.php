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
        Schema::create('raw_material_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained()->onDelete('cascade');
            $table->foreignId('raw_material_id')->constrained()->onDelete('cascade');

            $table->enum('movement_type', ['purchase', 'production', 'adjustment', 'waste', 'transfer']);
            $table->decimal('quantity', 15, 4); // negative for deductions
            $table->decimal('quantity_before', 15, 4);
            $table->decimal('quantity_after', 15, 4);
            $table->decimal('unit_cost', 15, 4)->nullable();

            $table->string('reference_type')->nullable(); // production_batches, purchase_invoices
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();

            $table->index(['merchant_id', 'raw_material_id'], 'rm_mov_merchant_material');
            $table->index(['reference_type', 'reference_id'], 'rm_mov_reference');
            $table->index(['merchant_id', 'created_at'], 'rm_mov_merchant_created');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raw_material_movements');
    }
};
