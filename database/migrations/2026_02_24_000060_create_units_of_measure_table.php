<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('units_of_measure', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('merchant_id');
            $table->string('name', 255);
            $table->string('symbol', 10);
            $table->string('category', 255);
            $table->decimal('conversion_factor', 15, 6)->default(1.000000);
            $table->boolean('is_base_unit')->default(0);
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('units_of_measure');
    }
};
