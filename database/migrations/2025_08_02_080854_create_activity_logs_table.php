<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // الشخص الذي نفذ الإجراء
            $table->string('action');         // مثل create, update, delete
            $table->string('target_table');              // مثل patient_payments أو patient_invoices           // تفاصيل الحدث
            $table->json('old_data')->nullable();  // البيانات القديمة قبل التعديل
            $table->json('new_data')->nullable();  // البيانات بعد التعديل (إن وجدت)
            $table->ipAddress('ip_address')->nullable();
            $table->text('details');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
