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
        Schema::create('customer_sale_invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->text('note')->nullable();
            $table->json('products');
            $table->decimal('total_price', 15, 2)->default(0);
            $table->string('payment_status')->default('pending');
            $table->string('order_status')->default('draft');
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_sale_invoices');
    }
};
