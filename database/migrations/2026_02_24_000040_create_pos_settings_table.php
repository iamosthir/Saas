<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pos_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('merchant_id');
            $table->decimal('tax_rate', 5, 2)->default(0.00);
            $table->enum('costing_method', ['fifo', 'average'])->default('average');
            $table->boolean('allow_negative_stock')->default(0);
            $table->boolean('show_stock_warning')->default(1);
            $table->string('receipt_header', 255)->nullable();
            $table->string('receipt_footer', 255)->nullable();
            $table->boolean('print_receipt_auto')->default(1);
            $table->enum('receipt_size', ['58mm', '80mm'])->default('80mm');
            $table->longText('keyboard_shortcuts')->nullable()->default(DB::raw("NULL CHECK (json_valid(`keyboard_shortcuts`))"));
            $table->boolean('require_customer')->default(0);
            $table->longText('payment_methods')->nullable()->default(DB::raw("NULL CHECK (json_valid(`payment_methods`))"));
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pos_settings');
    }
};
