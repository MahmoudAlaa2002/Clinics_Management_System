<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseItem extends Model{

    protected $fillable = [
        'expense_id',
        'item_name',
        'quantity',
        'unit_price',
        'total_amount',
        'payment_method',
        'expense_date',
        'notes',
    ];

    public function expense(){
        return $this->belongsTo(Expense::class);
    }
}
