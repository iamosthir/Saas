<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contract_templates', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('merchant_id');
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->text('footer_text')->nullable();
            $table->boolean('is_default')->default(0);
            $table->boolean('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contract_templates');
    }
};
