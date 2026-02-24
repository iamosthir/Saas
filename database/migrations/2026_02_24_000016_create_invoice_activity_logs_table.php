<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_activity_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('installment_schedule_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('action_type', 255);
            $table->text('description');
            $table->string('amount')  // TODO: raw type decimal(15,2;
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_activity_logs');
    }
};
