<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // First, remove duplicate phone numbers by keeping only the latest user for each phone
        $duplicates = DB::table('users')
            ->select('phone', DB::raw('COUNT(*) as count'))
            ->whereNotNull('phone')
            ->groupBy('phone')
            ->having('count', '>', 1)
            ->get();

        foreach ($duplicates as $duplicate) {
            // Get the latest user ID with this phone number to keep
            $latestUserId = DB::table('users')
                ->where('phone', $duplicate->phone)
                ->orderBy('id', 'desc')
                ->value('id');

            // Delete all other users with this phone number
            DB::table('users')
                ->where('phone', $duplicate->phone)
                ->where('id', '!=', $latestUserId)
                ->delete();
        }

        // Now add the unique constraint
        Schema::table('users', function (Blueprint $table) {
            $table->unique('phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['phone']);
        });
    }
};
