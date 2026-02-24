<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('raw_material_costs', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('merchant_id');
            $table->unsignedBigInteger('raw_material_id');
            $table->decimal('unit_cost', 15, 4);
            $table->decimal('quantity', 15, 4);
            $table->decimal('original_quantity', 15, 4);
            $table->date('received_date');
            $table->string('reference_type')  // TODO: raw type varchar(255;
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('raw_material_costs');
    }
};
