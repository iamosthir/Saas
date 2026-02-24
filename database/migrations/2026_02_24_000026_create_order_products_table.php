<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('merchant_id')->nullable();
            $table->unsignedBigInteger('order_id');
            $table->integer('product_id');
            $table->integer('variation_id');
            $table->integer('quantity');
            $table->double('net_price')->default(0);
            $table->double('sub_total_price')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_products');
    }
};
