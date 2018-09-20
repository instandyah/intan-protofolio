<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'indexController@index')->name('index');




Auth::routes();

Route::get('/home', 'Anggota\ProjectController@index')->name('home');

Route::get('/ganttchart/{id_project}/{id_anggota}', 'Anggota\GanttChartAnggota@get')->name('this');
Route::get('/loadganttchart/{id_project}/{id_anggota}', 'Anggota\GanttChartAnggota@getvalueganttchart')->name('ganttchart.load');


Route::get('/users/logout', 'Auth\LoginController@userLogout')->name('user.logout');
// Route::get('/coba', 'Admin\AdminController@index');

Route::prefix('anggota')->group(function(){
  Route::get('{id_project}/aktivitas', 'Anggota\ActivityController@selectProject')->name('anggota.aktivitas');
  Route::get('{id_project}/anggota', 'Anggota\ProjectController@daftarAnggota')->name('anggota.project');
  Route::get('{id_project}/admin', 'Anggota\ProjectController@daftarAdmin')->name('anggota.project.admin');
  Route::get('EditProfil/{id_anggota}', 'Anggota\ProjectController@formEditAnggota')->name('anggota.edit.form');
  Route::put('EditProfil/{id_anggota}', 'Anggota\ProjectController@editAnggotaProfil')->name('anggota.edit.profil');
  Route::put('aktivitas/{id_aktivitas}', 'Anggota\ActivityController@editStatus')->name('aktivitas.edit');
  Route::put('aktivitas/editprogres/{id_aktivitas}', 'Anggota\ActivityController@updateprogres')->name('aktivitas.update');
  // Route::post('aktivitas/')
});


Route::prefix('admin')->group(function() {

  Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
  Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
  Route::get('/', 'Admin\AdminController@index')->name('admin.menu');
  Route::get('/anggota', 'Admin\AnggotaController@index')->name('admin.anggotalist');
  Route::get('/project', 'Admin\ProjectController@index')->name('admin.projectlist');
  Route::post('/create', 'Admin\ProjectController@createProject')->name('project.create');
  Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
  Route::get('/editprofile/{id_admin}', 'Admin\AdminController@formEdit')->name('admin.formedit');
  Route::get('/ganttchart/{id_project}/{progress}', 'Admin\GanttChartProjectController@get')->name('gantchartproject');
  Route::get('/loadganttchart/{id_project}/{progress}', 'Admin\GanttChartProjectController@getvalueganttchart')->name('gantchartprojectload');
  Route::get('notification/getall', 'NotificationController@getall')->name('notif.all');
  Route::put('/editprofile/{id_admin}', 'Admin\AdminController@updateAdmin')->name('admin.edit');

  Route::prefix('anggota')->group(function() {
    Route::get('/{id_anggota}', 'Admin\AnggotaController@selectAnggota')->name('anggotaaccount.select');
  });

});

Route::prefix('project')->group(function() {
  Route::get('{id_project}', 'Admin\ProjectController@selectProject')->name('project.select');
  Route::get('konfirmasi/{id}', 'NotificationController@konfhapus')->name('notif.konfirm');
  Route::get('ProjectDetail/{id_project}', 'Admin\ProjectController@projectDetail')->name('project.detail');
  Route::delete('projectdetail', 'Admin\ProjectController@deleteAdminProyek')->name('project.admin.delete');
  Route::post('konfirmasi', 'Admin\ProjectController@tolakkonfirmasi')->name('tolak.konfirm');
  Route::post('projectanggota', 'Admin\ProjectController@deleteAnggotasProject')->name('project.anggota.delete');
  Route::post('tambahdgnkode', 'Admin\ProjectController@addKode')->name('project.addkode');
  Route::put('{id_project}', 'Admin\ProjectController@editProject')->name('project.edit');
  Route::post('delete', 'Admin\ProjectController@deleteProject')->name('project.delete');
  Route::post('createanggota', 'Admin\AnggotaController@createAnggota')->name('anggota.create');
  Route::post('createtugas/{id_project}', 'Admin\TugasController@createTugas')->name('tugas.create');
  Route::post('tambahanggota/ada/{id_project}', 'Admin\AnggotaController@addExistAnggota')->name('anggota.tambah');
  Route::post('notification/get', 'NotificationController@get');
  Route::post('notification/read', 'NotificationController@read');
  // Route::post('notification/reade', 'NotificationController@readone');
  //new



  Route::prefix('tugas')->group(function() {
    Route::get('/{id_tugas}', 'Admin\TugasController@selectTugas')->name('tugas.select');
    Route::put('/{id_tugas}', 'Admin\TugasController@editTugas')->name('tugas.edit');
    Route::post('/konfirmasi', 'Admin\TugasController@tolakkonfirmasi')->name('tugas.tolak.konfirmasi');
    Route::post('/{id_tugas}', 'Admin\TugasController@deleteTugas')->name('tugas.delete');
    Route::put('/editpj/{id_tugas}', 'Admin\TugasController@editpjpj')->name('tugas.editpj');
    Route::post('createsubtugas/{id_tugas}', 'Admin\SubtugasController@createSubtugas')->name('subtugas.create');

    Route::prefix('subtugas')->group(function() {
      Route::put('/edit', 'Admin\SubtugasController@editSubtugas')->name('subtugas.edit');
      Route::delete('/{id_subtugas}', 'Admin\SubtugasController@deleteSubtugas')->name('subtugas.delete');
    });
  });

  Route::prefix('anggota')->group(function() {
    //new new

    //
    Route::get('/{id_anggota}/{id_project}', 'Admin\BagiTugasController@selectAnggota')->name('anggota.dashboard');
    Route::put('/{id_anggota}', 'Admin\AnggotaController@editAnggota')->name('anggota.edit');
    Route::post('/editpjanggota', 'Admin\BagiTugasController@editpjanggota')->name('pjanggota.edit');
    Route::post('/{id_anggota}', 'Admin\AnggotaController@deleteAnggota')->name('anggota.delete');

    Route::get('/ganttchart/{id_project}/{id_anggota}', 'Admin\GanttChartProjectController@getanggota')->name('gantchartanggota');
    Route::get('/loadganttchart/{id_project}/{id_anggota}', 'Admin\GanttChartProjectController@getvalueganttchartanggota')->name('loadgantchartanggota');

    Route::prefix('bagitugas')->group(function() {
      Route::post('/createpembagian', 'Admin\BagiTugasController@kirimtugas')->name('bagitugas.kirimtugas');
      Route::post('/cobaliatid', 'Admin\BagiTugasController@deletePembagianTugas')->name('bagitugas.delete');
      Route::put('/edit', 'Admin\BagiTugasController@editPJTugas')-> name('bagitugas.edit');
      Route::put('/editTanggal', 'Admin\BagiTugasController@editTanggal')-> name('bagitugas.editTanggal');
      Route::put('/konfirmasi', 'Admin\BagiTugasController@konfirmasi')-> name('bagitugas.konfirmasi');
      Route::post('/revisi', 'Admin\BagiTugasController@buttonRevisi')->name('bagitugas.revisi');
      Route::post('/revisi/batal', 'Admin\BagiTugasController@batalrevisi')->name('bagitugas.batalrevisi');
      // Route::delete('/{id_subtugas}', 'Admin\SubtugasController@deleteSubtugas')->name('subtugas.delete');
    });

  });


});
