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
        Schema::create('medicine_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medication_id')->constrained('medications')->onDelete('cascade');
            $table->integer('quantity');
            $table->string('batch_number');            // رقم الدفعة
            $table->date('manufacture_date');             // تاريخ الانتاج
            $table->date('expiry_date');                // تاريخ الانتهاء
            $table->text('description')->nullable();
            $table->foreignId('clinic_id')->constrained('clinics')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicine_stocks');
    }
};
