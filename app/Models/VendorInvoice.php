<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorInvoice extends Model{

    protected $fillable = [
        'vendor_id',
        'clinic_id',
        'invoice_date',
        'discount',
        'total_amount',
        'final_amount',
        'status',
    ];

    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }

    public function clinic(){
        return $this->belongsTo(Clinic::class);
    }

    public function expenses(){
        return $this->hasMany(Expense::class, 'vendor_invoice_id');
    }

    public function items(){
        return $this->hasMany(VendorInvoiceItem::class, 'invoice_id');
    }
}
