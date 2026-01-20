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
        Schema::table('product_variations', function (Blueprint $table) {
            $table->decimal('purchase_price', 10, 2)->default(0)->after('price');
            $table->json('attribute_values')->nullable()->after('var_name'); // Store attribute values like {"Ram": "8GB", "Storage": "256GB"}
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_variations', function (Blueprint $table) {
            $table->dropColumn(['purchase_price', 'attribute_values']);
        });
    }
};
