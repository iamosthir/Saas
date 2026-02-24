<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pos_offline_queue', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('merchant_id');
            $table->string('offline_id', 255);
            $table->enum('action_type', ['sale', 'payment', 'void']);
            $table->longText('payload');
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->text('error_message')->nullable();
            $table->integer('retry_count')->default(0);
            $table->timestamp('created_offline_at')->useCurrent()  // TODO: ON UPDATE CURRENT_TIMESTAMP;
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pos_offline_queue');
    }
};
