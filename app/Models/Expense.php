<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model{
    protected $fillable = [
        'vendor_invoice_id',
    ];

    public function vendorInvoice(){
        return $this->belongsTo(VendorInvoice::class);
    }

    public function expenseItems(){
        return $this->hasMany(ExpenseItem::class);
    }
}
