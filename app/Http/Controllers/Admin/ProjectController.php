<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Models\Project;
use App\Models\ProjectDetail;
use App\Models\AnggotaProject;
use App\Models\Anggota;
use App\Models\Tugas;
use App\Models\PembagianTugas;
use App\Notifications\ProjectNotifyAdmin;
use App\Models\Admin;
use Auth;

class ProjectController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:admin');
  }

  public function index()
  {


    $projects = DB::table('project_detail')
    ->join('project', 'project_detail.id_project', '=', 'project.id_project')
    ->where('id_admin', Auth::id())
    ->get();

    // $projects = Project::where('id_admin', )->get();

    return view('admin.project', ['projects' => $projects]);

  }


  public function createProject(Request $request)
  {

    $messages = [
      "nama_project.required" => "Nama project harus diisi",
      "nama_project.unique" => "Nama tugas sudah ada",
      "nama_penanggungjawab.required" => "Nama penanggung jawab harus diisi"
    ];

    $this->validate( $request, [
      'nama_project' => 'required|unique:project',
      'nama_penanggungjawab' => 'required',
    ], $messages);

    $projects =new Project;
    $projects -> nama_project = $request-> nama_project;
    $projects -> nama_penanggungjawab = $request -> nama_penanggungjawab;
    $projects -> kode_project = str_random(7);
    $projects -> save();

    //pake eloquent
    // $projectdetail = new ProjectDetail;
    // $projectdetail -> id_project = $id_projectnya;
    // $projectdetail -> id_admin = Auth::id();
    // $projectdetail -> save();

    DB::table('project_detail')->insert([
    [
    'id_project' => $projects -> id_project,
    'id_admin' => Auth::id(),
    'created_at' => $projects -> created_at]
    ]);



    return 'done';


  }

  public function selectProject($id_project)
  {
    $projects = Project::find($id_project);
    // $anggota = Anggota::where('id_project', $id_project)->get();
    $anggota = DB::table('anggota_project')
              ->leftJoin('anggota', 'anggota_project.id_anggota', '=', 'anggota.id_anggota')
              ->leftJoin('project', 'anggota_project.id_project', '=', 'project.id_project')
              ->select('anggota_project.id_project', 'nama_project', 'anggota_project.id_anggota', 'username')
              ->where('anggota_project.id_project', $id_project)
              ->get();
    $tugas = Tugas::where('id_project', $id_project)->get();

    $totalbobot = DB::table('aktivitas')
                  ->leftJoin('pembagian_tugas', 'pembagian_tugas.id_pembagian', '=', 'aktivitas.id_pembagian')
                  ->leftJoin('sub_tugas', 'pembagian_tugas.id_subtugas', '=', 'sub_tugas.id_subtugas')
                  ->leftJoin('tugas', 'tugas.id_tugas', '=', 'sub_tugas.id_tugas')
                  ->leftJoin('project', 'project.id_project', '=', 'tugas.id_project')
                  ->where('project.id_project', $id_project)
                  ->sum('bobot');

    $totalbobotselesai = DB::table('aktivitas')
                      ->leftJoin('pembagian_tugas', 'pembagian_tugas.id_pembagian', '=', 'aktivitas.id_pembagian')
                      ->leftJoin('sub_tugas', 'pembagian_tugas.id_subtugas', '=', 'sub_tugas.id_subtugas')
                      ->leftJoin('tugas', 'tugas.id_tugas', '=', 'sub_tugas.id_tugas')
                      ->leftJoin('project', 'project.id_project', '=', 'tugas.id_project')
                      ->where([
                        ['project.id_project', $id_project],
                        ['status', '=', 'Selesai']
                      ])
                      ->sum('bobot');

        if ($totalbobot == 0) {
          $persentase = 0;
        } else {
          $persen = $totalbobotselesai / $totalbobot * 100;
          $persentase = number_format($persen);
        }

    $anggotaproject = $anggota;
    $idanggotas = [];
    for ($i = 0; $i < count($anggotaproject); $i++) {
      array_push($idanggotas, $anggotaproject[$i] -> id_anggota);
    }

    $anggotaexist = DB::table('anggota')
                    ->leftJoin('anggota_project', 'anggota_project.id_anggota', '=', 'anggota.id_anggota')
                    ->select('anggota.id_anggota', 'username', 'anggota.created_at', 'dibuat_oleh')
                    ->whereNotIn('anggota.id_anggota', $idanggotas)
                    ->where(function ($query) use ($id_project) {
                      $query->where('id_project','!=', $id_project)
                            ->orWhereNull('anggota_project.id_project');
                    })
                    ->groupBy('id_anggota')
                    ->get();
    if ($projects -> nama_penanggungjawab == Auth::user() -> name) {
      $enable = true;
    } else {
      $enable = false;
    }

    $adminlist = DB::table('project_detail')
    ->leftJoin('admin', 'admin.id_admin', '=', 'project_detail.id_admin')
    ->leftJoin('project', 'project.id_project', '=', 'project_detail.id_project')
    ->where('project_detail.id_project', $id_project)
    ->orderBy('name')
    ->get();

    if ($adminlist[0] -> nama_penanggungjawab == Auth::user() -> name) {
      $enableadd = 'yes';

    } else {
      $enableadd = 'no';
    }
    // return $enabledelete;
    $adminlistarray = $adminlist;
    if ($adminlistarray->contains('id_admin', Auth::id())) {
      return view('admin.dashboard', ['projects' => $projects, 'anggota' => $anggota, 'tugas' => $tugas, 'anggotaexist' => $anggotaexist, 'enable' => $enable, 'adminlist' => $adminlist, 'persentase' => $persentase, 'enableadd' => $enableadd]);
    } else {
      dd('data not found');
    }
  }

  public function editProject(Request $request, $id_project)
  {
    $messages = [
      "nama_project.required" => "Nama project harus diisi",
      "nama_penanggungjawab.required" => "Nama penanggung jawab harus diisi"
    ];

    $this->validate( $request, [
      'nama_project' => 'required',
      'nama_penanggungjawab' => 'required',
    ], $messages);

    $projects = Project::find($id_project);
    $projects -> nama_project = $request -> nama_project;
    $projects -> nama_penanggungjawab = $request -> nama_penanggungjawab;
    $projects -> save();

    $adms = DB::table('project_detail')
            ->where([
              ['id_project', $id_project],
              ['id_admin', '!=', Auth::id()]
            ])
            ->get();
    $adms2 = [];
    foreach ($adms as $admss) {
      array_push($adms2, $admss -> id_admin);
    }
    $admins = Admin::find($adms2);
    $projects->setAttribute('text', 'Proyek '.$projects -> nama_project.' telah diedit oleh '.Auth::user() -> name);
    $projects->setAttribute('type', 'edit');
    $this->notifikasi($admins, $projects);
    return $projects;
  }

  public function deleteProject(Request $request)
  {
    // dd($request -> id_project);
    $projects = Project::find($request -> id_project);
    $adms = DB::table('project_detail')
            ->where([
              ['id_project', $request -> id_project],
              ['id_admin', '!=', Auth::id()]
            ])
            ->get();
    $adms2 = [];
    foreach ($adms as $admss) {
      array_push($adms2, $admss -> id_admin);
    }
    $admins = Admin::find($adms2);
    if ($projects -> nama_penanggungjawab == Auth::user() -> name) {
      $projects->setAttribute('text', 'Proyek '.$projects -> nama_project.' telah dihapus oleh '.Auth::user() -> name);
      $projects->setAttribute('type', 'delete');
      $this->notifikasi($admins, $projects);
      $projects->delete();
        return redirect(route('admin.projectlist'));
    } else {
      $this->sendkonfdelete($request -> id_project, $projects);
      return redirect()->back()->with('message', 'Permintaan hapus proyek terkirim');
    }

  }

  public function sendkonfdelete($id_project, $projects)
  {

    $admins = Admin::where('name', $projects -> nama_penanggungjawab)->first();
    $projects->setAttribute('text', 'Permintaan penghapusan proyek '.$projects -> nama_project.' oleh '.Auth::user() -> name);
    $projects->setAttribute('type', 'konfirm');
    $this->notifikasi($admins, $projects);

  }

  public function tolakkonfirmasi(Request $request)
  {
    $projects = Project::find($request -> id_project);
    $admins = Admin::find($request -> id_admin);
    $projects->setAttribute('text', 'Permintaan penghapusan proyek '.$projects -> nama_project.' ditolak oleh '.Auth::user() -> name);
    $projects->setAttribute('type', 'edit');
    $this->notifikasi($admins, $projects);
    return redirect(route('notif.all'))->with('message', 'Permintaan hapus proyek ditolak');;
  }

  public function projectDetail($id_project)
  {
    $adminlist = DB::table('project_detail')
    ->leftJoin('project', 'project.id_project', '=', 'project_detail.id_project')
    ->leftJoin('admin', 'admin.id_admin', '=', 'project_detail.id_admin')
    ->select('project.id_project as id_projectku', 'project.nama_project as nama_project', 'nama_penanggungjawab', 'admin.id_admin as id_admin', 'name', 'email', 'project_detail.created_at as tglgabung')
    ->where([
      ['project_detail.id_project', $id_project],
      ['project_detail.id_admin', '!=',  Auth::id()]
    ])
    ->get();
    if ($adminlist !== null) {
      if ($adminlist[0] -> nama_penanggungjawab == Auth::user() -> name) {
        $enable = true;
      } else {
        $enable = false;
      }
    } else {
      $enable = false;
    }


    return view('admin.detail_proyek', ['adminlist' => $adminlist, 'id_project' => $id_project, 'enable' => $enable]);
  }

  public function deleteAdminProyek(Request $request)
  {

    $adms = $adms = DB::table('project_detail')
            ->where([
              ['id_project', $request -> id_project],
              ['id_admin', '!=', Auth::id()],
              ['id_admin', '!=', $request -> id_admin]
            ])
            ->get();
    $adms2 = [];
    foreach ($adms as $admss) {
      array_push($adms2, $admss -> id_admin);
    }
    $admn = Admin::find($request -> id_admin);
    $prjct = Project::find($request -> id_project);

    $admins = Admin::find($adms2);
    $prjct->setAttribute('text', 'Admin '.$admn -> nama_admin.' telah dikeluarkan dari proyek '.$prjct -> nama_project.' oleh '.Auth::user() -> name);
    $prjct->setAttribute('type', 'edit');
    $this->notifikasi($admins, $prjct);

    $prjct->setAttribute('text', 'Anda telah dikeluarkan dari proyek '.$prjct -> nama_project.' oleh '.Auth::user() -> name);
    $prjct->setAttribute('type', 'delete');
    $this->notifikasi($admn, $prjct);

    $exactadmin = DB::table('project_detail')
    ->where([
      ['id_admin', $request -> id_admin],
      ['id_project', $request -> id_project]
      ])->delete();

      return $exactadmin;
  }

  public function addKode(Request $request)
  {
    $messages = [
      "kode_project.required" => "Kode project harus diisi",
      "kode_project.exists" => "Kode project tidak ada",
    ];

    $this->validate( $request, [
      'kode_project' => 'required|exists:project,kode_project',
    ], $messages);
    //
    $selectproject = Project::where('kode_project', $request -> kode_project)->first();
    $addproject = ProjectDetail::where(['id_project' => $selectproject -> id_project, 'id_admin' => $request -> id_admin])->first();

    if (!($addproject == '')) {
      return 'already in';
    } else {
      DB::table('project_detail')->insert([
        [
        'id_project' => $selectproject -> id_project,
        'id_admin' => $request -> id_admin,
        'created_at' => DB::raw('CURRENT_TIMESTAMP')
        ]
      ]);

      $adms = $adms = DB::table('project_detail')
              ->where([
                ['id_project', $selectproject -> id_project],
                ['id_admin', '!=', Auth::id()],
              ])
              ->get();
      $adms2 = [];
      foreach ($adms as $admss) {
        array_push($adms2, $admss -> id_admin);
      }

      $admins = Admin::find($adms2);
      $selectproject->setAttribute('text', 'Admin pada proyek '.$selectproject -> nama_project.' baru saja bergabung');
      $selectproject->setAttribute('type', 'edit');
      $this->notifikasi($admins, $selectproject);


      return 'berhasil';
    }
    // return $addproject;
  }


  public function deleteAnggotasProject(Request $request)
  {
    $pembagianrecord = PembagianTugas::where('id_PJ2', $request -> id_anggota)->get();

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



    $pembagianrecordPJ1 = PembagianTugas::where('id_PJ1', $request -> id_anggota)->get();

    if (!($pembagianrecordPJ1 -> isEmpty())) {
      $listidpembagian2 = [];
      for ($i = 0; $i < count($pembagianrecordPJ1); $i++) {
        array_push($listidpembagian2, $pembagianrecordPJ1[$i] -> id_pembagian);
      }
      DB::table('pembagian_tugas')
      ->whereIn('id_pembagian', $listidpembagian2)
      ->update([
        'id_PJ1' => NULL,
        'id_PJ2' => NULL
      ]);
    }

    $adms = $adms = DB::table('project_detail')
            ->where([
              ['id_project', $request -> id_project],
              ['id_admin', '!=', Auth::id()],
            ])
            ->get();
    $adms2 = [];
    foreach ($adms as $admss) {
      array_push($adms2, $admss -> id_admin);
    }

    $prjct = Project::find($request -> id_project);
    $anggt = Anggota::find($request -> id_anggota);

    $admins = Admin::find($adms2);
    $prjct->setAttribute('text', $anggt -> username.' baru saja dikeluarkan dari proyek '.$prjct -> nama_project.' oleh '.Auth::user() -> name);
    $prjct->setAttribute('type', 'edit');
    $this->notifikasi($admins, $prjct);

    $exactanggota = DB::table('anggota_project')
    ->where([
      ['id_anggota', $request -> id_anggota],
      ['id_project', $request -> id_project]
      ])->delete();

      // return redirect(route('project.select', ['id_project' => $request -> id_project]));
  }



  public function notifikasi($adms, $project)
  {
    Notification::send($adms, new ProjectNotifyAdmin($project));

  }
}
