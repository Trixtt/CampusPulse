<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Notification;

class NotificationController extends Controller
{
    public function index($userId)
    {
        return Notification::where('user_id', $userId)
            ->latest()
            ->get();
    }
}