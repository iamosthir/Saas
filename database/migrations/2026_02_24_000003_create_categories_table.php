<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('name', 255);
            $table->string('slug')  // TODO: raw type varchar(255;
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
