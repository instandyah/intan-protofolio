<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class PembagianTugas extends Model
{
  use Notifiable;
  protected $table = 'pembagian_tugas';

  protected $primaryKey = 'id_pembagian';

  protected $fillable = [
      'id_tugas', 'id_subtugas', 'id_PJ1', 'id_PJ2'
  ];
}
