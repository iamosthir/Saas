<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('treasury_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('merchant_id');
            $table->enum('type', ['income', 'expense']);
            $table->enum('category', ['invoice_payment', 'deposit', 'installment', 'expense', 'refund', 'other']);
            $table->decimal('amount', 15, 2);
            $table->string('description', 255);
            $table->unsignedBigInteger('transactionable_id')->nullable();
            $table->string('transactionable_type', 255)->nullable();
            $table->date('transaction_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('treasury_transactions');
    }
};
