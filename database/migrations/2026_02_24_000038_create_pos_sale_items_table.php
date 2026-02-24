<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pos_sale_items', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('pos_sale_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_variation_id')->nullable();
            $table->string('product_name', 255);
            $table->string('variation_name')  // TODO: raw type varchar(255;
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pos_sale_items');
    }
};
