<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class LoginController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Login Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles authenticating users for the application and
  | redirecting them to your home screen. The controller uses a trait
  | to conveniently provide its functionality to your applications.
  |
  */

  use AuthenticatesUsers;

  /**
  * Where to redirect users after login.
  *
  * @var string
  */
  protected $redirectTo = '/home';

  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct()
  {
    $this->middleware(['guest:admin', 'guest'], ['except' => ['logout', 'userLogout']]);
  }

  public function username()
  {
    return 'username';
  }

  public function validateLogin(Request $request)
  {
    $messages = [
      "username.required" => "Username harus diisi",
      "password.required" => "Password harus diisi",

    ];

    $this->validate($request, [
        $this->username() => 'required|string',
        'password' => 'required|string',
    ], $messages);
  }


  public function userLogout()
  {
    Auth::guard('web')->logout();
    return redirect('/');
  }


}
