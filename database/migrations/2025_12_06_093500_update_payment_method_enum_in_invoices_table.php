<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// None قمت بعمل تعديل على جدول الفواتير في حقل طريقة الدفع لأنه ما كانت تظهر
return new class extends Migration
{
    // public function up(){
    //     DB::statement("ALTER TABLE invoices MODIFY payment_method ENUM('Cash', 'Bank', 'PayPal', 'None') NULL");
    // }

    // public function down(){
    //     DB::statement("ALTER TABLE invoices MODIFY payment_method ENUM('Cash', 'Bank', 'PayPal') NULL");
    // }
};
