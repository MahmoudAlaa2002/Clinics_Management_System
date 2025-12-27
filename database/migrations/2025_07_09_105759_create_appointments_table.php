<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('doctor_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('patient_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('clinic_department_id')->nullable()->constrained()->onDelete('set null');

            $table->date('date');
            $table->time('time');
            $table->enum('status', ['Pending', 'Accepted', 'Rejected', 'Cancelled', 'Completed'])->default('Pending');
            $table->text('notes')->nullable();

            $table->decimal('consultation_fee', 5, 2);    //   سعر الكشفية

            $table->unique(['doctor_id', 'date', 'time']);     // عملت قفل بحيث لو أكثر من موظف أدخل نفس الدكتور وبنفس التاريخ واليوم وفي نفس اللحظة وتجاوز الشروط في الكود ,الداتا بيز تصده

            $table->timestamp('admin_deleted_at')->nullable();
            $table->timestamp('clinic_manager_deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
