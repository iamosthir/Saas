<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pos_inventory_movements', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('merchant_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_variation_id')->nullable();
            $table->enum('movement_type', ['sale', 'adjustment', 'purchase', 'transfer', 'void']);
            $table->integer('quantity');
            $table->integer('quantity_before');
            $table->integer('quantity_after');
            $table->string('unit_cost')  // TODO: raw type decimal(15,2;
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pos_inventory_movements');
    }
};
