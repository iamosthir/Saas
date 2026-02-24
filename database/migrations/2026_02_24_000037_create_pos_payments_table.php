<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pos_payments', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('merchant_id');
            $table->unsignedBigInteger('pos_sale_id');
            $table->enum('payment_method', ['cash', 'card', 'wallet', 'bank_transfer', 'other']);
            $table->decimal('amount', 15, 2);
            $table->string('tendered_amount')  // TODO: raw type decimal(15,2;
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pos_payments');
    }
};
