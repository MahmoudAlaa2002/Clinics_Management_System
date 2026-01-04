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

    public function broadcastOn() {
        $conversation = $this->message->conversation()->with('participants')->first();

        // تحديد المستلم
        $receiverId = $conversation->participants()
            ->where('user_id', '!=', $this->message->sender_id)
            ->value('user_id');

        return [
            new PrivateChannel('chat.' . $this->message->conversation_id),  // قناة للشات
            new PrivateChannel('user.' . $receiverId)   // قناة للهيدر
        ];
    }


    public function broadcastWith() {
        $conversation = $this->message->conversation()->with('participants')->first();

        // المستلم (أي شخص غير المرسل)
        $receiverId = $conversation->participants()
            ->where('user_id', '!=', $this->message->sender_id)
            ->value('user_id');

        // unread الخاص بالمستلم
        $unread = $conversation->messages()
            ->where('sender_id', '!=', $receiverId)
            ->where('is_read', false)
            ->count();

        $sender = $this->message->sender;

        return [
            'id'              => $this->message->id,
            'message'         => $this->message->message,
            'sender_id'       => $this->message->sender_id,
            'conversation_id' => $this->message->conversation_id,
            'created_at'      => $this->message->created_at->format('H:i'),

            // أهم شي
            'receiver_id'     => $receiverId,
            'unread_count'    => $unread,

            // 👇 جديد
            'sender_name'     => $sender->name,
            'sender_image' => $sender->image ? asset($sender->image) : null,

        ];
    }

}

