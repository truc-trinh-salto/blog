<?php

use App\Broadcasting\OrderChannel;
use Illuminate\Support\Facades\Broadcast;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Log;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

//Broadcast authorizing
// Broadcast::channel('orders.{orderId}', function (User $user, int $orderId) {
//     return $user->id === Order::findOrNew($orderId)->user_id;
// });

Broadcast::channel('orders.{orderId}',OrderChannel::class);

Broadcast::channel('user.{userId}', function ($user, $userId) {
    Log::info("Test broadcast");
    return $user->id === (int) $userId;
});
