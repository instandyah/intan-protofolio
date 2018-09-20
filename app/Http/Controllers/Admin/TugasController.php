<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;
use App\Models\Tugas;
use App\Models\Subtugas;
use Illuminate\Support\Facades\DB;
use App\Notifications\NotifyAdmin;
use App\Models\Admin;
use App\Models\Project;
use Illuminate\Support\Collection;
use Auth;


class TugasController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:admin');
  }

  public function createTugas(Request $request, $id_project)
  {
    $messages = [
      "nama_tugas.required" => "Nama tugas harus diisi",
      "nama_tugas.unique" => "Nama tugas sudah ada"
    ];

    $this->validate( $request, [
      'nama_tugas' => 'required|unique:tugas',
    ], $messages);

    $tugas = new Tugas;
    $tugas -> nama_tugas = $request -> nama_tugas;
    $tugas -> id_project = $id_project;
    $tugas -> dibuat_oleh = Auth::user()->name;
    $tugas -> save();

    $admins = DB::table('project_detail')
    ->select('id_admin')
    ->where([
      ['id_project', $id_project],
      ['id_admin', '!=', Auth::id()]
      ])->get();

      // $result = json_decode(json_encode($admins, true));
      $tugas->setAttribute('text', 'tugas baru sudah dibuat '.$tugas -> nama_tugas.' oleh '. Auth::user()->name);
      $tugas->setAttribute('type', 'create');
      $this->notifikasi($admins, $tugas);
    // return redirect(route('project.select', ['id_project' => $id_project ]));
  }

  public function selectTugas($id_tugas)
  {
    // $tugas = Tugas::find($id_tugas);
    $tugas = DB::table('tugas')
          ->leftjoin('admin', 'admin.id_admin', '=', 'tugas.Pj')
          ->select('id_tugas', 'nama_tugas', 'tugas.created_at', 'id_project', 'dibuat_oleh', 'Pj', 'name')
          ->where('id_tugas', '=', $id_tugas)
          ->get();
        // return $tugas;
    $subtugas = Subtugas::where('id_tugas', $id_tugas)->get();
    $project = DB::table('project')
          ->leftjoin('project_detail', 'project_detail.id_project', 'project.id_project')
          ->leftjoin('admin', 'project_detail.id_admin', 'admin.id_admin')
          ->where('project.id_project', '=', $tugas[0]-> id_project)
          ->get();
          // return $project;

    if ($project[0] -> nama_penanggungjawab == Auth::user() -> name) {
      $realpj = true;
    } else {
      $realpj = false;
    }

    if ($project[0] -> nama_penanggungjawab == Auth::user() -> name) {
      $enable = true;
    } else {
      $enable = false;
    }

    return view('admin.tugas', ['tugas' => $tugas[0], 'subtugas' => $subtugas, 'enable' => $enable, 'realpj' => $realpj, 'listadmins' => $project]);
  }

  public function editpjpj(Request $request, $id_tugas)
  {
    // return $id_tugas;
    $idadmin = DB::table('admin')
              ->where('name', '=', $request -> penanggungjawab)
              ->get();
    // return $idadmin[0] -> id_admin;
    $penanggungjwb = DB::table('tugas')
        ->where('id_tugas', '=', $id_tugas)
        ->update([
          'Pj' => $idadmin[0] -> id_admin
        ]);

      
  }


  public function editTugas(Request $request, $id_tugas)
  {
    $messages = [
      "nama_tugas.required" => "Nama tugas harus diisi",
      "nama_tugas.unique" => "Nama tugas sudah ada"
    ];

    $this->validate( $request, [
      'nama_tugas' => 'required|unique:tugas',
    ], $messages);

      $selecttugas = Tugas::find($id_tugas);
      $id_project = $selecttugas -> id_project;
      $admin_project = Project::find($id_project);
      if ($admin_project -> nama_penanggungjawab == Auth::user() -> name) {
        $tugas = $selecttugas;
        $tugas -> nama_tugas = $request -> nama_tugas;
        $tugas -> save();

        $admins = DB::table('project_detail')
        ->select('id_admin')
        ->where([
          ['id_project', $tugas -> id_project],
          ['id_admin', '!=', Auth::id()]
          ])->get();
        $admin = Admin::find(Auth::id());

          // $result = json_decode(json_encode($admins, true));
          $tugas->setAttribute('text', 'tugas '.$tugas-> nama_tugas.' di edit oleh '. Auth::user()->name);
          $tugas->setAttribute('type', 'edit');

        $this->notifikasi($admins, $tugas);
        if ($request -> jenis !== null) {
          return redirect(route('tugas.select', ['id_tugas' => $id_tugas]));
        } else {
          return $tugas;
        }


      } else {
        $konfirmasi = "edit";
        $selecttugas->setAttribute('namatugas_baru', $request -> nama_tugas);
        $this->sendkonfdelete($selecttugas, $admin_project, $konfirmasi);
        return $adminproyek = ([ 'jenis' => 'edit', 'admin' => $admin_project -> nama_penanggungjawab ]);
      }
      // return redirect(route('tugas.select', ['id_tugas' => $id_tugas ]));
  }

  public function deleteTugas($id_tugas)
  {
    $selecttugas = Tugas::find($id_tugas);
    $id_project = $selecttugas -> id_project;
    $admins = DB::table('project_detail')
    ->select('id_admin')
    ->where([
      ['id_project', $id_project],
      ['id_admin', '!=', Auth::id()]
      ])->get();

      $project = Project::find($id_project);
      $tugas = $selecttugas;
      if ($project -> nama_penanggungjawab == Auth::user() -> name) {
        $tugas->setAttribute('text', 'tugas '.$tugas -> nama_tugas.' sudah dihapus dari project '.$project -> nama_project.' oleh '. Auth::user()->name);
        $tugas->setAttribute('type', 'delete');
        $this->notifikasi($admins, $tugas);
        $tugas->delete();
        return redirect(route('project.select', ['id_project' => $id_project ]));
      } else {
        $konfirmasi = "delete";
        $this->sendkonfdelete($tugas, $project, $konfirmasi);
        return redirect()->back()->with('message', 'Permintaan hapus tugas terkirim');
      }

      // $result = json_decode(json_encode($admins, true));
  }

  public function sendkonfdelete($tugas, $project, $jenis)
  {
    $admins = Admin::where('name', $project -> nama_penanggungjawab)->first();
    switch ($jenis) {
      case "delete":
          $tugas->setAttribute('text', 'Permintaan penghapusan tugas '.$tugas -> nama_tugas.' dari project '.$project -> nama_project.' oleh '. Auth::user()->name);
          $tugas->setAttribute('type', 'konfirm');
          Notification::send($admins, new NotifyAdmin($tugas));
        break;

      case "edit":
          $tugas->setAttribute('text', 'Permintaan perubahan tugas '.$tugas -> nama_tugas.' menjadi '.$tugas -> namatugas_baru.' pada project '.$project -> nama_project.' oleh '. Auth::user()->name);
          $tugas->setAttribute('type', 'konfirm');
          Notification::send($admins, new NotifyAdmin($tugas));
        break;

      default:
        // code...
        break;
    }
  }

  public function tolakkonfirmasi(Request $request)
  {
    if ($request -> jenis == 'hapus') {
      $tugas = Tugas::find($request -> id_tugas);
      $admins = Admin::find($request -> id_admin);
      $tugas->setAttribute('text', 'Permintaan penghapusan tugas '.$tugas -> nama_tugas.' ditolak oleh '.Auth::user() -> name);
      $tugas->setAttribute('type', 'edit');
      Notification::send($admins, new NotifyAdmin($tugas));
      return redirect(route('notif.all'))->with('message', 'Permintaan hapus tugas ditolak');
    } else {
      $tugas = Tugas::find($request -> id_tugas);
      $admins = Admin::find($request -> id_admin);
      $tugas->setAttribute('text', 'Permintaan edit tugas '.$tugas -> nama_tugas.' ditolak oleh '.Auth::user() -> name);
      $tugas->setAttribute('type', 'edit');
      Notification::send($admins, new NotifyAdmin($tugas));
      return redirect(route('notif.all'))->with('message', 'Permintaan edit tugas ditolak');
    }
  }

  public function notifikasi($admins, $tugas)
  {
    $admins2 = [];
    foreach ($admins as $adminn) {
      array_push($admins2, $adminn -> id_admin);
    }
    $adms = Admin::find($admins2);
    Notification::send($adms, new NotifyAdmin($tugas));
  }
}
