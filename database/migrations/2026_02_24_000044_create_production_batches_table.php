<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('production_batches', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('merchant_id');
            $table->unsignedBigInteger('recipe_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_variation_id')->nullable();
            $table->string('batch_number', 255);
            $table->decimal('planned_quantity', 15, 4);
            $table->string('actual_quantity')  // TODO: raw type decimal(15,4;
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_batches');
    }
};
