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
        Schema::create('pos_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->unique()->constrained()->onDelete('cascade');

            // Tax settings
            $table->decimal('tax_rate', 5, 2)->default(0);

            // Inventory settings
            $table->enum('costing_method', ['fifo', 'average'])->default('average');
            $table->boolean('allow_negative_stock')->default(false);
            $table->boolean('show_stock_warning')->default(true);

            // Receipt settings
            $table->string('receipt_header')->nullable();
            $table->string('receipt_footer')->nullable();
            $table->boolean('print_receipt_auto')->default(true);
            $table->enum('receipt_size', ['58mm', '80mm'])->default('80mm');

            // Keyboard shortcuts (JSON)
            $table->json('keyboard_shortcuts')->nullable();

            // General settings
            $table->boolean('require_customer')->default(false);
            $table->json('payment_methods')->nullable(); // Enabled payment methods

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos_settings');
    }
};
