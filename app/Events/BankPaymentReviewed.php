<?php

namespace App\Events;

use App\Models\User;
use App\Models\BankPayment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class BankPaymentReviewed {

    use Dispatchable, SerializesModels;

    public BankPayment $payment;
    public User $actor;
    public string $status; // approved | rejected

    public function __construct(BankPayment $payment, User $actor, string $status) {
        $this->payment = $payment;
        $this->actor   = $actor;
        $this->status  = $status;
    }
}
