<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Notification;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $comment = Comment::create([

            'user_id' => $request->user_id,

            'post_id' => $request->post_id,

            'content' => $request->content,

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

                'type' => 'comment',

            ]);
        }

        $comment->load('user');

        return response()->json([

            'message' => 'Komentar berhasil',

            'comment' => $comment,

        ]);
    }
}