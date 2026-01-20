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
        Schema::create('invoice_item_custom_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_template_id');
            $table->string('field_key', 100);
            $table->string('field_label');
            $table->enum('field_type', ['text', 'number', 'date', 'select']);
            $table->json('select_options')->nullable();
            $table->boolean('is_required')->default(false);
            $table->integer('display_order')->default(0);
            $table->timestamps();

            // Indexes
            $table->index('invoice_template_id');
            $table->index(['invoice_template_id', 'display_order'], 'inv_item_cust_fields_tmpl_order_idx');

            // Foreign key
            $table->foreign('invoice_template_id')
                  ->references('id')
                  ->on('invoice_templates')
                  ->onDelete('cascade');

            // Unique constraint
            $table->unique(['invoice_template_id', 'field_key'], 'inv_item_cust_fields_tmpl_key_unq');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_item_custom_fields');
    }
};
