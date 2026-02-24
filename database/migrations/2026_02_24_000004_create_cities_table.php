<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('name', 255);
            $table->string('merchant_id')  // TODO: raw type bigint(20;
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
