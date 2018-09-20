<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Auth;

class AdminLoginController extends Controller
{

  public function __construct()
  {
    $this->middleware(['guest:admin', 'guest'], ['except' => ['logout']]);

  }

  public function showLoginform()
  {
    return view('auth.admin-login');
  }

  public function login(Request $request)
  {
    $messages = [
      "email.required" => "Email harus diisi",
      "email.exists" => "Email tidak terdaftar",
      "password.required" => "Password is required",
      "password.min" => "Minimal password harus 6 karakter"
    ];


    // Validate the form data
    $validator = Validator::make($request->all(), [
      'email' => 'required|email|exists:admin,email',
      'password' => 'required|min:6'
    ], $messages);


    if ($validator->fails()) {
      return back()->withErrors($validator)->withInput();
    } else {
      // Attempt to log the user in
      if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
        // return $request -> password;
        return redirect()->intended(route('admin.menu'));
      }

      // if unsuccessful, then redirect back to the login with the form data
      return redirect()->back()->withInput($request->only('email'))->withErrors([
        'password' => 'Password yang dimasukkan salah',
      ]);
    }
  }

  public function logout()
  {
    Auth::guard('admin')->logout();
    return redirect('/');
  }
}
