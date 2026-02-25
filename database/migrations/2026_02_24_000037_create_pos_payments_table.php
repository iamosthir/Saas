<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pos_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('merchant_id');
            $table->unsignedBigInteger('pos_sale_id');
            $table->enum('payment_method', ['cash', 'card', 'wallet', 'bank_transfer', 'other']);
            $table->decimal('amount', 15, 2);
            $table->decimal('tendered_amount', 15, 2)->nullable();
            $table->decimal('change_given', 15, 2)->default(0.00);
            $table->string('reference_number', 255)->nullable();
            $table->longText('metadata')->nullable()->default(DB::raw("NULL CHECK (json_valid(`metadata`))"));
            $table->unsignedBigInteger('processed_by');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pos_payments');
    }
};
