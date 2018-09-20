<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
  use Notifiable;
  protected $table = 'project';
  protected $primaryKey = 'id_project';

  protected $fillable = [
      'nama_project', 'nama_penanggungjawab'
  ];
}
