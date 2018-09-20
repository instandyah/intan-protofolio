<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;
use Auth;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Broadcast::routes(['middleware' => ['web','auth:admin,api']]);
        // require base_path('routes/channels.php');

        // if (Auth::guard('admin')->check()) {
          // Broadcast::channel('App.Models.Admin.{id}', function ($admin, $id) {
          //     // return (int) $user -> id === (int) $id;
          //     // if(get_class($user) === 'App\Models\Admin' && ((int) $user->id === (int) $id)) {
          //           // return $admin->id === $id && get_class($admin) === 'App\Models\Admin';
          //             return true;
          //     //     }
          //     //
          //     // return false;
          // });

          Broadcast::channel('App.User.{id}', function ($user, $id) {
              // return (int) $user -> id === (int) $id;
              return true;
          });

        // }

      //   Broadcast::channel('App.User.{id}', function ($user, $id) {
      //       return $user->id === $id && get_class($user) === 'App\User';
      // });


    }
}
