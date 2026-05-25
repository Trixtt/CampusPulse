<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\RoomMessage;

class RoomController extends Controller
{
    // Ambil semua pesan global room

    public function messages()
    {
        return RoomMessage::with('user')
            ->latest()
            ->get();
    }

    // Kirim pesan global room

    public function send(Request $request)
    {
        $request->validate([

            'user_id' => 'required',

            'message' => 'required',

        ]);

        return RoomMessage::create([

            'user_id' => $request->user_id,

            'message' => $request->message,

        ]);
    }
}