<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Notification;

class NotificationController extends Controller
{
    public function index($userId)
    {
        return Notification::with([
            'fromUser',
            'post'
        ])
        ->where('user_id', $userId)
        ->latest()
        ->get();
    }
}