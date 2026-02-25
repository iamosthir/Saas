<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partner_monthly_settlements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id');
            $table->smallInteger('period_year');
            $table->tinyInteger('period_month');
            $table->decimal('net_profit', 12, 2);
            $table->decimal('partner_percent', 5, 2);
            $table->decimal('partner_amount', 12, 2);
            $table->enum('status', ['pending', 'paid'])->default('pending');
            $table->dateTime('generated_at');
            $table->dateTime('paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partner_monthly_settlements');
    }
};
