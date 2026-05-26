<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Post;

class Notification extends Model
{
    protected $fillable = [

        'user_id',

        'content',

        'category',

        'type',

        'image',

        'location',

        'status',

        'priority',

    ];

    public function fromUser()
    {
        return $this->belongsTo(
            User::class,
            'from_user_id'
        );
    }

    public function post()
    {
        return $this->belongsTo(
            Post::class,
            'post_id'
        );
    }
}