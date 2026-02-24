<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->string('phone_primary', 255);
            $table->string('phone_secondary')  // TODO: raw type varchar(255;
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('merchants');
    }
};
