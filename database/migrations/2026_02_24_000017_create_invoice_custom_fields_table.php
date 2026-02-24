<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_custom_fields', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('invoice_template_id');
            $table->string('field_key', 100);
            $table->string('field_label', 255);
            $table->enum('field_type', ['text', 'number', 'date', 'select']);
            $table->longText('select_options')->nullable()  // TODO default NULL CHECK (json_valid(`select_options`));
            $table->boolean('is_required')->default(0);
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_custom_fields');
    }
};
