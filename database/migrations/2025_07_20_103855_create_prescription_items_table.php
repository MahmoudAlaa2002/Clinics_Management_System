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
        Schema::create('prescription_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prescription_id')->constrained()->onDelete('cascade');
            $table->foreignId('medicine_id')->nullable()->constrained('medications')->onDelete('set null');

            $table->string('dosage');          // الجرعة (مثلاً: 500mg)
            $table->string('duration');        // المدة (مثلاً: 7 أيام)
            $table->integer('quantity');       // الكمية
            $table->decimal('unit_price', 10, 2);  // سعر الوحدة
            $table->decimal('total_price', 10, 2); // السعر الكلي

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescription_items');
    }
};
