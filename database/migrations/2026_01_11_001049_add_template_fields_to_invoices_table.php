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
        Schema::table('invoices', function (Blueprint $table) {
            $table->unsignedBigInteger('invoice_template_id')->nullable()->after('merchant_id');
            $table->json('custom_fields')->nullable()->after('notes');

            // Index
            $table->index('invoice_template_id');

            // Foreign key
            $table->foreign('invoice_template_id')
                  ->references('id')
                  ->on('invoice_templates')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['invoice_template_id']);
            $table->dropIndex(['invoice_template_id']);
            $table->dropColumn(['invoice_template_id', 'custom_fields']);
        });
    }
};
