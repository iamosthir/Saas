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
        Schema::table('products', function (Blueprint $table) {
            $table->text('description')->nullable()->after('name');
            $table->string('thumbnail')->nullable()->after('image');
            $table->unsignedBigInteger('category_id')->nullable()->after('merchant_id');
            $table->decimal('purchase_price', 10, 2)->default(0)->after('default_price');
            $table->decimal('sell_price', 10, 2)->default(0)->after('purchase_price');
            $table->string('discount_type')->nullable()->after('sell_price'); // 'fixed' or 'percentage'
            $table->decimal('discount_amount', 10, 2)->default(0)->after('discount_type');
            $table->integer('total_stock')->default(0)->after('discount_amount');

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn([
                'description',
                'thumbnail',
                'category_id',
                'purchase_price',
                'sell_price',
                'discount_type',
                'discount_amount',
                'total_stock'
            ]);
        });
    }
};
