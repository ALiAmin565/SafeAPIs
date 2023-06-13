<?php

use App\Models\User;
use App\Broadcasting\recommend;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('recommendation', function () {

    return true;
});

// Broadcast::channel('recommendation/VIP', function () {
//     return true;
// });


// Broadcast::channel('recommendation/{plan_name}', function (User $user, $plan_name) {
//    dd(150);
//     return $user->plan_name == $plan_name;
// });

Broadcast::channel('ChatPlan', function () {
    return true;
});
