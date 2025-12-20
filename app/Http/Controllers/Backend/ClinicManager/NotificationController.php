<?php

namespace App\Http\Controllers\Backend\ClinicManager;

use App\Http\Controllers\Controller;


class NotificationController extends Controller {

    public function view(){
        $notifications = auth()->user()->notifications()->latest()->paginate(50);
        return view('Backend.clinics_managers.partials.notifications.view', compact('notifications'));
    }
}
