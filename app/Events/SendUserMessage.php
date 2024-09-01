<?php

namespace App\Events;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class SendUserMessage implements ShouldBroadcastNow{

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Chat $message)
    {
        $this->message = $message;
    }


    public function broadcastOn(){
        return new Channel('user-messages'); // Channel to broadcast on
    }

    public function broadcastWith(){
        // Assuming sender_id is a user ID
        $user = User::find($this->message->sender_id);

        if ($user) {
            return [
                'message' => $this->message->message,
                'receiver_id' => $this->message->receiver_id,
                'sender_id' => $this->message->sender_id,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'picture' => asset('uploads/users/'. $user->picture),
                ],
                'created_at' => $this->message->created_at,
            ];
        } else {
            return [
                'message' => $this->message->message,
                'receiver_id' => $this->message->receiver_id,
                'sender_id' => $this->message->sender_id,
                'user' => [
                    'id' => null,
                    'name' => 'Unknown User',
                    'picture' => asset('uploads/users/user.jpg'),
                ],
                'created_at' => $this->message->created_at,
            ];
        }
    }

    public function broadcastAs()
    {
        return 'user-message';
    }
}
