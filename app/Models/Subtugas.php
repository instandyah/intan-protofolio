<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Subtugas extends Model
{
  use Notifiable;
  protected $table = 'sub_tugas';

  protected $primaryKey = 'id_subtugas';

  protected $fillable = [
      'nama_subtugas', 'id_tugas', 'bobot', 'dikerjakan_setelah'
  ];
}
