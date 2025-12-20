<?php

namespace App\Http\Controllers\Backend\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller {

    public function view(){
        $notifications = auth()->user()->notifications()->latest()->paginate(50);
        return view('Backend.admin.partials.notifications.view', compact('notifications'));
    }
}
