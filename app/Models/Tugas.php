<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
  use Notifiable;
  protected $table = 'tugas';

  protected $primaryKey = 'id_tugas';

  protected $fillable = [
      'nama_tugas', 'id_project'
  ];
}
