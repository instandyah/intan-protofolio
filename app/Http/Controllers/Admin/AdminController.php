<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;


class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('admin.menu');

    }
    public function formEdit($id_admin)
    {
      $admin = Admin::find($id_admin);
      return view('admin.editprofile', ['admin' => $admin]);
    }

    public function updateAdmin(Request $request, $id_admin)
    {
      $messages = [
        "name.max" => "Maksimal karakter 25",
        "name.required" => "Nama harus diisi",
        "email.required" => "Email harus diisi",
        "email.email" => "Format email salah",
        "password.required" => "Password harus diisi",
        "password.min" => "Minimal password harus 6 karakter"
      ];
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ], $messages);

        $selectadmin = Admin::where('id_admin', $id_admin)->first();

        DB::table('anggota')
        ->where('dibuat_oleh', $selectadmin -> name)
        ->update(['dibuat_oleh' => $request -> name]);

        DB::table('anggota_project')
        ->where('dibawa_oleh', $selectadmin -> name)
        ->update(['dibawa_oleh' => $request -> name]);
        //
        DB::table('tugas')
        ->where('dibuat_oleh', $selectadmin -> name)
        ->update(['dibuat_oleh' => $request -> name]);

        DB::table('project')
        ->where('nama_penanggungjawab', $selectadmin -> name)
        ->update(['nama_penanggungjawab' => $request -> name]);

        $admin = Admin::find($id_admin);
        $admin -> name = $request -> name;
        $admin -> email = $request -> email;
        $admin -> password = bcrypt($request -> password);
        $admin -> save();



        return $admin;
    }


}
