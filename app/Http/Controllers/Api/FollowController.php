<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Follow;

class FollowController extends Controller
{
    public function toggle(Request $request)
    {
        $follow = Follow::where(
            'follower_id',
            $request->follower_id
        )
        ->where(
            'following_id',
            $request->following_id
        )
        ->first();

        if ($follow) {

            $follow->delete();

            return response()->json([
                'message' => 'Unfollow'
            ]);
        }

        Follow::create([
            'follower_id' => $request->follower_id,
            'following_id' => $request->following_id,
        ]);

        return response()->json([
            'message' => 'Follow'
        ]);
    }
}