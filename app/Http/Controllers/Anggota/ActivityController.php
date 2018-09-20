<?php

namespace App\Http\Controllers\Anggota;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Models\Project;
use App\Models\Anggota;
use App\Models\PembagianTugas;
use App\Notifications\PembagiantugasNotifyAdmin;
use App\Models\Admin;
use Auth;

class ActivityController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:admin,web');
  }

  public function index()
  {
    return view('anggota.aktivitas');
  }
  public function selectProject($id_project)
  {
    $project = Project::find($id_project);
    $id_anggota = Auth::id();
    $anggota = Anggota::find($id_anggota);
    // call nama nama tugas dari pembagian tugas record
    $val = 'revisi';
    $tugases =  DB::select('SELECT id_aktivitas, aktivitas.id_pembagian, id_PJ1, a.username as PJ1, id_PJ2, b.username as PJ2, pembagian_tugas.id_subtugas, nama_subtugas, sub_tugas.id_tugas, nama_tugas, status, keterangan, revisi_hit, deskripsi FROM aktivitas
      JOIN pembagian_tugas ON aktivitas.id_pembagian = pembagian_tugas.id_pembagian
      JOIN anggota as a ON pembagian_tugas.id_PJ1 = a.id_anggota
      JOIN anggota as b ON pembagian_tugas.id_PJ2 = b.id_anggota
      JOIN sub_tugas ON pembagian_tugas.id_subtugas = sub_tugas.id_subtugas
      JOIN tugas ON sub_tugas.id_tugas = tugas.id_tugas,
      (SELECT MAX(id_aktivitas) as id_akt FROM aktivitas Group by id_pembagian) b
      WHERE tugas.id_project = '.$id_project.' AND
      aktivitas.id_aktivitas = b.id_akt AND
      id_PJ2 = '.$id_anggota.' AND
      (id_PJ1 = '.$id_anggota.' OR id_PJ2 = '.$id_anggota.')
      GROUP BY status, nama_tugas');

        //sama ama yang atas, tp fail
    // $tugases = DB::table('aktivitas')
    // ->join('pembagian_tugas', 'aktivitas.id_pembagian', '=', 'pembagian_tugas.id_pembagian')
    // ->join('sub_tugas', 'pembagian_tugas.id_subtugas', '=', 'sub_tugas.id_subtugas')
    // ->join('tugas', 'sub_tugas.id_tugas', '=', 'tugas.id_tugas')
    // ->select('aktivitas.id_pembagian', 'pembagian_tugas.id_subtugas', 'nama_subtugas', 'sub_tugas.id_tugas', 'nama_tugas', 'status', 'keterangan')
    // ->where('id_PJ1', '=', $id_anggota)
    // ->where('id_PJ2', '=', $id_anggota)
    // ->where('tugas.id_project', '=', $id_project)
    // ->where(function($query1){
    //   $query1 ->where('keterangan', '=', 'revisi')
    //           ->orWhereNotExists(function ($query){
    //             $query->select(DB::raw('*'))
    //                     ->from('aktivitas as a')
    //                     ->where('a.id_pembagian', '=', 'aktivitas.id_pembagian')
    //                     ->where('a.keterangan', '=', 'revisi');
    //                 });
    // })
    // ->groupBy('status', 'nama_tugas')
    // ->get();

    // call nama nama subtugas dari pembagian record
    $subtugases = DB::select('SELECT id_aktivitas, aktivitas.id_pembagian, id_PJ1, a.username as PJ1, id_PJ2, b.username as PJ2, pembagian_tugas.id_subtugas, nama_subtugas, sub_tugas.id_tugas, nama_tugas, status, keterangan, revisi_hit, confirm, deskripsi, due_date, aktivitas.updated_at, progress, end_date, postpone_start FROM aktivitas
      JOIN pembagian_tugas ON aktivitas.id_pembagian = pembagian_tugas.id_pembagian
      JOIN anggota as a ON pembagian_tugas.id_PJ1 = a.id_anggota
      JOIN anggota as b ON pembagian_tugas.id_PJ2 = b.id_anggota
      JOIN sub_tugas ON pembagian_tugas.id_subtugas = sub_tugas.id_subtugas
      JOIN tugas ON sub_tugas.id_tugas = tugas.id_tugas,
      (SELECT MAX(id_aktivitas) as id_akt FROM aktivitas Group by id_pembagian) b
      WHERE tugas.id_project = '.$id_project.' AND
      id_PJ2 = '.$id_anggota.' AND
      (id_PJ1 = '.$id_anggota.' OR id_PJ2 = '.$id_anggota.') AND
      aktivitas.id_aktivitas = b.id_akt ORDER BY aktivitas.updated_at desc');
      //max itu buat ngeget aktivitas yang paling baru
    // DB::table('aktivitas')
    // ->join('pembagian_tugas', 'aktivitas.id_pembagian', '=', 'pembagian_tugas.id_pembagian')
    // ->join('sub_tugas', 'pembagian_tugas.id_subtugas', '=', 'sub_tugas.id_subtugas')
    // ->join('tugas', 'sub_tugas.id_tugas', '=', 'tugas.id_tugas')
    // ->select('id_aktivitas','aktivitas.id_pembagian', 'pembagian_tugas.id_subtugas', 'nama_subtugas', 'sub_tugas.id_tugas', 'nama_tugas', 'status', 'keterangan')
    // ->where([
    //   ['id_PJ1', '=', $id_anggota],
    //   ['id_PJ2', '=', $id_anggota],
    //   ['tugas.id_project', '=', $id_project],
    // ])
    // ->get();

    $tugasespj2 =  DB::select('SELECT id_aktivitas, aktivitas.id_pembagian, id_PJ1, a.username as PJ1, id_PJ2, b.username as PJ2, pembagian_tugas.id_subtugas, nama_subtugas, sub_tugas.id_tugas, nama_tugas, status, keterangan, revisi_hit FROM aktivitas
      JOIN pembagian_tugas ON aktivitas.id_pembagian = pembagian_tugas.id_pembagian
      JOIN anggota as a ON pembagian_tugas.id_PJ1 = a.id_anggota
      JOIN anggota as b ON pembagian_tugas.id_PJ2 = b.id_anggota
      JOIN sub_tugas ON pembagian_tugas.id_subtugas = sub_tugas.id_subtugas
      JOIN tugas ON sub_tugas.id_tugas = tugas.id_tugas,
      (SELECT MAX(id_aktivitas) as id_akt FROM aktivitas Group by id_pembagian) b
      WHERE tugas.id_project = '.$id_project.' AND
      aktivitas.id_aktivitas = b.id_akt AND
      id_PJ1 = '.$id_anggota.' AND
      (id_PJ1 <> id_PJ2)
      GROUP BY status, nama_tugas');

      $subtugasespj2 = DB::select('SELECT id_aktivitas, aktivitas.id_pembagian, id_PJ1, a.username as PJ1, id_PJ2, b.username as PJ2, pembagian_tugas.id_subtugas, nama_subtugas, sub_tugas.id_tugas, nama_tugas, status, keterangan, revisi_hit, confirm, deskripsi, due_date, aktivitas.updated_at, progress, end_date, postpone_start FROM aktivitas
        JOIN pembagian_tugas ON aktivitas.id_pembagian = pembagian_tugas.id_pembagian
        JOIN anggota as a ON pembagian_tugas.id_PJ1 = a.id_anggota
        JOIN anggota as b ON pembagian_tugas.id_PJ2 = b.id_anggota
        JOIN sub_tugas ON pembagian_tugas.id_subtugas = sub_tugas.id_subtugas
        JOIN tugas ON sub_tugas.id_tugas = tugas.id_tugas,
        (SELECT MAX(id_aktivitas) as id_akt FROM aktivitas Group by id_pembagian) b
        WHERE tugas.id_project = '.$id_project.' AND
        id_PJ1 = '.$id_anggota.' AND
        (id_PJ1 <> id_PJ2) AND
        aktivitas.id_aktivitas = b.id_akt');

// dd($subtugasespj2);

    return view('anggota.aktivitas', ['tugases' => $tugases, 'subtugases' => $subtugases, 'project' => $project, 'anggota' => $anggota, 'tugasespj2' => $tugasespj2, 'subtugasespj2' => $subtugasespj2]);
    // return $tugasespj2;
  }

  public function editStatus(Request $request, $id_aktivitas)
  {

    $aktivitas = DB::table('aktivitas')
    ->join('pembagian_tugas', 'aktivitas.id_pembagian', '=', 'pembagian_tugas.id_pembagian')
    ->join('sub_tugas', 'pembagian_tugas.id_subtugas', '=', 'sub_tugas.id_subtugas')
    ->join('tugas', 'sub_tugas.id_tugas', '=', 'tugas.id_tugas')
    ->select('id_aktivitas','aktivitas.id_pembagian', 'pembagian_tugas.id_subtugas', 'nama_subtugas', 'sub_tugas.id_tugas', 'nama_tugas')
    ->where('id_aktivitas', $id_aktivitas)
    ->get();

    $currentact = DB::table('aktivitas')
    ->where('id_aktivitas', $id_aktivitas)
    ->get();

    $pembagian = PembagianTugas::find($currentact[0] -> id_pembagian);
    $subtugas = DB::table('sub_tugas')
                  ->where('id_subtugas', $pembagian -> id_subtugas)
                  ->get();
    $tugas =  DB::table('tugas')
                  ->where('id_tugas', $subtugas[0] -> id_tugas)
                  ->get();
    $id_project = $tugas[0] -> id_project;
    $pembagians = Anggota::find($pembagian -> id_PJ1);
    $pembagians->setAttribute('text', 'Status '.$subtugas[0] -> nama_subtugas.' telah diubah pada '.$pembagians -> username);
    $pembagians->setAttribute('id_project', $id_project);
    $pembagians->setAttribute('type', 'edit');
    $admins = DB::table('project_detail')
              ->select('id_admin')
              ->where([
                ['id_project', $id_project],
              ])
              ->get();

    $admins2 = [];
    foreach ($admins as $adminn) {
      array_push($admins2, $adminn -> id_admin);
    }
    $adms = Admin::find($admins2);



    $status = $request -> get('status');
    switch ($status) {
      case 'Dikerjakan':{

        if (($currentact[0] -> end_date) !== null) {
          // $aktivitasnew =  DB::table('aktivitas')->insert([
          //   [
          //     'id_pembagian' => $currentact[0] -> id_pembagian,
          //     'start_date' => DB::raw('CURRENT_TIMESTAMP'),
          //     'status' => $request -> status,
          //     'keterangan' => 'revisi',
          //     'revisi_hit' => $currentact[0] -> revisi_hit + 1
          //   ]
          // ]);
          // Notification::send($adms, new PembagiantugasNotifyAdmin($pembagians));
            return 'sudah dikerjakan'; //gaboleh balik lagi
          } elseif (($currentact[0] -> postpone_start) !== null) { //ini berarti pernah di postpone
              DB::table('aktivitas')
              ->where('id_aktivitas', $id_aktivitas)
              ->update([
                'postpone_end' => DB::raw('CURRENT_TIMESTAMP'),
                'status' => $request -> status,
                'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
              ]);
              Notification::send($adms, new PembagiantugasNotifyAdmin($pembagians));
            return 'dari postpone';
          } else { //ini berarti tugas yang fresh
              DB::table('aktivitas')
              ->where('id_aktivitas', $id_aktivitas)
              ->update([
                'start_date' => DB::raw('CURRENT_TIMESTAMP'),
                'status' => $request -> status,
                'progress' => 0,
                'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
              ]);
              Notification::send($adms, new PembagiantugasNotifyAdmin($pembagians));
            return 'dari tersedia';
        }
        break;
      }
      case 'Selesai':{

        if (($currentact[0] -> start_date) == null) {
          return 'belum pernah dikerjakan'; //gabisa selesai kalo belum dikerjakan
        } elseif (($currentact[0] -> postpone_start) !== null ){ //gajadi postpone, selesai aja udah
          if (($currentact[0] -> postpone_end) == null ) {
            DB::table('aktivitas')
            ->where('id_aktivitas', $id_aktivitas)
            ->update([
              'postpone_start' => NULL,
              'end_date' => $currentact[0] -> postpone_start,
              'confirm' => NULL,
              'status' => $request -> status,
              'progress' => 100,
              'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
            ]);
            Notification::send($adms, new PembagiantugasNotifyAdmin($pembagians));
            return 'tugas selesai';
          } else {
            DB::table('aktivitas')
            ->where('id_aktivitas', $id_aktivitas)
            ->update([
              'end_date' => DB::raw('CURRENT_TIMESTAMP'),
              'confirm' => NULL,
              'status' => $request -> status,
              'progress' => 100,
              'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
            ]);
            Notification::send($adms, new PembagiantugasNotifyAdmin($pembagians));
            return 'tugas selesai';
          }
        } else {
          DB::table('aktivitas')
          ->where('id_aktivitas', $id_aktivitas)
          ->update([
            'end_date' => DB::raw('CURRENT_TIMESTAMP'),
            'confirm' => NULL,
            'status' => $request -> status,
            'progress' => 100,
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
          ]);
          Notification::send($adms, new PembagiantugasNotifyAdmin($pembagians));
          return 'tugas selesai'; //tanpa postpone
        }
        break;
      }

      case 'Ditunda':{
          if (($currentact[0] -> start_date) == null) {
            return 'belum pernah dikerjakan';//gabisa dipostpone kalo belom pernah dikerjakan
         } elseif (($currentact[0] -> end_date) !== null) {
            return 'sudah dikerjakan'; //gabisa di post pone kalo udah selesai
         } else {
           DB::table('aktivitas')
           ->where('id_aktivitas', $id_aktivitas)
           ->update([
             'postpone_start' => DB::raw('CURRENT_TIMESTAMP'),
             'postpone_end' => NULL,
             'confirm' => NULL,
             'status' => $request -> status,
             'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
           ]);
           Notification::send($adms, new PembagiantugasNotifyAdmin($pembagians));
            return 'tugas postpone';
         }
        break;
      }
      default:
        // code...
        break;
    }
  }

  public function updateprogres(Request $request, $id_aktivitas)
  {
    $inianggota = DB::table('aktivitas')
    ->join('pembagian_tugas', 'pembagian_tugas.id_pembagian', '=', 'aktivitas.id_pembagian')
    ->join('anggota', 'pembagian_tugas.id_PJ1', '=', 'anggota.id_anggota')
    ->join('sub_tugas', 'pembagian_tugas.id_subtugas', '=', 'sub_tugas.id_subtugas')
    ->join('tugas', 'sub_tugas.id_tugas', '=', 'tugas.id_tugas')
    ->where('id_aktivitas', $id_aktivitas)
    ->groupBy('id_aktivitas')
    ->get();

    $pembagians = Anggota::find($inianggota[0] -> id_PJ1);

    $pembagians->setAttribute('id_project', $inianggota[0] -> id_project);
    $pembagians->setAttribute('type', 'edit');

    if ($request -> progress == '100') {
      DB::table('aktivitas')
      ->where('id_aktivitas', $id_aktivitas)
      ->update([
        'end_date' => DB::raw('CURRENT_TIMESTAMP'),
        'confirm' => NULL,
        'status' => 'Selesai',
        'progress' => 100,
        'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
      ]);
      $pembagians->setAttribute('text', 'Status tugas '.$inianggota[0] -> nama_subtugas.' telah diubah oleh '.$pembagians -> username);
    } else {
      DB::table('aktivitas')
      ->where('id_aktivitas', $id_aktivitas)
      ->update([
        'progress' => $request -> progress,
        'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        'confirm_progress' => null
      ]);
    $pembagians->setAttribute('text', 'Progres pada '.$inianggota[0] -> nama_subtugas.' telah diperbarui '.$pembagians -> username);
    }


    $admins = DB::table('project_detail')
              ->select('id_admin')
              ->where([
                ['id_project', $inianggota[0] -> id_project],
              ])
              ->get();

    $admins2 = [];
    foreach ($admins as $adminn) {
      array_push($admins2, $adminn -> id_admin);
    }
    $adms = Admin::find($admins2);

    Notification::send($adms, new PembagiantugasNotifyAdmin($pembagians));

    return $id_aktivitas;
  }
}
