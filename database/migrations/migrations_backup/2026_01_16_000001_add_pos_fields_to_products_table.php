<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('sku')->nullable()->after('name');
            $table->string('barcode')->nullable()->after('sku');
            $table->integer('low_stock_threshold')->default(10)->after('total_stock');

            $table->index(['merchant_id', 'sku']);
            $table->index(['merchant_id', 'barcode']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['merchant_id', 'sku']);
            $table->dropIndex(['merchant_id', 'barcode']);
            $table->dropColumn(['sku', 'barcode', 'low_stock_threshold']);
        });
    }
};
