<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Events\SendUserMessage;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;
use App\Models\User;

class ChatController extends Controller
{
    //
    public function sendMessage(Request $request){
        $request->validate([
            'message' => 'required|string',
            'receiver_id' => 'required|integer|exists:users,id',
        ]);

        $message = new Chat();
        $message->sender_id = Auth::id();
        $message->receiver_id = $request->input('receiver_id');
        $message->message = $request->input('message');
        $message->seen = 0;
        $message->save();
        broadcast(new SendUserMessage($message));

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully',
        ]);
    }

    public function fetchMessages(Request $request){
        $receiverId = $request->input('receiver_id');
        $senderId = Auth::id();

        $messages = Chat::where(function($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $senderId)
                  ->where('receiver_id', $receiverId);
        })->orWhere(function($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $receiverId)
                  ->where('receiver_id', $senderId);
        })->orderBy('created_at', 'asc')->get();

        return response()->json(['messages' => $messages]);
    }

}
