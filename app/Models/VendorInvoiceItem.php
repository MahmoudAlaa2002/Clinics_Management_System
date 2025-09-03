<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorInvoiceItem extends Model{

    protected $fillable = [
        'invoice_id',
        'service_name',
        'quantity',
        'unit_price',
        'total_amount',
    ];


    public function vendorInvoice(){
        return $this->belongsTo(VendorInvoice::class, 'invoice_id');
    }

}
