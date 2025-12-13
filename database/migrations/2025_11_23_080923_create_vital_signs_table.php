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

        Schema::create('vital_signs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->onDelete('cascade');    // الربط مع الموعد وليس مع المريض لأن العلامات الحيوية تختلف من موعد لآخر
            $table->foreignId('nurse_id')->nullable()->constrained('employees') ->onDelete('set null');   // الممرض الذي أدخل البيانات

            // العلامات الحيوية
            $table->string('blood_pressure')->nullable();   // مثال: 120/80
            $table->integer('heart_rate')->nullable();      // النبض
            $table->decimal('temperature', 4, 1)->nullable(); // الحرارة 36.5 - 40.0
            $table->integer('oxygen_saturation')->nullable(); // SpO2 %
            $table->decimal('blood_sugar', 5, 1)->nullable(); // السكر mg/dL
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vital_signs');
    }
};
