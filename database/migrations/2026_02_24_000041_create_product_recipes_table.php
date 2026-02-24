<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_recipes', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('merchant_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_variation_id')->nullable();
            $table->string('name', 255);
            $table->decimal('output_quantity', 15, 4)->default(1.0000);
            $table->decimal('labor_cost', 15, 2)->default(0.00);
            $table->decimal('overhead_cost', 15, 2)->default(0.00);
            $table->text('instructions')->nullable();
            $table->string('prep_time_minutes')  // TODO: raw type int(11;
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_recipes');
    }
};
