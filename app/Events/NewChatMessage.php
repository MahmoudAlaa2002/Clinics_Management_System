<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class NewChatMessage implements ShouldBroadcastNow
{
    public $message;

    public function __construct(Message $message)
    {
        // يفضّل نحمّل العلاقة لو تحتاجها
        $this->message = $message;

    }

    public function broadcastOn()
    {
        return new PrivateChannel('chat.' . $this->message->conversation_id);
    }

    public function broadcastWith()
    {
        return [
            'id'         => $this->message->id,
            'message'    => $this->message->message,
            'sender_id'  => $this->message->sender_id,
            'created_at' => $this->message->created_at->format('H:i'),
        ];
    }
}

