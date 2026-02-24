<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('merchant_id')->nullable();
            $table->string('order_number', 255);
            $table->string('customer_name', 255);
            $table->text('customer_link')->nullable();
            $table->string('phone1', 255);
            $table->string('phone2')  // TODO: raw type varchar(255;
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
