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
            $table->dropColumn([
                'customer_name',
                'customer_phone1',
                'customer_phone2',
                'customer_email',
                'customer_address',
                'customer_state',
                'customer_city'
            ]);
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
            $table->string('customer_name')->after('customer_id');
            $table->string('customer_phone1')->after('customer_name');
            $table->string('customer_phone2')->nullable()->after('customer_phone1');
            $table->string('customer_email')->nullable()->after('customer_phone2');
            $table->text('customer_address')->nullable()->after('customer_email');
            $table->string('customer_state')->nullable()->after('customer_address');
            $table->string('customer_city')->nullable()->after('customer_state');
        });
    }
};
