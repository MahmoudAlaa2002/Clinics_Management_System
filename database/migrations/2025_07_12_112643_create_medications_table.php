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
            $table->string('name');
            $table->foreignId('dosage_form_id')->constrained()->onDelete('cascade');
            $table->string('strength');                // التركيز
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->decimal('purchase_price', 8, 2)->nullable();
            $table->decimal('selling_price', 8, 2)->nullable();
            $table->timestamps();
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
