<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recipe_ingredients', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('recipe_id');
            $table->unsignedBigInteger('raw_material_id');
            $table->unsignedBigInteger('unit_id');
            $table->decimal('quantity', 15, 4);
            $table->decimal('waste_percentage', 5, 2)->default(0.00);
            $table->integer('sort_order')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipe_ingredients');
    }
};
