<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('merchant_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('supplier_id')  // TODO: raw type int(11;
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
