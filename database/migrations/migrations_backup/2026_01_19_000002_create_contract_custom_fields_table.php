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
        Schema::create('contract_custom_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_template_id')->constrained()->onDelete('cascade');
            $table->string('field_key', 100);
            $table->string('field_label');
            $table->enum('field_type', ['text', 'number', 'date', 'textarea', 'select']);
            $table->json('select_options')->nullable();
            $table->boolean('is_required')->default(false);
            $table->integer('display_order')->default(0);
            $table->timestamps();

            $table->unique(['contract_template_id', 'field_key']);
            $table->index(['contract_template_id', 'display_order']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contract_custom_fields');
    }
};
