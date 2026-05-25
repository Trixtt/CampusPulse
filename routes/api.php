<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\FollowController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\RoomController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/user', [AuthController::class, 'user']);
Route::post('/profile/update/{id}', [AuthController::class, 'updateProfile']);

Route::get('/posts', [PostController::class, 'index']);
Route::post('/posts', [PostController::class, 'store']);
Route::delete('/posts/{id}', [PostController::class, 'destroy']);

Route::post('/comments', [
    CommentController::class,
    'store'
]);

Route::post('/likes', [
    LikeController::class,
    'store'
]);

Route::get(
    '/notifications/{userId}',
    [NotificationController::class, 'index']
);

Route::get('/search-users', [AuthController::class, 'searchUser']);

Route::post('/follow/toggle', [FollowController::class, 'toggle']);

Route::post('/messages/send', [MessageController::class, 'send']);

Route::get(
    '/messages/{senderId}/{receiverId}',
    [MessageController::class, 'conversation']
);

Route::get(
    '/chat-list/{userId}',
    [MessageController::class, 'chatList']
);

Route::get('/rooms', [RoomController::class, 'index']);

Route::get(
    '/rooms/{id}/messages',
    [RoomController::class, 'messages']
);

Route::post(
    '/rooms/send',
    [RoomController::class, 'send']
);

Route::put(
    '/posts/{id}/status',
    [PostController::class, 'updateStatus']
);

Route::get('/posts/{id}', [
    PostController::class,
    'show'
]);

Route::post(
    '/posts/{id}/updates',
    [PostController::class, 'addUpdate']
);

Route::get(
    '/reports/analytics',
    [PostController::class, 'analytics']
);