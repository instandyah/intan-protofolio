<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\Anggota;

use Auth;

class AppServiceProvider extends ServiceProvider
{
  /**
  * Bootstrap any application services.
  *
  * @return void
  */
  public function boot()
  {
    Schema::defaultStringLength(191);
    view()->composer('Layouts.header-admin', function($view)
    {
      $projects = DB::table('project_detail')
      ->join('project', 'project_detail.id_project', '=', 'project.id_project')
      ->where('id_admin', Auth::id())
      ->get();
      $anggotas = Anggota::all();
      $view->with('projects', $projects)->with('anggotas', $anggotas);
    });
  }

  /**
  * Register any application services.
  *
  * @return void
  */
  public function register()
  {
    //
  }
}
