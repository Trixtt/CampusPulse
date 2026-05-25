<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Message;

class MessageController extends Controller
{
    public function send(Request $request)
    {
        $message = Message::create([
            'sender_id' => $request->sender_id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return response()->json([
            'message' => 'Pesan berhasil dikirim',
            'data' => $message
        ]);
    }

    public function conversation($senderId, $receiverId)
    {
        return Message::where(function ($query) use ($senderId, $receiverId) {

            $query->where('sender_id', $senderId)
                  ->where('receiver_id', $receiverId);

        })->orWhere(function ($query) use ($senderId, $receiverId) {

            $query->where('sender_id', $receiverId)
                  ->where('receiver_id', $senderId);

        })
        ->orderBy('created_at', 'asc')
        ->get();
    }

    public function chatList($userId)
    {
        $messages = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->latest()
            ->get();

        $users = [];

        foreach ($messages as $message) {

            $targetUserId = $message->sender_id == $userId
                ? $message->receiver_id
                : $message->sender_id;

            $user = \App\Models\User::find($targetUserId);

            if ($user && !collect($users)->contains('id', $user->id)) {

                $users[] = $user;
            }
        }

        return response()->json($users);
    }
}