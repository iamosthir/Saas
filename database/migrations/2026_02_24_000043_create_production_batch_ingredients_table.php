<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('production_batch_ingredients', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('batch_id');
            $table->unsignedBigInteger('raw_material_id');
            $table->unsignedBigInteger('unit_id');
            $table->decimal('required_quantity', 15, 4);
            $table->string('actual_quantity')  // TODO: raw type decimal(15,4;
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_batch_ingredients');
    }
};
