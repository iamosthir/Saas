<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('set null');


            // Invoice details
            $table->string('invoice_number')->unique();
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->enum('discount_type', ['percentage', 'fixed'])->default('fixed');
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('extra_charge', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2)->default(0);

            // Payment type
            $table->enum('payment_type', ['full_payment', 'installment'])->default('full_payment');
            $table->integer('installment_months')->nullable();
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->decimal('remaining_amount', 15, 2)->default(0);

            // Status
            $table->enum('payment_status', ['unpaid', 'partial', 'paid'])->default('unpaid');
            $table->boolean('is_fully_paid')->default(false);

            // Additional info
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};
