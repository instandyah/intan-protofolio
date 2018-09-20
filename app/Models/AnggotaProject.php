<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;

class AnggotaProject extends Model
{
  use Notifiable;
  protected $table = 'anggota_project';
  protected $guard = 'admin';
  protected $primaryKey = null;

  protected $fillable = [
      'id_project', 'id_anggota'
  ];
}
