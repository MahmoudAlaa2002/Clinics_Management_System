<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void{
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('blood_type')->nullable();     // فصيلة الدم
            $table->string('emergency_contact')->nullable();  // رقم للطوارئ
            $table->text('allergies')->nullable();            // الجساسية
            $table->text('chronic_diseases')->nullable();     // أمراض مزمنة
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
