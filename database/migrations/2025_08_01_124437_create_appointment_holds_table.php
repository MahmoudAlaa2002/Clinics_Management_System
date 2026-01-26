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
        Schema::create('appointment_holds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('clinic_department_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->time('time');
            $table->decimal('amount', 8, 2);
            $table->enum('status', ['Pending' , 'Cancelled'])->default('Pending');
            $table->timestamp('expires_at'); // now()->addMinutes(10)

            // لمنع حجزين Hold لنفس الدكتور بنفس الوقت
            // $table->unique(['doctor_id', 'date', 'time']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
