<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Models\Anggota;
use App\Models\PembagianTugas;
use App\Models\Tugas;
use App\Models\Subtugas;
use App\Models\Admin;
use App\User;
use App\Notifications\PembagiantugasNotifyAdmin;
use Auth;
use Carbon\Carbon;

class BagiTugasController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:admin,web');
  }
  public function index()
  {

  }
  public function kirimtugas(Request $request)
  {
    $array = $request->get('value');
    //check di tugas tsb udah ada riwayat pembagian atau belum
    $listpembagian = DB::table('sub_tugas')
                    ->leftjoin('tugas', 'sub_tugas.id_tugas', '=', 'tugas.id_tugas')
                    ->leftjoin('pembagian_tugas', 'sub_tugas.id_subtugas', '=', 'pembagian_tugas.id_subtugas')
                    ->select('id_pembagian', 'sub_tugas.id_tugas', 'sub_tugas.id_subtugas')
                    ->whereIn('sub_tugas.id_tugas', $array)
                    ->get();
          $idpembagiantugasnull = [];//array untuk tugas yang tidak memiliki riwayat pembagian
          $idtidaknull =[];
          foreach($listpembagian as $child) {
              if ($child -> id_pembagian !== null) {
              array_push($idtidaknull, $child -> id_pembagian);
            } else {
              if(!in_array($child -> id_tugas, $idpembagiantugasnull)){//mastiin yang masuk ke array pembagiantugasnull gaada yg duplicate sm di $idtidaknull
                $idpembagiantugasnull[] = $child -> id_tugas;
              }
            }
          }

          if (array_filter($idtidaknull)) {//cek ada isinya ga
            DB::table('pembagian_tugas')
            ->whereIn('id_pembagian', $idtidaknull)
            ->update([
              'id_PJ1' => $request -> id_anggota,
              'id_PJ2' => $request -> id_anggota
            ]);
          }

          if (array_filter($idpembagiantugasnull)) {
            $subtugascall = DB::table('sub_tugas')
            ->leftJoin('tugas', 'tugas.id_tugas', '=', 'sub_tugas.id_tugas')
            ->select('sub_tugas.id_tugas', 'nama_tugas', 'id_subtugas', 'nama_subtugas')
            ->whereIn('sub_tugas.id_tugas', $idpembagiantugasnull)
            ->get();
            $lastpembagian = DB::table('pembagian_tugas')->max('id_pembagian');

            $sbtugases = [];

            for ($i = 0; $i < count($subtugascall); $i++) {
              array_push($sbtugases, ['id_subtugas' => $subtugascall[$i] -> id_subtugas , 'id_PJ1' => $request -> id_anggota, 'id_PJ2' => $request -> id_anggota ]);
            }

            PembagianTugas::insert($sbtugases);
            if ($lastpembagian == null) {
              $newestpembagian = DB::table('pembagian_tugas')
                                ->get();
              // return $newestpembagian;
              $masukinaktivitas = [];
              for ($j = 0; $j < count($newestpembagian); $j++) {
                array_push($masukinaktivitas, ['id_pembagian' => $newestpembagian[$j] -> id_pembagian]);
              }

              DB::table('aktivitas')->insert($masukinaktivitas);
            } else {
              $newestpembagian = DB::table('pembagian_tugas')
                          ->where('id_pembagian', '>', $lastpembagian)
                          ->get();

              $masukinaktivitas = [];
              for ($j = 0; $j < count($newestpembagian); $j++) {
                array_push($masukinaktivitas, ['id_pembagian' => $newestpembagian[$j] -> id_pembagian]);
              }

              DB::table('aktivitas')->insert($masukinaktivitas);

            }


          }


    $tugas = Tugas::find($array[0]);
    $id_project = $tugas -> id_project;
    $pembagians = Anggota::find($request -> id_anggota);
    $pembagians->setAttribute('id_project', $id_project);
    $jenis = 'edit';
    $this->notifikasi($id_project, $pembagians, $request -> id_anggota, $jenis);

    return $idtidaknull;

  }

  public function selectAnggota($id_anggota, $id_project)
  {
    //ini buat subtugas
    $iniapa = DB::table('aktivitas')
    ->join('pembagian_tugas', 'aktivitas.id_pembagian', '=', 'pembagian_tugas.id_pembagian')
    ->join('anggota as a', 'a.id_anggota', '=', 'pembagian_tugas.id_PJ1')
    ->join('anggota as b', 'b.id_anggota', '=', 'pembagian_tugas.id_PJ2')
    ->join('sub_tugas', 'sub_tugas.id_subtugas', '=', 'pembagian_tugas.id_subtugas')
    ->join('tugas', 'sub_tugas.id_tugas', '=', 'tugas.id_tugas')
    ->select('id_aktivitas', 'aktivitas.id_pembagian', 'keterangan', 'confirm' ,'revisi_hit', 'deskripsi', 'tugas.id_tugas', 'nama_tugas', 'sub_tugas.id_subtugas', 'nama_subtugas', 'id_PJ1', 'a.username as username1', 'id_PJ2', 'b.username as username2', 'status', 'start_date', 'end_date', 'due_date', 'postpone_start', 'postpone_end', 'progress', 'confirm_progress', 'aktivitas.updated_at', 'bobot')
    ->where([
      ['id_PJ2', '=', $id_anggota],
      ['tugas.id_project', '=', $id_project],
    ])
    ->orWhere([
      ['id_PJ1', '=', $id_anggota],
      ['tugas.id_project', '=', $id_project]
    ])
    ->get();
    // return $iniapa;

    //ini buat tugas
    $pembagian = DB::table('aktivitas')
    ->join('pembagian_tugas', 'aktivitas.id_pembagian', '=', 'pembagian_tugas.id_pembagian')
    ->join('anggota as a', 'a.id_anggota', '=', 'pembagian_tugas.id_PJ1')
    ->join('anggota as b', 'b.id_anggota', '=', 'pembagian_tugas.id_PJ2')
    ->join('sub_tugas', 'sub_tugas.id_subtugas', '=', 'pembagian_tugas.id_subtugas')
    ->join('tugas', 'sub_tugas.id_tugas', '=', 'tugas.id_tugas')
    ->select('aktivitas.id_pembagian', 'id_PJ1', 'a.username as PJ1', 'id_PJ2', 'b.username as PJ2', 'tugas.id_tugas', 'nama_tugas')
    ->where([
      ['id_PJ2', '=', $id_anggota],
      ['tugas.id_project', '=', $id_project]
    ])
    ->orWhere([
      ['id_PJ1', '=', $id_anggota],
      ['tugas.id_project', '=', $id_project]
    ])
    ->groupBy('nama_tugas')
    ->get();

    //ini buat tugas tersedia

    $query = DB::table('tugas')
    ->leftJoin('sub_tugas', 'sub_tugas.id_tugas', "=", "tugas.id_tugas")
    ->leftJoin('pembagian_tugas', 'pembagian_tugas.id_subtugas', "=", "sub_tugas.id_subtugas")
    ->select('nama_tugas', 'tugas.id_tugas',  'id_project', 'id_PJ1')
    ->where('id_project', '=', $id_project)
    ->where(function ($query){
                $query->whereNull('id_pembagian')
                      ->orWhereNull('id_PJ1');
            })
    ->groupBy('nama_tugas', 'tugas.id_tugas')
    ->get();

    // $anggotas = Anggota::where('id_project', $id_project)->get();
    $anggotas = DB::table('anggota_project')
              ->leftJoin('anggota', 'anggota_project.id_anggota', '=', 'anggota.id_anggota')
              ->leftJoin('project', 'anggota_project.id_project', '=', 'project.id_project')
              ->leftJoin('project_detail', 'project_detail.id_project', '=', 'project.id_project')
              ->leftJoin('admin', 'admin.id_admin', '=', 'project_detail.id_admin')
              ->select('anggota_project.id_project', 'nama_project', 'anggota_project.id_anggota', 'username', 'nama_penanggungjawab', 'admin.id_admin', 'name')
              ->where('anggota_project.id_project', $id_project)
              ->get();

    $anggota = DB::table('anggota_project')
                  ->leftJoin('anggota', 'anggota_project.id_anggota', '=', 'anggota.id_anggota')
                  ->leftJoin('admin', 'admin.id_admin', 'anggota_project.penanggungjawab')
                  ->select('anggota_project.id_anggota', 'username', 'anggota_project.created_at', 'anggota_project.dibawa_oleh', 'anggota.dibuat_oleh', 'name', 'penanggungjawab')
                  ->where([
                    ['id_project', $id_project],
                    ['anggota_project.id_anggota', $id_anggota]
                  ])
                  ->first();
    // $anggota = Anggota::find($id_anggota);
    // dd($anggota);
    if ($anggotas[0] -> nama_penanggungjawab == Auth::user() -> name) {
      $enabledelete = 'yes';
    } else {
      $enabledelete = 'no';
    }

    $listadmin = $anggotas->unique('id_admin');
    $listadmins = $listadmin->values();

    $PJanggota = $anggotas->unique('nama_penanggungjawab');
    $PJang = $PJanggota->values();

    return view('admin.anggota', ['id_project' => $id_project, 'anggota' => $anggota, 'pembagian' => $pembagian, 'iniapa' => $iniapa, 'tugastersedia' => $query, 'anggotas' => $anggotas, 'enabledelete' => $enabledelete, 'listadmins' => $listadmins, 'PJanggota' => $PJang]);
  }

  public function editpjanggota(Request $request)
  {
    $idadmin = DB::table('admin')
              ->where('name', '=', $request -> penanggungjawab)
              ->get();
    // return $idadmin[0] -> id_admin;
    $penanggungjwb = DB::table('anggota_project')
        ->where([
          ['id_project', '=', $request -> id_project ],
          ['id_anggota', '=', $request -> id_anggota]])
        ->update([
          'penanggungjawab' => $idadmin[0] -> id_admin
        ]);

      $pembagians = Anggota::find($request -> id_anggota);
      $pembagians->setAttribute('id_project',$request -> id_project );
      $pembagians->setAttribute('nama_pjbaru', $request -> penanggungjawab);

      $jenis = 'editPJanggota';
      $this->notifikasi($request -> id_project, $pembagians, $request -> id_anggota, $jenis);
        return 'sukses';
  }

  public function deletePembagianTugas(Request $request)
  {
    $tugas = Tugas::find($request -> id_tugas);
    $id_project = $tugas -> id_project;
    $sub = Subtugas::where('id_tugas', '=', $request -> id_tugas)->first();
    $subtugas = PembagianTugas::where('id_subtugas', '=', $sub -> id_subtugas)->first();
    $pembagians = Anggota::find($subtugas -> id_PJ1);
    $pembagians->setAttribute('id_project', $id_project);
    $pembagians->setAttribute('nama_tugas', $tugas -> nama_tugas);
    $jenis = 'delete';
    $this->notifikasi($id_project, $pembagians, $subtugas -> id_PJ1, $jenis); //panggil notifikasi

    $q = 'DELETE pembagian_tugas FROM pembagian_tugas JOIN sub_tugas ON pembagian_tugas.id_subtugas = sub_tugas.id_subtugas JOIN tugas ON sub_tugas.id_tugas = tugas.id_tugas
    WHERE tugas.id_tugas = '.$request -> id_tugas.'';
    DB::delete($q);

    return 'sukses';
  }

  public function editPJTugas(Request $request)
  {
    $anggota = Anggota::where('username', $request-> nama_pj2)->first();
    $id_anggota = $anggota -> id_anggota;
    $pembagian = PembagianTugas::find($request -> id_pembagian);
    $pembagian -> id_PJ2 = $id_anggota;
    $pembagian -> save();

    $subtugas = Subtugas::find($pembagian -> id_subtugas);
    $tugas = Tugas::find($subtugas -> id_tugas);
    $id_project = $tugas -> id_project;

    $angs = [];
    array_push($angs, $id_anggota, $pembagian -> id_PJ1);

    $pembagians = Anggota::find($pembagian -> id_PJ1);
    $pembagians->setAttribute('id_project', $id_project);
    $pembagians->setAttribute('nama_subtugas', $subtugas -> nama_subtugas);
    $pembagians->setAttribute('username2', $request -> nama_pj2);
    $jenis = 'editPJ';
    $this->notifikasi($id_project, $pembagians, $angs, $jenis);
    return $angs;
  }

  public function editTanggal(Request $request)
  {
    // return $request->all();
    $aktivitas = DB::table('aktivitas')
                ->where('id_aktivitas', $request -> id_aktivitas)
                ->update([
                  'due_date' => Carbon::parse($request -> due_date),
                ]);

    $pembagian = DB::table('aktivitas')
                ->leftJoin('pembagian_tugas', 'pembagian_tugas.id_pembagian', '=', 'aktivitas.id_pembagian')
                ->leftJoin('sub_tugas', 'pembagian_tugas.id_subtugas', '=', 'sub_tugas.id_subtugas')
                ->leftJoin('tugas', 'tugas.id_tugas', '=', 'sub_tugas.id_tugas')
                ->where('id_aktivitas', $request -> id_aktivitas)
                ->get();

                $id_project = $pembagian[0] -> id_project;
                $pembagians = Anggota::find($pembagian[0] -> id_PJ1);
                $pembagians->setAttribute('id_project', $id_project);
                $pembagians->setAttribute('nama_subtugas', $pembagian[0] -> nama_subtugas);

                $jenis ='edit_tanggal';
                if ($pembagian[0] -> id_PJ1 !== $pembagian[0] -> id_PJ2) {
                  $idanggota = [];
                  array_push($idanggota, $pembagian[0] -> id_PJ2, $pembagian[0] -> id_PJ1);
                } else {
                  $idanggota = $pembagian[0] -> id_PJ1;
                }

                $this->notifikasi($id_project, $pembagians, $idanggota, $jenis);
                // return $pembagian -> id_PJ1;

  }

  public function buttonRevisi(Request $request)
  {
    $id_pembagian = $request -> id_pembagian;
    $tugases =  DB::select('SELECT id_aktivitas, aktivitas.id_pembagian, id_PJ1, a.username as PJ1, id_PJ2, b.username as PJ2, pembagian_tugas.id_subtugas, nama_subtugas, sub_tugas.id_tugas, nama_tugas, status, keterangan, revisi_hit FROM aktivitas
      JOIN pembagian_tugas ON aktivitas.id_pembagian = pembagian_tugas.id_pembagian
      JOIN anggota as a ON pembagian_tugas.id_PJ1 = a.id_anggota
      JOIN anggota as b ON pembagian_tugas.id_PJ2 = b.id_anggota
      JOIN sub_tugas ON pembagian_tugas.id_subtugas = sub_tugas.id_subtugas
      JOIN tugas ON sub_tugas.id_tugas = tugas.id_tugas,
      (SELECT MAX(id_aktivitas) as id_akt FROM aktivitas Group by id_pembagian) b
      WHERE pembagian_tugas.id_pembagian = '.$id_pembagian.' AND
      aktivitas.id_aktivitas = b.id_akt');

      // $revisi_hit = $tugases -> revisi_hit;

      $aktivitasnew1 =  DB::table('aktivitas')->insert([
        [ 'id_pembagian' => $tugases[0] -> id_pembagian,
          'keterangan' => 'revisi',
          'revisi_hit' => $tugases[0] -> revisi_hit + 1,
          'deskripsi' => $request -> deskripsi
        ]
      ]);

      $pembagian = PembagianTugas::find($id_pembagian);
      $subtugas = Subtugas::find($pembagian -> id_subtugas);
      $tugas = Tugas::find($subtugas -> id_tugas);
      $id_project = $tugas -> id_project;
      $pembagians = Anggota::find($pembagian -> id_PJ1);
      $pembagians->setAttribute('id_project', $id_project);
      $pembagians->setAttribute('nama_subtugas', $subtugas -> nama_subtugas);
      $jenis = 'revisi';
      $this->notifikasi($id_project, $pembagians, $pembagian -> id_PJ1, $jenis);


      return 'sukses';
  }

  public function batalrevisi(Request $request)
  {
    $pembagian = DB::table('aktivitas')
                ->leftJoin('pembagian_tugas', 'pembagian_tugas.id_pembagian', '=', 'aktivitas.id_pembagian')
                ->leftJoin('sub_tugas', 'pembagian_tugas.id_subtugas', '=', 'sub_tugas.id_subtugas')
                ->leftJoin('tugas', 'tugas.id_tugas', '=', 'sub_tugas.id_tugas')
                ->where('id_aktivitas', $request -> id_aktivitas)
                ->get();
    $id_project = $pembagian[0] -> id_project;
    $pembagians = Anggota::find($pembagian[0] -> id_PJ1);
    $pembagians->setAttribute('id_project', $id_project);
    $pembagians->setAttribute('nama_subtugas', $pembagian[0] -> nama_subtugas);
    $jenis ='batal_revisi';
    $this->notifikasi($id_project, $pembagians, $pembagian[0] -> id_PJ1, $jenis);

    $aktivitas = DB::table('aktivitas')
              ->where('id_aktivitas', $request -> id_aktivitas)
              ->delete();
    return 'delete revisi';
  }

  public function konfirmasi(Request $request)
  {
    // return $request -> status;
    if ($request -> status == 'Selesai') {
      $aktivitas = DB::table('aktivitas')
                  ->where('id_aktivitas', $request -> id_aktivitas)
                  ->update([
                    'confirm' => $request -> confirm,
                    'confirm_progress' => $request -> confirm,
                    'progress' => 100,
                    'updated_at' =>  DB::raw('CURRENT_TIMESTAMP')
                  ]);
    } else if ($request -> status == 'Dikerjakan'){
      $aktivitas = DB::table('aktivitas')
                  ->where('id_aktivitas', $request -> id_aktivitas)
                  ->update([
                    'confirm_progress' => $request -> confirm
                  ]);
    } else if ($request -> status == 'Ditunda') {
      $aktivitas = DB::table('aktivitas')
                  ->where('id_aktivitas', $request -> id_aktivitas)
                  ->update([
                    'confirm' => $request -> confirm,
                    'confirm_progress' => $request -> confirm,
                    'due_date' => null
                  ]);
    }

    $currentact = DB::table('aktivitas')
        ->leftJoin('pembagian_tugas', 'pembagian_tugas.id_pembagian', '=', 'aktivitas.id_pembagian')
        ->leftJoin('sub_tugas', 'pembagian_tugas.id_subtugas', '=', 'sub_tugas.id_subtugas')
        ->leftJoin('tugas', 'sub_tugas.id_tugas', 'tugas.id_tugas')
        ->where('id_aktivitas', $request -> id_aktivitas)
        ->first();
    $pembagian = PembagianTugas::find($currentact -> id_pembagian);
    $id_project = $currentact -> id_project;
    $pembagians = Anggota::find($pembagian -> id_PJ1);
    $pembagians->setAttribute('nama_subtugas', $currentact -> nama_subtugas);
    $pembagians->setAttribute('id_project', $id_project);
    $jenis = 'konfirmasi';

    $this->notifikasi($id_project, $pembagians, $pembagian -> id_PJ1, $jenis);
    // return $id_project;
  }

  public function notifikasi($id_project, $pembagian, $id_anggota, $jenis)
  {

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
    if (isset($adms)) {
      if ($jenis == 'edit') {
        $pembagian->setAttribute('text', 'Tugas baru ditambahkan pada anggota '.$pembagian -> username.' oleh '.Auth::user() -> name);
        $pembagian->setAttribute('type', 'edit');
      } else if ($jenis == 'delete') {
        $pembagian->setAttribute('text', 'Tugas '.$pembagian -> nama_tugas.' dihapus dari anggota '.$pembagian -> username.' oleh '.Auth::user() -> name);
        $pembagian->setAttribute('type', 'edit');
      } else if ($jenis == 'editPJ') {
        $pembagian->setAttribute('text', 'PJ2 pada tugas '.$pembagian -> nama_subtugas.' diubah dari anggota '.$pembagian -> username.' menjadi '.$pembagian -> username2.' oleh '.Auth::user() -> name);
        $pembagian->setAttribute('type', 'edit');
      } else if ($jenis == 'revisi') {
        $pembagian->setAttribute('text', 'Tugas '.$pembagian -> nama_subtugas.' direvisi oleh '.Auth::user() -> name);
        $pembagian->setAttribute('type', 'edit');
      } else if ($jenis == 'konfirmasi') {
        $pembagian->setAttribute('text', 'Status tugas '.$pembagian -> nama_subtugas.' dikonfirmasi oleh '.Auth::user() -> name);
        $pembagian->setAttribute('type', 'edit');
      } else if ($jenis == 'batal_revisi') {
        $pembagian->setAttribute('text', 'Revisi pada tugas '.$pembagian -> nama_subtugas.' dibatalkan oleh '.Auth::user() -> name);
        $pembagian->setAttribute('type', 'edit');
      } else if ($jenis == 'edit_tanggal') {
        $pembagian->setAttribute('text', 'Batas tanggal pada tugas '.$pembagian -> nama_subtugas.' diubah oleh '.Auth::user() -> name);
        $pembagian->setAttribute('type', 'edit');
      } else if ($jenis == 'editPJanggota') {
        $pembagian->setAttribute('text', $pembagian -> nama_pjbaru.' menjadi penanggung jawab '.$pembagian -> username.' oleh '.Auth::user() -> name);
        $pembagian->setAttribute('type', 'edit');
      }
      Notification::send($adms, new PembagiantugasNotifyAdmin($pembagian));
    }

    if ($id_anggota !== null) {
      $ang = User::find($id_anggota);
      if ($jenis == 'edit') {
        $pembagian->setAttribute('text', 'Tugas baru ditambahkan oleh '.Auth::user() -> name);
        $pembagian->setAttribute('type', 'editanggota');
      } else if ($jenis == 'delete') {
        $pembagian->setAttribute('text', 'Tugas '.$pembagian -> nama_tugas.' dihapus oleh '.Auth::user() -> name);
        $pembagian->setAttribute('type', 'editanggota');
      } else if ($jenis == 'editPJ') {
        $pembagian->setAttribute('text', 'PJ2 pada tugas '.$pembagian -> nama_subtugas.' diubah menjadi '.$pembagian -> username2.' oleh '.Auth::user() -> name);
        $pembagian->setAttribute('type', 'editanggota');
      } else if ($jenis == 'revisi') {
        $pembagian->setAttribute('text', 'Tugas '.$pembagian -> nama_subtugas.' direvisi oleh '.Auth::user() -> name);
        $pembagian->setAttribute('type', 'editanggota');
      } else if ($jenis == 'konfirmasi') {
        $pembagian->setAttribute('text', 'Status tugas '.$pembagian -> nama_subtugas.' dikonfirmasi oleh '.Auth::user() -> name);
        $pembagian->setAttribute('type', 'editanggota');
      } else if ($jenis == 'batal_revisi') {
        $pembagian->setAttribute('text', 'Revisi tugas '.$pembagian -> nama_subtugas.' dibatalkan oleh '.Auth::user() -> name);
        $pembagian->setAttribute('type', 'editanggota');
      }  else if ($jenis == 'edit_tanggal') {
        $pembagian->setAttribute('text', 'Batas tanggal pada tugas '.$pembagian -> nama_subtugas.' diubah oleh '.Auth::user() -> name);
        $pembagian->setAttribute('type', 'editanggota');
      }  else if ($jenis == 'editPJanggota') {
        $pembagian->setAttribute('text', 'Penanggung jawab '.$pembagian -> username.' diubah menjadi '.$pembagian -> nama_pjbaru.' oleh '.Auth::user() -> name);
        $pembagian->setAttribute('type', 'editanggota');
      }
        Notification::send($ang, new PembagiantugasNotifyAdmin($pembagian));
    }

  }
}
