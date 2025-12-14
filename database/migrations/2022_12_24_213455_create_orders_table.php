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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string("order_number")->unique();
            $table->string('customer_name');
            $table->text("customer_link");
            $table->string("phone1");
            $table->string("phone2")->nullable();
            $table->string("state");
            $table->string("city");
            $table->string("product_type");
            $table->integer("qnt");
            $table->float("price");
            $table->text("note")->nullable();
            $table->string("page_name");
            $table->integer("admin_id");
            $table->string("admin_name");
            $table->string("status")->default("pending");
            $table->string("is_printed")->default("no");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
