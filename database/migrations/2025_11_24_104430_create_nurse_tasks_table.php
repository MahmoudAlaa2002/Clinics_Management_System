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
        Schema::create('nurse_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->onDelete('cascade');   // الموعد الذي صدرت ضمنه المهمة
            $table->foreignId('nurse_id')->constrained('employees')->onDelete('cascade');
            $table->string('task'); // نوع المهمة: إعطاء دواء – متابعة سكر...
            $table->enum('status', ['Pending', 'Completed'])->default('Pending');
            $table->timestamp('performed_at')->nullable(); // وقت تنفيذ المهمة
            $table->text('notes')->nullable(); // ملاحظات إضافية
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nurse_tasks');
    }
};
