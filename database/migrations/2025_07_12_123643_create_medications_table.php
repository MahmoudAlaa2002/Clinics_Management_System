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
        Schema::create('medications', function (Blueprint $table) {
            $table->id();
            $table->string('name');      // اسم الدواء (تجاري شامل التركيز)
            $table->string('form');   // شكل  الدواء
            $table->string('category')->nullable(); // الفئة (مضاد حيوي، مسكن...)
            $table->decimal('selling_price', 8, 2)->nullable(); // السعر
            $table->date('expiration_date')->nullable(); // تاريخ الانتهاء
            $table->text('description')->nullable(); // وصف للدواء إن وجد
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medications');
    }
};
