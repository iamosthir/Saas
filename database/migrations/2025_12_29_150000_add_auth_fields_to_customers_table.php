<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // Add merchant_id for multi-tenant isolation only if it doesn't exist
            if (!Schema::hasColumn('customers', 'merchant_id')) {
                $table->unsignedBigInteger('merchant_id')->after('id')->nullable();
                $table->foreign('merchant_id')->references('id')->on('merchants')->onDelete('cascade');
            }

            // Add authentication fields
            if (!Schema::hasColumn('customers', 'remember_token')) {
                $table->rememberToken()->after('city');
            }
            if (!Schema::hasColumn('customers', 'last_login_at')) {
                $table->timestamp('last_login_at')->nullable()->after('remember_token');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign(['merchant_id']);
            $table->dropColumn(['merchant_id', 'remember_token', 'last_login_at']);
        });
    }
};
