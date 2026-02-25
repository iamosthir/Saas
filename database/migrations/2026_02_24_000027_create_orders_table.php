<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('merchant_id')->nullable();
            $table->string('order_number', 255);
            $table->string('customer_name', 255);
            $table->text('customer_link')->nullable();
            $table->string('phone1', 255);
            $table->string('phone2', 255)->nullable();
            $table->string('state', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('product_type', 255)->nullable();
            $table->integer('qnt');
            $table->double('price')->nullable();
            $table->string('payment_type', 255)->default('نقدي');
            $table->boolean('is_paid')->default(0);
            $table->text('note')->nullable();
            $table->string('page_name', 255);
            $table->integer('admin_id');
            $table->string('admin_name', 255);
            $table->string('status', 255)->default('pending');
            $table->text('shiping')->nullable();
            $table->string('is_printed', 255)->default('no');
            $table->integer('print')->default(0);
            $table->integer('city_id')->nullable();
            $table->integer('page_id')->nullable();
            $table->integer('shiping_id')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
