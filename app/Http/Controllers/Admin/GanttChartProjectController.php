<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use Auth;
use Carbon\Carbon;

class GanttChartProjectController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth:admin');
  }
  public function get($id_project, $progress)
  {
        return view('admin.ganttchartproject', [ 'id_project' => $id_project, 'progress' => $progress]);
        // return view('anggota.ganttchart');
  }
  public function getvalueganttchart($id_project, $progress)
  {
    // $id_anggota = Auth::id();
    // return $progress;
    $project = Project::find($id_project);
    $progproj = $progress/100;
    $valuegantchart = [];

    $gantgetchildproject = DB::table('aktivitas')
      ->join('pembagian_tugas', 'aktivitas.id_pembagian', '=', 'pembagian_tugas.id_pembagian')
      ->join('sub_tugas', 'pembagian_tugas.id_subtugas', '=', 'sub_tugas.id_subtugas')
      ->join('tugas', 'sub_tugas.id_tugas', '=', 'tugas.id_tugas')
      ->join('project', 'tugas.id_project', '=', 'project.id_project')
      ->select('tugas.id_tugas', 'sub_tugas.id_subtugas','start_date')
      ->where([
        ['tugas.id_project', '=', $id_project],
      ])
      ->orderBy('start_date', 'asc')
      ->get();

    $childprojectarray = []; //buat liat udah ada sub_tugas yang dikerjakan atau belom
    foreach ($gantgetchildproject as $childproject) {
      array_push($childprojectarray, $childproject -> start_date);
    }
    $pjproyek = [$project -> nama_penanggungjawab];
        if (!array_filter($childprojectarray)) {
          array_push($valuegantchart, [
            'id' => $id_project, 'text' => $project -> nama_project, 'users' => $pjproyek, 'unscheduled'=> true, 'duration' => 0, "open" => true]);
        }
        else {
              array_push($valuegantchart, [
                'id' => $id_project, 'text' => $project -> nama_project,  'users' => $pjproyek, 'progress' => $progproj, 'progress_teks' => $progress, 'start_date'=> null, 'duration' => 0, "open" => true]);
          }



    $gantvalueparents =   DB::table('aktivitas')
      ->join('pembagian_tugas', 'aktivitas.id_pembagian', '=', 'pembagian_tugas.id_pembagian')
      ->join('sub_tugas', 'pembagian_tugas.id_subtugas', '=', 'sub_tugas.id_subtugas')
      ->join('tugas', 'sub_tugas.id_tugas', '=', 'tugas.id_tugas')
      ->join('project', 'tugas.id_project', '=', 'project.id_project')
      ->join('anggota as c', 'pembagian_tugas.id_PJ1', '=', 'c.id_anggota')
      ->select('tugas.id_project', 'nama_project', 'sub_tugas.id_tugas', 'nama_tugas', 'pembagian_tugas.id_subtugas', 'c.username as pj1tugas', 'nama_subtugas', 'aktivitas.id_pembagian', 'id_aktivitas', 'start_date', 'end_date', 'postpone_start', 'postpone_end', 'keterangan', 'revisi_hit', 'status', 'progress')
      ->where('tugas.id_project', '=', $id_project)
      // ->groupBy('id_tugas')
      ->orderBy('start_date', 'asc')
      ->get();

      $gantvalueparent = $gantvalueparents->unique('id_tugas')->values();
      // return $gantvalueparents;
      $categories = [];
      foreach($gantgetchildproject as $child)
      {
          $categories[$child -> id_tugas][] = $child-> start_date;
      }

    for ($i = 0; $i < count($gantvalueparent); $i++) {
        $text = $gantvalueparent[$i] -> nama_tugas;

        $c = 0;

        $arraysum = [];
        for ($x=0; $x < count($gantvalueparents) ; $x++) {
          if ($gantvalueparent[$i] -> id_tugas == $gantvalueparents[$x] -> id_tugas) {
            if ($gantvalueparents[$x] -> progress !== null) {
              array_push($arraysum, $gantvalueparents[$x] -> progress);
            }
            $c++;
          }
        }
        $try = array_sum($arraysum);
        $b = $c*100;
        $a = $try/$b;
        $pj1tugas = [$gantvalueparent[$i] -> pj1tugas];
        $progrestugas = $a*100;
        if (!array_filter($categories[$gantvalueparent[$i] -> id_tugas])){
          array_push($valuegantchart, [
            'id' => $gantvalueparent[$i] -> id_tugas, 'text' => $text, 'users' => $pj1tugas, 'unscheduled'=> true, 'duration' => 0,"parent" => $id_project , "open" => true]);
        }else {
            array_push($valuegantchart, [
              'id' => $gantvalueparent[$i] -> id_tugas, 'text' => $text, 'users' => $pj1tugas, 'progress' => $a, 'progress_teks' => $progrestugas, 'start_date'=> null, 'duration' => 0,"parent" => $id_project , "open" => true]);
        }

    }
// return $valuegantchart;

    $gantvalue =   DB::table('aktivitas')
      ->join('pembagian_tugas', 'aktivitas.id_pembagian', '=', 'pembagian_tugas.id_pembagian')
      ->join('sub_tugas', 'pembagian_tugas.id_subtugas', '=', 'sub_tugas.id_subtugas')
      ->join('tugas', 'sub_tugas.id_tugas', '=', 'tugas.id_tugas')
      ->join('anggota as a', 'pembagian_tugas.id_PJ1', '=', 'a.id_anggota')
      ->join('anggota as b', 'pembagian_tugas.id_PJ2', '=', 'b.id_anggota')
      ->select('sub_tugas.id_tugas',
      'nama_tugas', 'pembagian_tugas.id_subtugas', 'nama_subtugas', 'aktivitas.id_pembagian', 'a.username as pj1', 'b.username as pj2', 'id_aktivitas', 'start_date', 'end_date', 'postpone_start', 'postpone_end', 'keterangan', 'revisi_hit', 'status', 'confirm', 'progress', 'confirm_progress', 'due_date', 'aktivitas.updated_at', 'end_date')
      ->where('tugas.id_project', '=', $id_project)
      ->orderBy('start_date', 'asc')
      ->get();
// return $gantvalue;

      for ($j = 0; $j < count($gantvalue); $j++) {
        $isiend = $gantvalue[$j] -> end_date;
        switch ($isiend) {
          case null:{
            if ($gantvalue[$j] -> postpone_start == null) {
              $poststart = $gantvalue[$j] -> start_date; //agar supaya nilainya 0
              $postend = $gantvalue[$j] -> start_date;
              $end = Carbon::now();
            } elseif ($gantvalue[$j]-> postpone_start !== null && $gantvalue[$j] -> postpone_end == null) {
              $poststart = $gantvalue[$j] -> start_date;
              $postend = $gantvalue[$j] -> start_date;
              $end = $gantvalue[$j] -> postpone_start;
            } elseif ($gantvalue[$j]-> postpone_start !== null && $gantvalue[$j] -> postpone_end !== null) {
              $poststart = $gantvalue[$j] -> postpone_start;
              $postend = $gantvalue[$j] -> postpone_end;
              $end =  Carbon::now();
            }
            break;
          }
          case !null:{
            if ($gantvalue[$j] -> postpone_start == null) {
              $poststart = $gantvalue[$j] -> start_date;
              $postend = $gantvalue[$j] -> start_date;
              $end = $gantvalue[$j] -> end_date;
            } else {
              $poststart = $gantvalue[$j] -> postpone_start;
              $postend = $gantvalue[$j] -> postpone_end;
              $end =  $gantvalue[$j] -> end_date;
            }
            break;
          }
          default:
            break;
        }
        //
        $endcarb = Carbon::parse($end);
        $start = Carbon::parse($gantvalue[$j] -> start_date );
        $poststartcarb = Carbon::parse($poststart);
        $postendcarb = Carbon::parse($postend);
        //
        $lengthdurasi = $endcarb->diffInDays($start);
        $splitstart = $poststartcarb->diffInDays($start);
        $splitend = $postendcarb->diffInDays($start);
        $text = $gantvalue[$j] -> nama_subtugas.' '.$gantvalue[$j] -> keterangan.' '.$gantvalue[$j] -> revisi_hit;

        $listuser = [];
        if ($gantvalue[$j] -> pj1 !== $gantvalue[$j] -> pj2) {
          array_push($listuser, $gantvalue[$j] -> pj1, $gantvalue[$j] -> pj2);
        } else {
          array_push($listuser, $gantvalue[$j] -> pj1);
        }


        if ($gantvalue[$j] -> start_date == null) {
          array_push($valuegantchart, [
            'id' => $gantvalue[$j] -> id_aktivitas,
            'text' => $text,
            'users' => $listuser,
            'duration' => $lengthdurasi,
            'splitStart' => $splitstart,
            'splitEnd' => $splitend,
            'parent' => $gantvalue[$j] -> id_tugas,
            'unscheduled' => true,
            ]);
        } else {
          array_push($valuegantchart, [
            'id' => $gantvalue[$j] -> id_aktivitas,
            'text' => $text,
            'users' => $listuser,
            'start_date'=> $gantvalue[$j] -> start_date,
            'duration' => $lengthdurasi,
            'splitStart' => $splitstart,
            'splitEnd' => $splitend,
            'parent' => $gantvalue[$j] -> id_tugas,
            'status' => $gantvalue[$j] -> status,
            'confirm' => $gantvalue[$j] -> confirm,
            'progress' => $gantvalue[$j] -> progress / 100,
            'progress_teks' => $gantvalue[$j] -> progress,
            'confirm_progress' => $gantvalue[$j] -> confirm_progress,
            'subtugas' => 'ya',
            'due_date' => $gantvalue[$j] -> due_date,
            'updated_at' => $gantvalue[$j] -> updated_at,
            'ed' => $gantvalue[$j] -> end_date
          ]);
        }
      }
       return response()->json([
           "data" => $valuegantchart,
           "link" => []
       ]);

  }
  public function getanggota($id_project, $id_anggota)
  {
        return view('admin.ganttchartanggota', [ 'id_project' => $id_project, 'id_anggota' => $id_anggota]);
        // return view('anggota.ganttchart');
  }

  public function getvalueganttchartanggota($id_project, $id_anggota)
  {

      // $id_anggota = Auth::id();
      // return $progress;
      $project = Project::find($id_project);

      $valuegantchart = [];

      $gantgetchildproject = DB::table('aktivitas')
        ->join('pembagian_tugas', 'aktivitas.id_pembagian', '=', 'pembagian_tugas.id_pembagian')
        ->join('sub_tugas', 'pembagian_tugas.id_subtugas', '=', 'sub_tugas.id_subtugas')
        ->join('tugas', 'sub_tugas.id_tugas', '=', 'tugas.id_tugas')
        ->join('project', 'tugas.id_project', '=', 'project.id_project')
        ->select('tugas.id_tugas', 'sub_tugas.id_subtugas','start_date')
        ->where('tugas.id_project', '=', $id_project)
        ->where(function ($query) use ($id_anggota) {
          $query->where('id_PJ1','=', $id_anggota)
                ->orWhere('id_PJ2', '=', $id_anggota);
        })
        ->orderBy('start_date', 'asc')
        ->get();

      $childprojectarray = []; //buat liat udah ada sub_tugas yang dikerjakan atau belom
      foreach ($gantgetchildproject as $childproject) {
        array_push($childprojectarray, $childproject -> start_date);
      }
      $pjproyek = [$project -> nama_penanggungjawab];
          if (!array_filter($childprojectarray)) {
            array_push($valuegantchart, [
              'id' => $id_project, 'text' => $project -> nama_project, 'users' => $pjproyek, 'unscheduled'=> true, 'duration' => 0, "open" => true]);
          }
          else {
                array_push($valuegantchart, [
                  'id' => $id_project, 'text' => $project -> nama_project,  'users' => $pjproyek, 'start_date'=> null, 'duration' => 0, "open" => true]);
            }



      $gantvalueparents =   DB::table('aktivitas')
        ->join('pembagian_tugas', 'aktivitas.id_pembagian', '=', 'pembagian_tugas.id_pembagian')
        ->join('sub_tugas', 'pembagian_tugas.id_subtugas', '=', 'sub_tugas.id_subtugas')
        ->join('tugas', 'sub_tugas.id_tugas', '=', 'tugas.id_tugas')
        ->join('project', 'tugas.id_project', '=', 'project.id_project')
        ->join('anggota as c', 'pembagian_tugas.id_PJ1', '=', 'c.id_anggota')
        ->select('tugas.id_project', 'nama_project', 'sub_tugas.id_tugas', 'nama_tugas', 'pembagian_tugas.id_subtugas', 'c.username as pj1tugas', 'nama_subtugas', 'aktivitas.id_pembagian', 'id_aktivitas', 'start_date', 'end_date', 'postpone_start', 'postpone_end', 'keterangan', 'revisi_hit', 'status', 'progress')
        ->where('tugas.id_project', '=', $id_project)
        ->where(function ($query) use ($id_anggota) {
          $query->where('id_PJ1','=', $id_anggota)
                ->orWhere('id_PJ2', '=', $id_anggota);
        })
        ->orderBy('start_date', 'asc')
        ->get();

        $gantvalueparent = $gantvalueparents->unique('id_tugas')->values();
        // return $gantvalueparents;
        $categories = [];
        foreach($gantgetchildproject as $child)
        {
            $categories[$child -> id_tugas][] = $child-> start_date;
        }

      for ($i = 0; $i < count($gantvalueparent); $i++) {
          $text = $gantvalueparent[$i] -> nama_tugas;

          $c = 0;

          $arraysum = [];
          for ($x=0; $x < count($gantvalueparents) ; $x++) {
            if ($gantvalueparent[$i] -> id_tugas == $gantvalueparents[$x] -> id_tugas) {
              if ($gantvalueparents[$x] -> progress !== null) {
                array_push($arraysum, $gantvalueparents[$x] -> progress);
              }
              $c++;
            }
          }
          $try = array_sum($arraysum);
          $b = $c*100;
          $a = $try/$b;
          $pj1tugas = [$gantvalueparent[$i] -> pj1tugas];
          $progrestugas = $a*100;
          if (!array_filter($categories[$gantvalueparent[$i] -> id_tugas])){
            array_push($valuegantchart, [
              'id' => $gantvalueparent[$i] -> id_tugas, 'text' => $text, 'users' => $pj1tugas, 'unscheduled'=> true, 'duration' => 0,"parent" => $id_project , "open" => true]);
          }else {
              array_push($valuegantchart, [
                'id' => $gantvalueparent[$i] -> id_tugas, 'text' => $text, 'users' => $pj1tugas, 'progress' => $a, 'progress_teks' => $progrestugas, 'start_date'=> null, 'duration' => 0,"parent" => $id_project , "open" => true]);
          }

      }
  // return $valuegantchart;

      $gantvalue =   DB::table('aktivitas')
        ->join('pembagian_tugas', 'aktivitas.id_pembagian', '=', 'pembagian_tugas.id_pembagian')
        ->join('sub_tugas', 'pembagian_tugas.id_subtugas', '=', 'sub_tugas.id_subtugas')
        ->join('tugas', 'sub_tugas.id_tugas', '=', 'tugas.id_tugas')
        ->join('anggota as a', 'pembagian_tugas.id_PJ1', '=', 'a.id_anggota')
        ->join('anggota as b', 'pembagian_tugas.id_PJ2', '=', 'b.id_anggota')
        ->select('sub_tugas.id_tugas',
        'nama_tugas', 'pembagian_tugas.id_subtugas', 'nama_subtugas', 'aktivitas.id_pembagian', 'a.username as pj1', 'b.username as pj2', 'id_aktivitas', 'start_date', 'end_date', 'postpone_start', 'postpone_end', 'keterangan', 'revisi_hit', 'status', 'confirm', 'progress', 'confirm_progress', 'due_date', 'aktivitas.updated_at', 'end_date')
        ->where('tugas.id_project', '=', $id_project)
        ->where(function ($query) use ($id_anggota) {
          $query->where('id_PJ1','=', $id_anggota)
                ->orWhere('id_PJ2', '=', $id_anggota);
        })
        ->orderBy('start_date', 'asc')
        ->get();
  // return $gantvalue;

        for ($j = 0; $j < count($gantvalue); $j++) {
          $isiend = $gantvalue[$j] -> end_date;
          switch ($isiend) {
            case null:{
              if ($gantvalue[$j] -> postpone_start == null) {
                $poststart = $gantvalue[$j] -> start_date; //agar supaya nilainya 0
                $postend = $gantvalue[$j] -> start_date;
                $end = Carbon::now();
              } elseif ($gantvalue[$j] -> postpone_end == null) {
                $poststart = $gantvalue[$j] -> start_date;
                $postend = $gantvalue[$j] -> start_date;
                $end = $gantvalue[$j] -> postpone_start;
              } elseif ($gantvalue[$j] -> postpone_end !== null) {
                $poststart = $gantvalue[$j] -> postpone_start;
                $postend = $gantvalue[$j] -> postpone_end;
                $end =  Carbon::now();
              }
              break;
            }
            case !null:{
              if ($gantvalue[$j] -> postpone_start == null) {
                $poststart = $gantvalue[$j] -> start_date;
                $postend = $gantvalue[$j] -> start_date;
                $end = $gantvalue[$j] -> end_date;
              } else {
                $poststart = $gantvalue[$j] -> postpone_start;
                $postend = $gantvalue[$j] -> postpone_end;
                $end =  $gantvalue[$j] -> end_date;
              }
              break;
            }
            default:
              break;
          }
          //
          $endcarb = Carbon::parse($end);
          $start = Carbon::parse($gantvalue[$j] -> start_date );
          $poststartcarb = Carbon::parse($poststart);
          $postendcarb = Carbon::parse($postend);
          //
          $lengthdurasi = $endcarb->diffInDays($start);
          $splitstart = $poststartcarb->diffInDays($start);
          $splitend = $postendcarb->diffInDays($start);
          $text = $gantvalue[$j] -> nama_subtugas.' '.$gantvalue[$j] -> keterangan.' '.$gantvalue[$j] -> revisi_hit;

          $listuser = [];
          if ($gantvalue[$j] -> pj1 !== $gantvalue[$j] -> pj2) {
            array_push($listuser, $gantvalue[$j] -> pj1, $gantvalue[$j] -> pj2);
          } else {
            array_push($listuser, $gantvalue[$j] -> pj1);
          }


          if ($gantvalue[$j] -> start_date == null) {
            array_push($valuegantchart, [
              'id' => $gantvalue[$j] -> id_aktivitas,
              'text' => $text,
              'users' => $listuser,
              'duration' => $lengthdurasi,
              'splitStart' => $splitstart,
              'splitEnd' => $splitend,
              'parent' => $gantvalue[$j] -> id_tugas,
              'unscheduled' => true,
              ]);
          } else {
            array_push($valuegantchart, [
              'id' => $gantvalue[$j] -> id_aktivitas,
              'text' => $text,
              'users' => $listuser,
              'start_date'=> $gantvalue[$j] -> start_date,
              'duration' => $lengthdurasi,
              'splitStart' => $splitstart,
              'splitEnd' => $splitend,
              'parent' => $gantvalue[$j] -> id_tugas,
              'status' => $gantvalue[$j] -> status,
              'confirm' => $gantvalue[$j] -> confirm,
              'progress' => $gantvalue[$j] -> progress / 100,
              'progress_teks' => $gantvalue[$j] -> progress,
              'confirm_progress' => $gantvalue[$j] -> confirm_progress,
              'subtugas' => 'ya',
              'due_date' => $gantvalue[$j] -> due_date,
              'updated_at' => $gantvalue[$j] -> updated_at,
              'ed' => $gantvalue[$j] -> end_date
            ]);
          }
        }
         return response()->json([
             "data" => $valuegantchart,
             "link" => []
         ]);

  }

}
