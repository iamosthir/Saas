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
        Schema::create('treasury_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['income', 'expense']);
            $table->enum('category', ['invoice_payment', 'deposit', 'installment', 'expense', 'refund', 'other']);
            $table->decimal('amount', 15, 2);
            $table->string('description');
            $table->unsignedBigInteger('transactionable_id')->nullable();
            $table->string('transactionable_type')->nullable();
            $table->index(['transactionable_type', 'transactionable_id'], 'treasury_transactionable_index');
            $table->date('transaction_date');
            $table->timestamps();
            $table->index(['merchant_id', 'type', 'transaction_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('treasury_transactions');
    }
};
