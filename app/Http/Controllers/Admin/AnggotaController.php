<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Models\Anggota;
use App\Models\PembagianTugas;
use App\Models\AnggotaProject;
use App\Models\Project;
use App\Notifications\AnggotaNotifyAdmin;
use App\Notifications\ProjectNotifyAdmin;
use App\Models\Admin;
use Auth;

class AnggotaController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:admin');
  }

  public function index()
  {

    $anggota = Anggota::all();

    return view('admin.akunanggota', ['anggota' => $anggota]);

  }

  public function createAnggota(Request $request)
  {
    $messages = [
      "username.required" => "Username harus diisi",
      "username.unique" => "Username sudah ada",
      "password.required" => "Password harus diisi"
    ];

    $this->validate( $request, [
      'username' => 'required|min:6|unique:anggota',
      'password' => 'required|min:6',
    ], $messages);

    $anggota = new Anggota;
    $anggota -> username = $request -> username;
    $anggota -> password = bcrypt($request -> password);
    $anggota -> dibuat_oleh = Auth::user()->name;
    $anggota -> save();

    $anggota->setAttribute('text', '1 anggota telah ditambahkan oleh '.Auth::user() -> name);
    $anggota->setAttribute('type', 'create');
    $this->notifikasi($anggota);
    // return redirect(route('project.select', ['id_project' => $id_project ]));
  }

  public function selectAnggota($id_anggota)
  {
    $anggota = Anggota::find($id_anggota);
    $listproyek = DB::table('anggota_project')
                  ->join('anggota', 'anggota_project.id_anggota', '=', 'anggota.id_anggota')
                  ->join('project', 'anggota_project.id_project', '=', 'project.id_project')
                  ->select('anggota_project.id_project', 'nama_project', 'nama_penanggungjawab', 'anggota_project.id_anggota', 'username', 'anggota_project.created_at', 'dibawa_oleh')
                  ->where('anggota.id_anggota', $id_anggota)
                  ->get();
    if ($anggota -> dibuat_oleh == Auth::user() -> name) {
      $penanggungjwb = 'ya';
    } else {
      $penanggungjwb = 'tidak';
    }

    foreach ($listproyek as $key => $listpj) {
      if ($listpj -> nama_penanggungjawab == Auth::user() -> name) {
        $listpj->pjproyek = 'ya';
      } else {
        $listpj->pjproyek = 'tidak';
      }
    }



      // dd($listproyek);
    return view('admin.anggota_dashboard', ['anggota' => $anggota, 'listproyek' => $listproyek, 'penanggungjwb' => $penanggungjwb]);
  }

  public function editAnggota(Request $request, $id_anggota)
  {

    $messages = [
      "username.required" => "Username harus diisi",
      "password.required" => "Password harus diisi"
    ];

    $this->validate( $request, [
      'username' => 'required|min:6',
      'password' => 'required|min:6',
    ], $messages);

    //
    $anggota = Anggota::find($id_anggota);
    $anggota -> username = $request -> username;
    $anggota -> password = bcrypt($request -> password);
    $anggota -> save();


    $anggota->setAttribute('text', $anggota -> username .' telah diedit');
    $anggota->setAttribute('type', 'edit');
    $this->notifikasi($anggota);

return $anggota;

  }

  public function deleteAnggota($id_anggota)
  {
    $pembagianrecord = PembagianTugas::where('id_PJ2', $id_anggota)->get();

    if (!($pembagianrecord -> isEmpty())) {
      $listidpembagian = [];
      for ($i = 0; $i < count($pembagianrecord); $i++) {
        array_push($listidpembagian, ['id_pembagian' => $pembagianrecord[$i]-> id_pembagian, 'id_PJ2 '=> $pembagianrecord[$i]-> id_PJ1]);
      }

      $updateColumn = array_keys($listidpembagian[0]);
      $referenceColumn = $updateColumn[0]; //e.g id
      unset($updateColumn[0]);
      $whereIn = "";
      $q = "UPDATE pembagian_tugas SET ";
      foreach ( $updateColumn as $uColumn ) {
        $q .=  $uColumn." = CASE ";

        foreach( $listidpembagian as $data ) {
          $q .= "WHEN ".$referenceColumn." = ".$data[$referenceColumn]." THEN ".$data[$uColumn]." ";
        }
        $q .= "ELSE ".$uColumn." END, ";
      }
      foreach( $listidpembagian as $data ) {
        $whereIn .= "".$data[$referenceColumn].", ";
      }
      $q = rtrim($q, ", ")." WHERE ".$referenceColumn." IN (".  rtrim($whereIn, ', ').")";

      // Update
      DB::update(DB::raw($q));
    }

    //update yang ga efektif
    // for ($j=0; $j < count($lisidpj2) ; $j++) {
    //   $tugas = PembagianTugas::find($listidpembagian[$j]);
    //   $tugas -> id_PJ2 = $lisidpj2[$j];
    //   $tugas -> save();
    // }
    $anggota = Anggota::find($id_anggota);

    $anggota->setAttribute('text', $anggota -> username .' telah dihapus');
    $anggota->setAttribute('type', 'delete');
    $this->notifikasi($anggota);


    // $selectanggota = AnggotaProject::where('id_anggota', $id_anggota)->first();
    // $id_project = $selectanggota -> id_project;
    // $anggota = Anggota::find($id_anggota);
    $anggota->delete();//main delete
    return redirect(route('admin.anggotalist'));

  }

  public function addExistAnggota(Request $request, $id_project)
  {
    // return $id_project;
    $idanggotas = $request ->get('anggotadipilih');
    $tambahanggota = DB::table('anggota')
                    ->select('id_anggota', 'username')
                    ->whereIn('id_anggota', $idanggotas)
                    ->get();

    $inputanggota = [];

    for ($i = 0; $i < count($tambahanggota); $i++) {
      array_push($inputanggota, ['id_project' => $id_project, 'id_anggota' => $tambahanggota[$i] -> id_anggota, 'dibawa_oleh' => Auth::user()->name, 'created_at' => DB::raw('CURRENT_TIMESTAMP') ]);
    }

    AnggotaProject::insert($inputanggota);
//notifikasi
    $admins = DB::table('project_detail')
              ->select('id_admin')
              ->where([
                ['id_project', $id_project],
                ['id_admin', '!=', Auth::id()]
              ])
              ->get();

    $admins2 = [];
    foreach ($admins as $adminn) {
      array_push($admins2, $adminn -> id_admin);
    }
    $adms = Admin::find($admins2);

    $project = Project::find($id_project)->first();
    $project->setAttribute('text', count($tambahanggota).' anggota telah ditambahkan pada proyek '.$project -> nama_project.' oleh '.Auth::user() -> name);
    $project->setAttribute('type', 'edit');

    Notification::send($adms, new ProjectNotifyAdmin($project));

    return 'sukses';
  }

  public function notifikasi($anggota)
  {
    $adms = Admin::where('id_admin', '!=', Auth::id())->get();
    Notification::send($adms, new AnggotaNotifyAdmin($anggota));

  }

}
