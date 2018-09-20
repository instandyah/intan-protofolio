<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class indexController extends Controller
{
  public function __construct()
  {
    $this->middleware(['guest:admin', 'guest']);

  }
  public function index()
  {
      return view('auth.login');
  }
}
