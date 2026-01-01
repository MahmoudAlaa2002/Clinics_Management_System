<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoicesSeeder extends Seeder{

    public function run(): void{

        DB::table('invoices')->insert([

            // ============================
            //  Clinic A فواتير مواعيد
            // appointments: 1 → 7
            // ============================

            [
                'appointment_id' => 1,
                'patient_id' => 1,
                'total_amount' => 50,
                'paid_amount' => 50,
                'payment_method' => 'Cash',
                'payment_status' => 'Paid',
                'invoice_date' => '2025-12-01',
                'due_date' => null,
                'created_by' => 9,   // A رقم موظف الاستقبال للقسم المحدد من عيادة
                'refund_amount' => null,
                'refund_date' => null,
                'invoice_status' => 'Issued',
                'refunded_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'appointment_id' => 2,
                'patient_id' => 2,
                'total_amount' => 60,
                'paid_amount' => 60,
                'payment_method' => 'PayPal',
                'payment_status' => 'Paid',
                'invoice_date' => '2025-12-01',
                'due_date' => null,
                'created_by' => 10,
                'refund_amount' => null,
                'refund_date' => null,
                'invoice_status' => 'Issued',
                'refunded_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'appointment_id' => 3,
                'patient_id' => 3,
                'total_amount' => 70,
                'paid_amount' => 0,
                'payment_method' => 'None',
                'payment_status' => 'Unpaid',
                'invoice_date' => '2025-12-01',
                'due_date' => '2025-12-05',
                'created_by' => 11,
                'refund_amount' => null,
                'refund_date' => null,
                'invoice_status' => 'Issued',
                'refunded_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'appointment_id' => 4,
                'patient_id' => 4,
                'total_amount' => 55,
                'paid_amount' => 25,
                'payment_method' => 'Cash',
                'payment_status' => 'Partially Paid',
                'invoice_date' => '2025-12-02',
                'due_date' => '2025-12-06',
                'created_by' => 12,
                'refund_amount' => null,
                'refund_date' => null,
                'invoice_status' => 'Issued',
                'refunded_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'appointment_id' => 5,
                'patient_id' => 5,
                'total_amount' => 50,
                'paid_amount' => 25,
                'payment_method' => 'Cash',
                'payment_status' => 'Partially Paid',
                'invoice_date' => '2025-12-02',
                'due_date' => '2025-12-06',
                'created_by' => 9,
                'refund_amount' => null,
                'refund_date' => null,
                'invoice_status' => 'Issued',
                'refunded_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'appointment_id' => 6,
                'patient_id' => 6,
                'total_amount' => 50,
                'paid_amount' => 25,
                'payment_method' => 'Cash',
                'payment_status' => 'Partially Paid',
                'invoice_date' => '2025-12-02',
                'due_date' => '2025-12-06',
                'created_by' => 9,
                'refund_amount' => null,
                'refund_date' => null,
                'invoice_status' => 'Issued',
                'refunded_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'appointment_id' => 7,
                'patient_id' => 7,
                'total_amount' => 45,
                'paid_amount' => 25,
                'payment_method' => 'Cash',
                'payment_status' => 'Partially Paid',
                'invoice_date' => '2025-12-02',
                'due_date' => '2025-12-06',
                'created_by' => 10,
                'refund_amount' => null,
                'refund_date' => null,
                'invoice_status' => 'Issued',
                'refunded_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ============================
            //  Clinic B فواتير مواعيد
            //  (appointments 8 → 14)
            // ============================

            [
                'appointment_id' => 8,
                'patient_id' => 8,
                'total_amount' => 50,
                'paid_amount' => 50,
                'payment_method' => 'Bank',
                'payment_status' => 'Paid',
                'invoice_date' => '2025-12-01',
                'due_date' => null,
                'created_by' => 31,
                'refund_amount' => null,
                'refund_date' => null,
                'invoice_status' => 'Issued',
                'refunded_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'appointment_id' => 9,
                'patient_id' => 9,
                'total_amount' => 60,
                'paid_amount' => 0,
                'payment_method' => 'None',
                'payment_status' => 'Unpaid',
                'invoice_date' => '2025-12-01',
                'due_date' => '2025-12-05',
                'created_by' => 32,
                'refund_amount' => null,
                'refund_date' => null,
                'invoice_status' => 'Issued',
                'refunded_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'appointment_id' => 10,
                'patient_id' => 10,
                'total_amount' => 70,
                'paid_amount' => 0,
                'payment_method' => 'None',
                'payment_status' => 'Unpaid',
                'invoice_date' => '2025-12-01',
                'due_date' => '2025-12-05',
                'created_by' => 33,
                'refund_amount' => null,
                'refund_date' => null,
                'invoice_status' => 'Issued',
                'refunded_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'appointment_id' => 11,
                'patient_id' => 11,
                'total_amount' => 55,
                'paid_amount' => 30,
                'payment_method' => 'Cash',
                'payment_status' => 'Partially Paid',
                'invoice_date' => '2025-12-01',
                'due_date' => '2025-12-05',
                'created_by' => 34,
                'refund_amount' => null,
                'refund_date' => null,
                'invoice_status' => 'Issued',
                'refunded_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'appointment_id' => 12,
                'patient_id' => 12,
                'total_amount' => 50,
                'paid_amount' => 50,
                'payment_method' => 'Bank',
                'payment_status' => 'Paid',
                'invoice_date' => '2025-12-01',
                'due_date' => '2025-12-05',
                'created_by' => 31,
                'refund_amount' => null,
                'refund_date' => null,
                'invoice_status' => 'Issued',
                'refunded_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'appointment_id' => 13,
                'patient_id' => 13,
                'total_amount' => 50,
                'paid_amount' => 25,
                'payment_method' => 'Bank',
                'payment_status' => 'Partially Paid',
                'invoice_date' => '2025-12-01',
                'due_date' => '2025-12-15',
                'created_by' => 31,
                'refund_amount' => null,
                'refund_date' => null,
                'invoice_status' => 'Issued',
                'refunded_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'appointment_id' => 14,
                'patient_id' => 14,
                'total_amount' => 45,
                'paid_amount' => 0,
                'payment_method' => 'None',
                'payment_status' => 'Unpaid',
                'invoice_date' => '2025-12-01',
                'due_date' => '2025-12-15',
                'created_by' => 32,
                'refund_amount' => null,
                'refund_date' => null,
                'invoice_status' => 'Issued',
                'refunded_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ============================
            //  Clinic C فواتير مواعيد
            // (appointments 15 → 20)
            // ============================


        ]);
    }
}
