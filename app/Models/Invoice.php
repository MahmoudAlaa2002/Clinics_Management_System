<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model{

    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'patient_id',
        'total_amount',
        'paid_amount',
        'payment_method',
        'payment_status',
        'invoice_date',
        'due_date',
        'created_by',
        'invoice_status',
        'refund_amount',
        'refund_date',
        'refunded_by'
    ];

    public function appointment(){
        return $this->belongsTo(Appointment::class);
    }

    public function patient(){
        return $this->belongsTo(Patient::class);
    }

    public function creator(){      // يحضر اسم الموظف الذي أصدر الفاتورة
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function refundedBy(){   // يحضر اسم الموظف الذي نفّذ عملية الإرجاع
        return $this->belongsTo(Employee::class, 'refunded_by');
    }
}
