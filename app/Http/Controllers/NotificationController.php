<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Auth;

class NotificationController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:admin,web');
  }
    public function get()
    {
      // $user = Auth::check();
      // if ($user == Unauthorized) {
      //     return 'haii';
      // }

        $notification = Auth::user()->unreadNotifications;
       return $notification;
       // return Auth::id();


    }

    public function read(Request $request)
    {
      Auth::user()->notifications()->find($request -> id)->markAsRead();
      return 'success';
    }

    public function getall()
    {
      $notifications = Auth::user()->notifications()->get();
      // return $notifications;
      if (Auth::guard('admin')->check()) {
        return view('admin.notificationfull', ['notifications' => $notifications]);
      } else {
        return view('anggota.notificationfull2', ['notifications' => $notifications]);
      }


    }

    public function konfhapus($id)
    {
      $notification = Auth::user()->notifications()->where('id', $id)->first()->toArray();

      return view('admin.konfirmasi', ['notification' => $notification]);
    }
}
