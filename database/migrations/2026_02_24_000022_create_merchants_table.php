<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->string('phone_primary', 255);
            $table->string('phone_secondary', 255)->nullable();
            $table->string('logo', 255)->nullable();
            $table->string('address1', 255)->nullable();
            $table->string('address2', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('zip_code', 255)->nullable();
            $table->dateTime('subscription_start_date')->nullable();
            $table->dateTime('subscription_end_date')->nullable();
            $table->boolean('is_active')->default(1);
            $table->enum('currency', ['iqd', 'usd'])->default('IQD');
            $table->boolean('can_access_pos')->default(0);
            $table->boolean('can_access_contracts')->default(0);
            $table->boolean('can_access_manufacturing')->default(0);
            $table->unsignedBigInteger('subscription_plan_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('merchants');
    }
};
