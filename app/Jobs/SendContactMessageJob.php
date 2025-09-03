<?php

namespace App\Jobs;

use App\Mail\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendContactMessageJob implements ShouldQueue{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;

    public function __construct($data){
        $this->data = $data;
    }

    public function handle(){
        Mail::to('m82859477@gmail.com')->send(new ContactMessage($this->data));
    }
}
