<?php

namespace App\Http\Controllers\Backend\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller{

    public function markExpiredAsRead($id){
        $notification = auth()->user()->notifications()
        ->where('data->medication_id', $id)
        ->firstOrFail();

        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        return redirect()->route('details_medication', $notification->data['medication_id']);
    }





    public function markDetailsAsRead($id){
        $notification = auth()->user()->notifications()->where('data->request_id', $id)->firstOrFail();

        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        return redirect()->route('admin_request_details', $notification->data['request_id']);
    }





}
