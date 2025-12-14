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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');                 // اسم المورد
            $table->string('contact_person')->nullable(); // اسم الشخص المسؤول (اختياري)
            $table->string('email')->nullable();         // البريد الإلكتروني
            $table->string('phone')->nullable();         // رقم الهاتف
            $table->string('address')->nullable();       // العنوان
            $table->string('company_name')->nullable();  // اسم الشركة (اختياري)
            $table->text('notes')->nullable();           // ملاحظات إضافية (اختياري)
            $table->boolean('is_active')->default(true); // حالة التفعيل
            $table->timestamps();                        // created_at و updated_at
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suppliers');
    }
};
