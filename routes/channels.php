<?php

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

Broadcast::channel('App.User.{id}', function ($user, $id) {
    // return (int) $user -> id === (int) $id;
    return true;
});

// Broadcast::channel('App.User.{id}', function ($user, $id) {
//     if(get_class($user) === 'App\Models\Admin' && ((int) $user->id === (int) $id)) {
//         return true;
//     }
//     return false;
// });

// //where App\User represent the user model
// Broadcast::channel('user.channel.{id}', function ($user, $id) {
//     if(get_class($user) === 'App\User' && ((int) $user->id === (int) $id)) {
//         return true;
//     }
//     return false;
// });
