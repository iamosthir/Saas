<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pos_settings', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('merchant_id');
            $table->decimal('tax_rate', 5, 2)->default(0.00);
            $table->enum('costing_method', ['fifo', 'average'])->default('average');
            $table->boolean('allow_negative_stock')->default(0);
            $table->boolean('show_stock_warning')->default(1);
            $table->string('receipt_header')  // TODO: raw type varchar(255;
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pos_settings');
    }
};
