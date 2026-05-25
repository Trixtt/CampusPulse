<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Post;
use App\Models\Notification;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        $existing = Like::where(
            'user_id',
            $request->user_id
        )->where(
            'post_id',
            $request->post_id
        )->first();

        if ($existing) {

            $existing->delete();

            return response()->json([
                'message' => 'Unliked'
            ]);
        }

        Like::create([

            'user_id' => $request->user_id,

            'post_id' => $request->post_id,

        ]);

        // Ambil postingan

        $post = Post::find(
            $request->post_id
        );

        // Jangan notif diri sendiri

        if ($post->user_id != $request->user_id) {

            Notification::create([

                'user_id' => $post->user_id,

                'from_user_id' => $request->user_id,

                'post_id' => $request->post_id,

                'type' => 'like',

            ]);
        }

        return response()->json([
            'message' => 'Liked'
        ]);
    }
}