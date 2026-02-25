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
        Schema::create('customer_sale_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_sale_invoice_id');
            $table->decimal('amount', 15, 2);
            $table->string('remarks')->nullable();
            $table->timestamps();

            $table->foreign('customer_sale_invoice_id')
                  ->references('id')
                  ->on('customer_sale_invoices')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_sale_payments');
    }
};
