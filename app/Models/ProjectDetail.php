<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class ProjectDetail extends Model
{
  use Notifiable;
  protected $table = 'project_detail';
  protected $guard = 'admin';
  protected $primaryKey = null;

  protected $fillable = [
      'id_project', 'id_admin'
  ];
}
