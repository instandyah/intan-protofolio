<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Auth;

class headerController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:admin');
  }

  public function index()
  {


    $projects = Project::where('id_admin', Auth::id())->get();

    return view('layouts.header-admin', ['projects' => $projects]);

  }
}
