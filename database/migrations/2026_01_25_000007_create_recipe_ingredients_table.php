<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('recipe_ingredients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recipe_id')->constrained('product_recipes')->onDelete('cascade');
            $table->foreignId('raw_material_id')->constrained()->onDelete('restrict');
            $table->foreignId('unit_id')->constrained('units_of_measure')->onDelete('restrict');

            $table->decimal('quantity', 15, 4);
            $table->decimal('waste_percentage', 5, 2)->default(0);
            $table->integer('sort_order')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['recipe_id', 'raw_material_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe_ingredients');
    }
};
