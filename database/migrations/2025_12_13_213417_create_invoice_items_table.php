<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_variation_id')->nullable()->constrained()->onDelete('set null');

            $table->string('product_name');
            $table->string('variation_name')->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('original_price', 15, 2)->default(0);
            $table->decimal('custom_price', 15, 2)->default(0);
            $table->decimal('line_total', 15, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_items');
    }
};
