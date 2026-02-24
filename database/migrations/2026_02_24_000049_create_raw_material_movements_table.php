<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('raw_material_movements', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('merchant_id');
            $table->unsignedBigInteger('raw_material_id');
            $table->enum('movement_type', ['purchase', 'production', 'adjustment', 'waste', 'transfer']);
            $table->decimal('quantity', 15, 4);
            $table->decimal('quantity_before', 15, 4);
            $table->decimal('quantity_after', 15, 4);
            $table->string('unit_cost')  // TODO: raw type decimal(15,4;
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('raw_material_movements');
    }
};
