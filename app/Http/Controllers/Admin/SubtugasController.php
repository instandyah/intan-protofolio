<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\Controller;
use App\Models\Subtugas;
use App\Models\Tugas;
use Illuminate\Support\Facades\DB;
use App\Models\PembagianTugas;
use App\Models\ProjectDetail;
use App\Models\Admin;
use App\Notifications\SubtugasNotifyAdmin;
use Auth;

class subtugasController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:admin');
  }

  public function createSubtugas(Request $request, $id_tugas)
  {
    $messages = [
      "nama_subtugas.required" => "Nama sub tugas harus diisi",
      "bobot.required" => "Bobot jawab harus diisi"
    ];

    $this->validate( $request, [
      'nama_subtugas' => 'required',
      'bobot' => 'required'
    ], $messages);

    $subtugas = new Subtugas;
    $subtugas -> nama_subtugas = $request -> nama_subtugas;
    $subtugas -> bobot = $request -> bobot;
    // $subtugas -> dikerjakan_setelah = $request -> dikerjakan_setelah;
    $subtugas -> id_tugas = $id_tugas;
    $subtugas -> save();

    $subtugaspilih = Subtugas::where('nama_subtugas', $request -> nama_subtugas)->first();
    $id_subtugasnya = $subtugaspilih -> id_subtugas;
    $iniapa = DB::table('pembagian_tugas')
    ->join('anggota as a', 'a.id_anggota', '=', 'pembagian_tugas.id_PJ1')
    ->join('anggota as b', 'b.id_anggota', '=', 'pembagian_tugas.id_PJ2')
    ->join('sub_tugas', 'sub_tugas.id_subtugas', '=', 'pembagian_tugas.id_subtugas')
    ->join('tugas', 'sub_tugas.id_tugas', '=', 'tugas.id_tugas')
    ->select('id_PJ1', 'a.username as username1')
    ->where('tugas.id_tugas', '=', $id_tugas)
    ->first();
    if (!($iniapa == '')) {
      $id_anggota = $iniapa -> id_PJ1;
      $pembagian = new PembagianTugas;
      $pembagian -> id_subtugas = $id_subtugasnya;
      $pembagian -> id_PJ1 = $id_anggota;
      $pembagian -> id_PJ2 = $id_anggota;
      $pembagian -> save();
  }

  $tugas = Tugas::find($id_tugas)->first();
  $id_project = $tugas -> id_project;
  $subtugas->setAttribute('text', 'Sub tugas baru dibuat pada tugas '.$tugas -> nama_tugas.' oleh '.Auth::user() -> name);
  $subtugas->setAttribute('type', 'create');
  $this->notifikasi($id_project, $subtugas);

  return $subtugas;



  }
  public function editSubtugas(Request $request)
  {
    $messages = [
      "nama_subtugasedit.required" => "Nama sub tugas harus diisi",
    ];

    $this->validate( $request, [
      'nama_subtugasedit' => 'required',
    ], $messages);

    $subtugas = Subtugas::find($request -> id_subtugas);
    $subtugas -> nama_subtugas = $request -> nama_subtugasedit;
    $subtugas -> bobot = $request -> bobot;
    // $subtugas -> dikerjakan_setelah = $request -> dikerjakan_setelah;
    $subtugas -> save();

    $tugas = Tugas::find($subtugas -> id_tugas)->first();
    $id_project = $tugas -> id_project;
    $subtugas->setAttribute('text', 'Sub tugas '.$subtugas -> nama_subtugas.' diedit oleh '.Auth::user() -> name);
    $subtugas->setAttribute('type', 'edit');
    $this->notifikasi($id_project, $subtugas);


    return $subtugas;
    // return redirect(route('tugas.select', ['id_tugas' => $id_tugas ]));
  }

  public function deleteSubtugas($id_subtugas)
  {
    $subtugas = Subtugas::find($id_subtugas);
    $tugas = Tugas::find($subtugas -> id_tugas)->first();
    $id_project = $tugas -> id_project;
    $subtugas->setAttribute('text', 'Sub tugas '.$subtugas -> nama_subtugas.' telah dihapus oleh '.Auth::user() -> name);
    $subtugas->setAttribute('type', 'delete');
    $this->notifikasi($id_project, $subtugas);


    $subtugas->delete();
    return "true";

    // return redirect(route('project.select', ['id_project' => $id_project ]));
  }

  public function notifikasi($id_project, $subtugas)
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
    Notification::send($adms, new SubtugasNotifyAdmin($subtugas));
  }
}
