<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('name', 255);
            $table->string('email', 255);
            $table->string('password', 255);
            $table->string('phone')  // TODO: raw type varchar(255;
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
