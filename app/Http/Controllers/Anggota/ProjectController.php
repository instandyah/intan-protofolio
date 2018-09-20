<?php

namespace App\Http\Controllers\Anggota;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\Anggota;
use Auth;

class ProjectController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

    public function index()
    {
      $projects = DB::table('anggota_project')
      ->join('project', 'anggota_project.id_project', '=', 'project.id_project')
      ->where('id_anggota', Auth::id())
      ->get();

      return view('anggota.project',['projects' => $projects]);
    }

    public function daftarAnggota($id_project)
    {
      $project = Project::find($id_project);

      $anggotas = DB::table('anggota_project')
      ->join('anggota', 'anggota_project.id_anggota', '=', 'anggota.id_anggota')
      ->where('id_project', $id_project)
      ->get();
      return view('anggota.daftar_anggota', ['anggotas' => $anggotas, 'project' => $project]);
    }

    public function daftarAdmin($id_project)
    {
      $project = Project::find($id_project);

      $admins = DB::table('project_detail')
      ->leftJoin('admin', 'admin.id_admin', '=', 'project_detail.id_admin')
      ->select('id_project', 'name', 'email', 'project_detail.created_at as tglgabung')
      ->where('id_project', $id_project)
      ->get();
      return view('anggota.daftar_admin', ['admins' => $admins, 'project' => $project]);

    }

    public function formEditAnggota($id_anggota)
    {
      $anggota = Anggota::find($id_anggota);
      return view('anggota.editprofile', ['anggota' => $anggota]);
    }

    public function editAnggotaProfil(Request $request, $id_anggota)
    {
      $messages = [
        "username.max" => "Maksimal karakter 25",
        "username.required" => "Nama harus diisi",
        "password.required" => "Password harus diisi",
        "password.min" => "Minimal password harus 6 karakter"
      ];
        $this->validate($request, [
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ], $messages);

        $anggota = Anggota::find($id_anggota);
        $anggota -> username = $request -> username;
        $anggota -> password = bcrypt($request -> password);
        $anggota -> save();
    return $request->all();
    }


}
