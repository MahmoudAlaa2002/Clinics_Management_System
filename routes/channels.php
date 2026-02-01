<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Conversation;


Broadcast::routes(['middleware' => ['web', 'auth']]);


Broadcast::channel('chat.{conversationId}', function ($user, $conversationId) {
    return Conversation::find($conversationId)
            ?->participants()
        ->where('user_id', $user->id)
        ->exists();
});


Broadcast::channel('online-users', function ($user) {
    return [
        'id' => $user->id,
        'name' => $user->name,
    ];
});


Broadcast::channel('user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});



Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

