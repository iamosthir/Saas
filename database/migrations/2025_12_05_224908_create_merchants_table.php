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
        Schema::create('merchants', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->text("description")->nullable();
            $table->string("phone_primary");
            $table->string("phone_secondary")->nullable();
            $table->string("logo")->nullable();
            $table->string("address1")->nullable();
            $table->string("address2")->nullable();
            $table->string("city")->nullable();
            $table->string("zip_code")->nullable();
            $table->dateTime("subscription_start_date")->nullable();
            $table->dateTime("subscription_end_date")->nullable();
            $table->boolean("is_active")->default(true);
            $table->unsignedBigInteger("subscription_plan_id")->nullable();
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
        Schema::dropIfExists('merchants');
    }
};
