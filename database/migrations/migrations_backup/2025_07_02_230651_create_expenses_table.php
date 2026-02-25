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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('name');            // Expense Name
            $table->decimal('amount', 15, 2);  // Amount
            $table->date('date');              // Expense Date
            $table->unsignedBigInteger('department'); // Department ID (you can use 'department_id' for better naming)
            $table->string('reference')->nullable();  // Reference/Invoice (optional)
            $table->text('notes')->nullable();        // Notes/Description (optional)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
    }
};
