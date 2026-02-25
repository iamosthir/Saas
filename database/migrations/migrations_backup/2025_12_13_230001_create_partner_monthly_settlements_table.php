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
        Schema::create('partner_monthly_settlements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained()->onDelete('cascade');
            $table->smallInteger('period_year'); // e.g., 2025
            $table->tinyInteger('period_month'); // 1-12
            $table->decimal('net_profit', 12, 2); // Snapshot of net profit for the month
            $table->decimal('partner_percent', 5, 2); // Snapshot of partner percent at time of calculation
            $table->decimal('partner_amount', 12, 2); // Amount owed to partner
            $table->enum('status', ['pending', 'paid'])->default('pending');
            $table->datetime('generated_at');
            $table->datetime('paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Unique constraint to prevent duplicate settlements
            $table->unique(['partner_id', 'period_year', 'period_month'], 'partner_settlement_unique');

            // Indexes for performance
            $table->index(['period_year', 'period_month']);
            $table->index(['status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partner_monthly_settlements');
    }
};
