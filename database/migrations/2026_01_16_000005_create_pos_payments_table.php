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
        Schema::create('pos_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained()->onDelete('cascade');
            $table->foreignId('pos_sale_id')->constrained()->onDelete('cascade');

            $table->enum('payment_method', ['cash', 'card', 'wallet', 'bank_transfer', 'other']);
            $table->decimal('amount', 15, 2);
            $table->decimal('tendered_amount', 15, 2)->nullable(); // For cash payments
            $table->decimal('change_given', 15, 2)->default(0);

            // Reference for card/bank payments
            $table->string('reference_number')->nullable();
            $table->json('metadata')->nullable();

            $table->foreignId('processed_by')->constrained('users');
            $table->timestamps();

            // Indexes
            $table->index(['pos_sale_id', 'payment_method']);
            $table->index(['merchant_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos_payments');
    }
};
