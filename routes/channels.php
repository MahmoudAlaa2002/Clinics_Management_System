<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Conversation;

Broadcast::channel('chat.{conversationId}', function ($user, $conversationId) {
    return Conversation::find($conversationId)
        ?->participants()
        ->where('user_id', $user->id)
        ->exists();
});


Broadcast::channel('online-users', function ($user) {
    return [
        'id'   => $user->id,
        'name' => $user->name,
    ];
});


Broadcast::channel('user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});








Broadcast::channel('appointments.admin', function ($user) {
    return $user->role === 'admin';
});

Broadcast::channel('appointments.doctor', function ($user) {
    return $user->role === 'doctor';
});

Broadcast::channel('appointments.receptionist', function ($user) {
    return optional($user->employee)->job_title === 'receptionist';
});

Broadcast::channel('appointments.nurse', function ($user) {
    return optional($user->employee)->job_title === 'nurse';
});

Broadcast::channel('appointments.accountant', function ($user) {
    return optional($user->employee)->job_title === 'accountant';
});

Broadcast::channel('appointments.manager', function ($user) {
    return in_array($user->role, ['clinic_manager','department_manager']);
});
