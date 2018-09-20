
@extends('Layouts.header-admin')

@section('title', 'Dashboard Anggota')
<!-- =============================================== -->
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper isi">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row"  style="padding-bottom:0px;">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8" style="padding-bottom:0px;">
          <h2 class="judul">

            Anggota <small>{{ $anggota -> username }}</small>
          </h2>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content" style="padding-top:0px;">
      <div class="alert alert-success" style="display: none;">
        <h4><i class="icon fa fa-check"></i> Sukses!</h4>
        <p id="descalert">  Tugas Berhasil dihapus.</p>
      </div>
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
            <div class="col-lg-12">
              <p style="font-size:13px; color:#777" class="pull-right">dimasukan oleh : {{$anggota -> dibawa_oleh}}, {{$anggota -> created_at}}</p>
              <p id="pjpj"style="font-size:13px; color:#777" class="pull-left">penanggung jawab :
              @if ($PJanggota[0] -> nama_penanggungjawab == Auth::user() -> name)
                @if ($anggota -> name == null)
                  <a style="cursor : pointer;" data-toggle="modal" data-target="#Edit-PJ-anggota">Belum ditentukan</a>
                @else
                  <a id="editedit" style="cursor : pointer;"  data-toggle="modal" data-target="#Edit-PJ-anggota">{{ $anggota -> name}}</a>
                @endif
              @else
                @if ($anggota -> name == null)
                  Belum ditentukan
                @else
                    {{$anggota -> name}}
                @endif

              @endif
              </p>
            </div>

          </div>

          <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8" style="margin-bottom:5px;">
              <a href="{{route('gantchartanggota', ['id_project' => $id_project, 'id_anggota' => $anggota -> id_anggota])}}" target="_blank">
                <button type="button" class="btn bg-light-blue  btn-flat"><i class="fa fa-eye"></i> Lihat Progress
                </button>
              </a>
            </div>
            @if ($enabledelete == 'yes')
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4 " style="margin-bottom:5px;">
            @else
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 " style="margin-bottom:5px;">
            @endif

            @if ($anggota -> name == Auth::user() -> name || $PJanggota[0] -> nama_penanggungjawab == Auth::user() -> name)
              <button type="button" class="btn btn-success btn-flat pull-right" id="tambah_tugas" data-toggle="modal" data-target="#Tambah-tugas"> <i class="fa fa-plus"></i> Tambah Tugas</button>
            @else
              <button type="button" class="btn btn-success btn-flat pull-right" id="tambah_tugas" data-toggle="modal" data-target="#Tambah-tugas" disabled> <i class="fa fa-plus"></i> Tambah Tugas</button>
            @endif


            </div>
            @if ($enabledelete == 'yes')
              <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 ">
                <button id="deleteanggota" type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal" data-toggle="modal" data-target="#verifikasi"> <i class="fa fa-trash-o"></i> Hapus Anggota</button>
              </div>
            @endif

          </div>
          <br><br>
          <div class="row">

                <!-- /.box-header -->
                <div class="box-body">
                  <div class="daftarbagitugas">
                    <div class="box-group" id="accordion">
                      <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                      <form class="" action="" method="post">
                        <div class="listbagitugas">

                          <table class="table no-border no-margin">


                            <tr >

                              <th style="width:95%">
                                <center>
                                  Daftar Tugas
                                </center></th>
                                <th style="width:5%">
                                </th>
                              </tr>
                              <?php $i = 1; ?>
                              @foreach ($pembagian as $tugas)
                                <tr>

                                  <td>
                                    <div class="panel box no-border no-margin">
                                      @if ($tugas -> id_PJ1 !== $anggota -> id_anggota)
                                        <button type="button" class="btn btn-block btn-accordion btn-flat" data-toggle="collapse" data-parent="#accordion" href={{"#collapse".$i}} style="text-align:left;">  <i class="fa fa-tasks"></i> {{$tugas -> nama_tugas}} - {{$tugas -> PJ1}}</button>{{-- ini isinya nama_tugas --}}
                                      @else
                                        <button type="button" class="btn btn-block btn-accordion btn-flat" data-toggle="collapse" data-parent="#accordion" href={{"#collapse".$i}} style="text-align:left;">  <i class="fa fa-tasks"></i> {{$tugas -> nama_tugas}}</button>{{-- ini isinya nama_tugas --}}
                                      @endif

                                      <div id={{"collapse".$i}} class="panel-collapse collapse">
                                        <div class="box-body">
                                          <table class="table table-striped">
                                            <tr>
                                              <th style="width: 1%"></th>
                                              <th style="width:18%" >Sub Tugas</th>
                                              <th style="width:17%" >Status</th>
                                              <th style="width:24%" >keterangan</th>
                                              <th style="width:20%">Batas Tanggal</th>
                                              <th style="width:15%">PJ</th>
                                              <th style="width:5%">Aksi</th>
                                            </tr>
                                            @foreach ($iniapa as $inisubtugas)
                                              @if($inisubtugas -> nama_tugas == $tugas -> nama_tugas)
                                                <tr class="tab" style="padding-bottom:0px;">
                                                  <td><i class="fa fa-circle-o"></i></td>
                                                  @if ($inisubtugas -> keterangan == null)
                                                    <td>{{ $inisubtugas -> nama_subtugas}} {{$inisubtugas -> keterangan}} {{$inisubtugas -> revisi_hit}} <br><small> (Bobot: {{$inisubtugas -> bobot}})</small></td>
                                                  @else
                                                  <td>{{ $inisubtugas -> nama_subtugas}} {{$inisubtugas -> keterangan}} {{$inisubtugas -> revisi_hit}}<br><small> (Bobot: {{$inisubtugas -> bobot}})</small> <br> <a class="dskrps" style="cursor: pointer;" data-toggle="modal" data-target="#deskripsirev"><small>lihat keterangan revisi</small>
                                                    <input type="hidden" name="deskripsi_revisi" value="{{ $inisubtugas -> deskripsi }}">
                                                    <input type="hidden" name="nasub" value="{{ $inisubtugas -> nama_subtugas }}">
                                                    <input type="hidden" name="idaktiv" value="{{ $inisubtugas -> id_aktivitas }}">
                                                  </a> </td>
                                                  @endif

                                                  @if ($inisubtugas -> status == null )
                                                    <td>Belum dikerjakan</td>
                                                  @else
                                                    @if ($inisubtugas -> status == 'Selesai')
                                                      <td> <b style="color: #3c8dbc">{{$inisubtugas -> status}} </b><br>
                                                        <small>{{$inisubtugas -> start_date}} <br> sampai <br> {{$inisubtugas -> end_date}}</small>
                                                      </td>
                                                    @elseif ($inisubtugas -> status == 'Ditunda')
                                                      <td> <b style="color: #f39c12">{{$inisubtugas -> status}} </b><br>
                                                        <small>Mulai tugas:<br> {{$inisubtugas -> start_date}}</small>
                                                      </td>
                                                    @else

                                                        <td> <b style="color: #00a65a">{{$inisubtugas -> status}} </b><br>
                                                          <small>{{$inisubtugas -> start_date}}</small>
                                                        </td>

                                                    @endif
                                                  @endif
                                                  @if (($inisubtugas -> status == 'Selesai' || $inisubtugas -> status == 'Ditunda') && $inisubtugas -> confirm == null)
                                                    @if ($anggota -> name == Auth::user() -> name || $PJanggota[0] -> nama_penanggungjawab == Auth::user() -> name)
                                                      @if ($inisubtugas -> status == 'Selesai')
                                                        <td><small>(Belum dikonfirmasi)</small> <br>
                                                          <button type="button" class="btn btn-primary btn-flat konfirm"> Konfirmasi
                                                          <input type="hidden" name="id_aktivitas" value="{{ $inisubtugas -> id_aktivitas }}">
                                                          <input type="hidden" name="stts" value="{{ $inisubtugas -> status }}">
                                                          <input type="hidden" name="jns" value="knfrm">
                                                        </button>
                                                        @if ($inisubtugas -> postpone_end !== null)
                                                        <small><br><b style="color: #f39c12">Ditunda: </b><br>
                                                          {{$inisubtugas -> postpone_start}} - {{$inisubtugas -> postpone_end}}</small>
                                                        @endif
                                                      </td>
                                                      @else
                                                        <td><small style="color: #f39c12">Mulai ditunda:</small>
                                                          <small>{{$inisubtugas -> postpone_start}}<br>(Belum dikonfirmasi)</small><br>
                                                          <button type="button" class="btn btn-primary btn-flat konfirm"> Konfirmasi
                                                          <input type="hidden" name="id_aktivitas" value="{{ $inisubtugas -> id_aktivitas }}">
                                                          <input type="hidden" name="stts" value="{{ $inisubtugas -> status }}">
                                                          <input type="hidden" name="jns" value="knfrm">
                                                        </button>

                                                      </td>
                                                      @endif
                                                    @endif
                                                  @elseif (($inisubtugas -> status == 'Selesai') && ($inisubtugas -> confirm !== null))
                                                    <td> {{$inisubtugas -> confirm}}
                                                      <small><br>Pada tanggal: {{$inisubtugas -> updated_at}}</small>
                                                      @if ($inisubtugas -> postpone_end !== null)
                                                      <small><br><b style="color: #f39c12">Ditunda: </b><br>
                                                        {{$inisubtugas -> postpone_start}} - {{$inisubtugas -> postpone_end}}</small>
                                                      @endif
                                                    </td>
                                                  @elseif (($inisubtugas -> confirm !== null) && ($inisubtugas -> status == 'Ditunda'))
                                                    <td> Ditunda <br>
                                                      <small style="color: #f39c12">Mulai ditunda:</small>
                                                      <small>{{$inisubtugas -> postpone_start}}</small>
                                                        <small>{{$inisubtugas -> postpone_end}}</small>
                                                        <br><small>({{$inisubtugas -> confirm}})</small>
                                                    </td>
                                                  @else
                                                    @if ($inisubtugas -> status == 'Dikerjakan')
                                                      @if ($inisubtugas -> confirm_progress == null )
                                                        <td>Progress tugas {{$inisubtugas -> progress}}% <br>
                                                          <small>Terakhir update : {{$inisubtugas -> updated_at}}</small>
                                                          <br>
                                                          <button type="button" class="btn btn-primary btn-flat konfirm"> Konfirmasi
                                                          <input type="hidden" name="id_aktivitas" value="{{ $inisubtugas -> id_aktivitas }}">
                                                          <input type="hidden" name="stts" value="{{ $inisubtugas -> status }}">
                                                          <input type="hidden" name="jns" value="knfrmprgrs">
                                                        </button>
                                                        @if ($inisubtugas -> postpone_end !== null)
                                                        <small><br><b style="color: #f39c12">Ditunda: </b><br>
                                                          {{$inisubtugas -> postpone_start}} - {{$inisubtugas -> postpone_end}}</small>
                                                        @endif
                                                        </td>
                                                      @else
                                                        <td>Progress tugas {{$inisubtugas -> progress}}% <br>
                                                          <small>Terakhir update : {{$inisubtugas -> updated_at}}</small>
                                                          <small>({{$inisubtugas -> confirm_progress}})</small>
                                                          @if ($inisubtugas -> postpone_end !== null)
                                                          <small><br><b style="color: #f39c12">Ditunda: </b><br>
                                                            {{$inisubtugas -> postpone_start}} - {{$inisubtugas -> postpone_end}}</small>
                                                          @endif
                                                        </td>
                                                      @endif
                                                    @else
                                                      <td></td>
                                                    @endif

                                                  @endif
                                                  {{-- tanggalan --}}
                                                  <td>
                                                    @if ($inisubtugas -> status == 'Selesai')
                                                      <div class="form-group">
                                                          <div class="input-group date no-padding">
                                                            <div class="input-group-addon no-border" style="background-color:transparent;">
                                                              <i class="fa fa-calendar"></i>
                                                            </div>
                                                            @if ($inisubtugas -> due_date !== null)
                                                              <p class="no-margin">{{ $inisubtugas -> due_date}}</p>
                                                            @else
                                                              <p class="no-margin">Batas tanggal tidak ditentukan</p>
                                                            @endif
                                                          </div>
                                                          <!-- /.input group -->
                                                        </div>
                                                    @else
                                                      <div class="form-group">
                                                          <div class="input-group date no-padding">
                                                            <div class="input-group-addon no-border" style="background-color:transparent;">
                                                              <i class="fa fa-calendar"></i>
                                                            </div>
                                                            @if ($inisubtugas -> due_date !== null)
                                                              <p class="no-margin">{{ $inisubtugas -> due_date}}</p>
                                                            @else
                                                              <p class="datepick no-margin"> Tanggal belum di atur</p>
                                                            @endif
                                                            @if ($anggota -> name == Auth::user() -> name || $PJanggota[0] -> nama_penanggungjawab == Auth::user() -> name)
                                                              <a href="" class="edittanggal" data-toggle="modal" data-target="#tanggaledit"><small class="no-margin">Atur tanggal
                                                                <input type="hidden" name="id_aktvt" value="{{$inisubtugas -> id_aktivitas}}">
                                                                <input type="hidden" name="duedate" value="{{$inisubtugas -> due_date}}">
                                                              </small></a>
                                                            @endif
                                                          </div>
                                                          <!-- /.input group -->
                                                        </div>
                                                    @endif

                                                  </td>
                                                  {{-- ini PJ2 --}}
                                                  <td class="inipj2">
                                                    {{ $inisubtugas -> username2}}
                                                  </td>
                                                  <td>
                                                    @if ($anggota -> name == Auth::user() -> name || $PJanggota[0] -> nama_penanggungjawab == Auth::user() -> name)
                                                      @if ($inisubtugas -> status == 'Selesai' )
                                                        {{-- ini tombol revisi --}}
                                                        @if ($inisubtugas -> confirm == null)

                                                        @else
                                                          <button type="button" class="btn btn-primary btn-flat rev" data-toggle="modal" data-target="#revisi"> Revisi
                                                            <input type="hidden" name="id_pembagianrevisi" value="{{ $inisubtugas -> id_pembagian }}">
                                                            <input type="hidden" name="nama_subtugasrevisi" value="{{ $inisubtugas -> nama_subtugas }}">
                                                          </button>
                                                        @endif
                                                      @else
                                                        <button type="button" class="btn btn-primary btn-flat editPJ2button" data-toggle="modal" data-target="#Edit-PJ"> <i class="fa fa-edit"></i>
                                                          <input type="hidden" name="slctpj" value="{{ $inisubtugas -> username2 }}">
                                                          <input type="hidden" name="id_pembagian" value="{{ $inisubtugas -> id_pembagian}}">

                                                        </button>
                                                      @endif
                                                    @endif


                                                  </td>
                                                </tr>
                                              @endif
                                            @endforeach
                                          </table>
                                        </div>
                                      </div>
                                    </div>
                                  </td>
                                  <td>
                                    @if ($anggota -> name == Auth::user() -> name || $PJanggota[0] -> nama_penanggungjawab == Auth::user() -> name)
                                      <button type="button" id="{{ $tugas -> id_tugas }}" class="btn btn-danger  btn-flat deletepembagian" data-toggle="modal" data-target="#verifikasi"><i class="fa fa-trash-o"></i></button>
                                      {{csrf_field()}}
                                    @endif

                                  </td>

                                </tr>
                                <?php $i++; ?>
                              @endforeach

                            </table>

                          </div>
                        </form>

                      </div>
                    </div>
                  </div>
                  <!-- /.box-body -->


            </div>
          </div>

        </div>
        <!-- /.box -->

      </section>

      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!--modal-->
    <div class="modal fade" id="Tambah-tugas">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="box box-primary">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tambahkan Tugas Untuk {{$anggota -> username}}</h4>
              </div>
              <div class="modal-body">
                <!-- form -->
                <!-- form start -->
                <form class="form-horizontal">
                  {{csrf_field()}}
                  <div class="box-body">
                    <div id="listtugas">
                      <ul class="list-unstyled" id="checkbox">
                        @foreach ($tugastersedia as $tugasini)
                          <li>
                            <label>
                              <input  type="checkbox" value="{{$tugasini -> id_tugas}}">
                              {{$tugasini -> nama_tugas}}
                            </label>
                          </li>
                        @endforeach
                      </ul>
                    </div>
                  </div>
                  <!-- /.box-body -->
                </form>
                <!--  -->
              </div>
              <div class="modal-footer">
                <a href="{{route('project.select', ['id_project' => $id_project ])}}"><button type="button" class="btn btn-success btn-flat pull-left">Buat Tugas Baru</button></a>
                <button type="button" class="btn btn-danger btn-flat" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary  btn-flat" id="submit_tugas">Tambahkan</button>
              </div>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <div class="modal fade" id="Edit-PJ-anggota">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="box box-primary">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Penanggung jawab anggota</h4>
                </div>
                <form class="form-horizontal" method="POST" action="">
                  {{ csrf_field() }}
                  <div class="modal-body">
                    <!-- form -->
                    <!-- form start -->
                    <div class="formeditproyek">
                      <div class="box-body">
                        <div class="form-group " id="nama_penanggungjawab">
                          <label>Pilih Penanggungjawab</label>
                            <select id="penanggungjawabanggota" class="form-control selectpjproyek" style="width: 100%;">
                              @foreach ($listadmins as $admins)
                                <option>{{ $admins -> name}}</option>
                              @endforeach
                            </select>

                        </div>
                      </div>
                    </div>

                    <!-- /.box-body -->
                    <!--  -->
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-flat btn-danger" data-dismiss="modal">Batal</button>
                    <button type="button" id="submit_proyek" name="submit" class="btn btn-flat btn-primary">Simpan Perubahan</button>
                  </div>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

      <div class="modal fade" id="revisi">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="box box-primary">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="revisitugas"></h4>
                </div>
                <div class="modal-body">
                  <!-- form -->
                  <!-- form start -->
                  <form class="form-horizontal">
                    {{csrf_field()}}
                    <div class="box-body formrevisi">
                      <div class="form-group" id="form-group-ketrev">
                        <label>Keterangan Revisi</label>
                        <textarea id="ketrev" name="ketrev" type="text" class="form-control" placeholder="Masukkan Keterangan Revisi" required></textarea>
                        <span class="help-block"></span>
                      </div>
                    </div>
                    <!-- /.box-body -->
                  </form>
                  <!--  -->
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger btn-flat" data-dismiss="modal">Batal</button>
                  <button type="button" class="btn btn-primary  btn-flat btnrevisi">revisi</button>
                </div>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

      <div class="modal fade" id="deskripsirev">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="box box-primary">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="deskripsirevisitugas"></h4>
                </div>
                <div class="modal-body">
                  <!-- form -->
                  <!-- form start -->
                  <form class="form-horizontal">
                    {{csrf_field()}}
                    <div class="box-body">
                      <p class="dk"></p>
                    </div>
                    <!-- /.box-body -->
                  </form>
                  <!--  -->
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger btn-flat idaktvt" data-dismiss="modal" data-toggle="modal" data-target="#verifikasi">Batalkan Revisi</button>
                </div>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="tanggaledit">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="box box-primary">
                  <div class="modal-body" style="padding-bottom:0;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <div class="box-body" style="padding-bottom:0;">

                      <label> Batas Tanggal</label>
                      {{csrf_field()}}
                      <div class="form-group" style="margin-bottom:0;">
                          <div class="input-group date ">
                            <div class="input-group-addon ">
                              <i class="fa fa-calendar"></i>
                            </div>
                              <input type="text" class="form-control pull-right datepicker">
                          </div>

                        </div>


                  </div>
                  </div>
                  <div class="modal-footer no-border">
                    <button type="button" class="btn btn-danger btn-flat" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary btn-flat submittgl">Simpan</button>
                  </div>
                </div>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>

        <div class="modal fade" id="Edit-PJ">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="box box-primary">
                <form class="form-horizontal">
                  {{csrf_field()}}
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Sunting Penanggung Jawab</h4>
                    </div>
                    <div class="modal-body">
                      <!-- form -->
                      <!-- form start -->
                      <div class="formeditPJ">
                        <div class="box-body">
                          <div class="form-group">
                            <label>Penanggung Jawab 2</label>
                            <select id="PJ2picker" class="form-control select2" style="width: 100%;">
                              {{-- @if ($subtugas->count() > 0) --}}
                              <option>Pilih Anggota</option>
                              @foreach ($anggotas as $listanggota)
                                <option>{{ $listanggota -> username}}</option>
                              @endforeach
                              {{-- @else
                              <option>Data subtugas belum tersedia</option>
                            @endif --}}
                          </select>
                        </div>
                        <div class="form-group">

                        </div>
                      </div>
                    </div>
                    <!-- /.box-body -->

                    <!--  -->
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal">Batal</button>
                    <button id="submiteditPJ" type="button" class="btn btn-primary btn-flat ">Simpan Perubahan</button>
                  </div>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!--modal-->
        <div class="modal modal-danger fade" id="verifikasi">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="box box-danger">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Peringatan</h4>
                  </div>
                  <div class="modal-body">
                    <strong>Apakah anda yakin?</strong>
                    <p id="desc">Sekali melakukan penghapusan maka anda tidak dapat mengembalikan anggota yang sudah dihapus</p>
                    <!--  -->
                  </div>
                  <form class="" action="" method="post">
                    {{csrf_field()}}
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default btn-flat " data-dismiss="modal">Tidak</button>
                      <button id="submitdeleteanggota" type="button" class="btn btn-default btn-flat ">Ya</button>
                      <button id="submitdeletepembagian" type="button" class="btn btn-default btn-flat " style="display : none;">Hapus</button>
                      <button id="submitbatalrevisi" type="button" class="btn btn-default btn-flat " style="display : none;">Batalkan</button>
                    </div>
                  </form>
                </div>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>

        @endsection
        @section('script')
          <script>
          $(document).ready(function () {

            $("#submit_tugas").click(function(e) {
              e.preventDefault();
              var _token = $("input[name='_token']").val();
              var allVals = [];
              $('#checkbox :checked').each(function() {
                allVals.push($(this).val());
              });
              allvalss= JSON.stringify(allVals);
              console.log(allVals);
              $.ajax({
                url : "{{route('bagitugas.kirimtugas')}}",
                type : 'POST',
                data : {_token : _token, value : allVals, id_anggota : {{$anggota -> id_anggota}}},
                success : function(data) {
                  console.log(data);
                  //
                  $("#descalert").text('Tugas berhasil ditambahkan')
                  $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                    $(".alert").slideUp(500);
                  });
                  $("#Tambah-tugas").modal('hide');

                  $(".daftarbagitugas").load(location.href + ' .daftarbagitugas');
                  $("#listtugas").load(location.href + ' #listtugas');
                },
                error : function(response){
                  console.log(response);
                  var obj = response.responseJSON
                  for (let i in obj) {
                    showValidationErrors(i, obj[i][0]);
                  }
                  // associate_errors(erros, $form);
                }
              });
            });


            //edit PJ Anggota
            $(document).on('click', '#editedit', function(e) {
              var selected = $(this).text();
              $('#penanggungjawabanggota > option').each(function(){
                if($(this).text()==selected) $(this).parent('select').val($(this).val())
              })
              console.log(selected);
            });

            $(document).on('click', '#submit_proyek', function(e) {
              e.preventDefault();
              var _token = $("input[name='_token']").val();
              var selected = $('#nama_penanggungjawab').find(":selected").text();;

              console.log(selected);
              $.ajax({
                url : "{{route('pjanggota.edit')}}",
                type : 'POST',
                data : {_token : _token, penanggungjawab : selected, id_anggota : {{$anggota -> id_anggota}}, id_project : {{$id_project}}},
                success : function(data) {
                  console.log(data);
                  $("#descalert").text('Penanggung jawab anggota berhasil diubah')
                  $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                    $(".alert").slideUp(500);
                  });
                  $("#Edit-PJ-anggota").modal('hide');
                  $("#pjpj").load(location.href + ' #pjpj');

                },
                error : function(response){
                  console.log(response);
                  var obj = response.responseJSON
                  for (let i in obj) {
                    showValidationErrors(i, obj[i][0]);
                  }
                  // associate_errors(erros, $form);
                }
              });
            });

            //edit pembagian_tugas
            $(document).on('click', '.editPJ2button', function(event) {

              var selected = $(this).find("input[name='slctpj']").val();
              var id = $(this).find("input[name='id_pembagian']").val();
              $('#PJ2picker > option').each(function(){
                if($(this).text()==selected) $(this).parent('select').val($(this).val())
              })
              $('#submiteditPJ').val(id);
              console.log(selected);
              console.log(id);
            })

            $("#submiteditPJ").click(function(e) {
              e.preventDefault();
              var _token = $("input[name='_token']").val();
              var selectedPJ2new = $('#PJ2picker').find(":selected").text();
              var id =   $(this).val();
              $.ajax({
                url : "{{route('bagitugas.edit')}}",
                type : 'PUT',
                data : {_token : _token, nama_pj2 : selectedPJ2new, id_pembagian : id},
                success : function(data) {
                  console.log(data);
                  $("#Edit-PJ").modal('hide');

                  $(".listbagitugas").load(location.href + ' .listbagitugas');
                  $("#descalert").text('Perubahan Penanggung Jawab 2 berhasil disimpan');
                  $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                    $(".alert").slideUp(500);
                  });
                },
                error : function(response){
                  console.log(response);
                  var obj = response.responseJSON
                  for (let i in obj) {
                    showValidationErrors(i, obj[i][0]);
                  }
                  // associate_errors(erros, $form);
                }
              });
            });
            //konfirmasi tugas
            $(document).on('click', '.konfirm', function(e) {
              e.preventDefault();
              var _token = $("input[name='_token']").val();
              var confirm = 'Dikonfirmasi '+'{{Auth::user() -> name}}';
              var id_aktivitas = $(this).find("input[name='id_aktivitas']").val();
              var jenis = $(this).find("input[name='jns']").val();
              var stts = $(this).find("input[name='stts']").val();
              console.log(confirm);
              console.log(id_aktivitas);
              $.ajax({
                url : "{{route('bagitugas.konfirmasi')}}",
                type : 'PUT',
                data : {_token : _token, confirm : confirm, id_aktivitas : id_aktivitas, jenis : jenis, status : stts},
                success : function(data) {
                  console.log(data);

                  $(".listbagitugas").load(location.href + ' .listbagitugas');
                  $("#descalert").text('Status tugas berhasil dikonfirmasi');
                  $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                    $(".alert").slideUp(500);
                  });
                },
                error : function(response){
                  console.log(response);
                  var obj = response.responseJSON
                  for (let i in obj) {
                    showValidationErrors(i, obj[i][0]);
                  }
                  // associate_errors(erros, $form);
                }
              });
            });

            //MODAL ON hidden
            $("#Edit-anggota").on('hidden.bs.modal', function() {
              $(".formeditanggota").load(location.href + ' .formeditanggota');
            });

            $("#Tambah-tugas").on('hidden.bs.modal', function() {
              $("#listtugas").load(location.href + ' #listtugas');
            });

            $("#revisi").on('hidden.bs.modal', function() {
              $(".formrevisi").load(location.href + ' .formrevisi');
            });


            function showValidationErrors(name, error) {
              var group = $("#form-group-" + name);
              group.addClass('has-error');
              group.find('.help-block').text(error);
            };
            function clearValidationError(name) {
              var group = $("#form-group-" + name);
              group.removeClass('has-error');
              group.find('.help-block').text('');
            };
            $("#ketrev").on('keyup', function () {
              clearValidationError($(this).attr('id').replace('#', ''))
            });

            //when DELETE
            $(document).on('click', '.deletepembagian', function()
            {
              var id = $(this).attr('id');
              console.log(id);
              $('#submitdeletepembagian').val(id);
              $("#desc").text('Hapus pembagian tugas ini dari {{$anggota -> username}}')
              $("#submitdeleteanggota").hide();
              $("#submitdeletepembagian").show();
              $("#submitbatalrevisi").hide();
            });

            $(document).on('click', '#deleteanggota', function()
            {
              $("#desc").text('Anda yakin menghapus {{$anggota -> username}} dari proyek ini?')
              $("#submitdeleteanggota").show();
              $("#submitdeletepembagian").hide();
              $("#submitbatalrevisi").hide();
            });

            $('#submitdeletepembagian').click(function(e) {
              var _token = $("input[name='_token']").val();
              var id_tugas = $(this).val();
              console.log(id_tugas);
              $.ajax({
                url : "{{route('bagitugas.delete')}}",
                type : 'POST',
                data : {_token : _token, id_tugas : id_tugas},
                success : function(data) {
                  console.log(data);
                  $("#descalert").text('Tugas berhasil dihapus')
                  $(".alert").fadeTo(2000, 500).slideUp(500, function(){

                    $(".alert").slideUp(500);
                  });
                  $("#verifikasi").modal('hide');

                  $("#listtugas").load(location.href + ' #listtugas');
                  $(".listbagitugas").load(location.href + ' .listbagitugas');
                },
                error : function(response){
                  console.log(response);
                  var obj = response.responseJSON
                  for (let i in obj) {
                    showValidationErrors(i, obj[i][0]);
                  }
                  // associate_errors(erros, $form);
                }
              });
            });

            $(document).on('click', '#submitdeleteanggota', function(event) {
              var _token = $("input[name='_token']").val();
              var id_anggota = "{{ $anggota -> id_anggota}}";
              var id_project = "{{ $id_project}}";
              console.log(id_project);
              console.log(id_anggota);
              $.ajax({
                url : "{{route('project.anggota.delete')}}",
                type : 'POST',
                data : {_token : _token, id_project : id_project, id_anggota : id_anggota},
                success : function(data) {
                  console.log(data);
                  window.location.href = "{{route('project.select', ['id_project' => $id_project])}}";
                },
                error : function(response){
                  console.log(response);
                  var obj = response.responseJSON
                  for (let i in obj) {
                    showValidationErrors(i, obj[i][0]);
                  }
                  // associate_errors(erros, $form);
                }
              });
            })

            //REVISI BUTTON
            $(document).on('click', '.rev', function(e) {
              var nama_subtugasrevisi = $('.rev').find("input[name='nama_subtugasrevisi']").val();
              console.log(nama_subtugasrevisi);
              $('#revisitugas').text('Revisi tugas '+nama_subtugasrevisi);
            });

            $(document).on('click', '.dskrps', function(e) {
              var deskripsi_revisi = $(this).find("input[name='deskripsi_revisi']").val();
              var nasub = $(this).find("input[name='nasub']").val();
              var id_aktivitas = $(this).find("input[name='idaktiv']").val();
              console.log(id_aktivitas);
              $('.dk').text(deskripsi_revisi);
              $('#deskripsirevisitugas').text('Deskripsi revisi tugas '+nasub);
              $('.idaktvt').val(id_aktivitas);
            });

            $(document).on('click', '.btnrevisi', function(e) {
              var _token = $("input[name='_token']").val();
              var deskripsi = $('#revisi').find("textarea[name='ketrev']").val();
              var id = $('.rev').find("input[name='id_pembagianrevisi']").val();
              console.log(deskripsi);
              if (deskripsi == '') {
                showValidationErrors('ketrev', 'Deskripsi revisi harus diisi');
              } else {
                $.ajax({
                  url : "{{route('bagitugas.revisi')}}",
                  type : 'POST',
                  data : {_token : _token, id_pembagian : id, deskripsi : deskripsi},
                  success : function(data) {
                    console.log(data);
                    $("#descalert").text('Tugas direvisi')
                    $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                      $(".alert").slideUp(500);
                    });
                    $("#revisi").modal('hide');
                    //
                    // $("#listtugas").load(location.href + ' #listtugas');
                    $(".listbagitugas").load(location.href + ' .listbagitugas');
                  },
                  error : function(response){
                    console.log(response);
                    var obj = response.responseJSON
                    for (let i in obj) {
                      showValidationErrors(i, obj[i][0]);
                    }
                    // associate_errors(erros, $form);
                  }
                });
              }
            })
            $(document).on('click', '.idaktvt', function()
            {
              var id = $(this).val();
              console.log(id);
              $('#submitbatalrevisi').val(id);
              $("#desc").text('Anda yakin melakukan pembatalan revisi?')
              $("#submitdeleteanggota").hide();
              $("#submitdeletepembagian").hide();
              $("#submitbatalrevisi").show();
            });

            $(document).on('click', '#submitbatalrevisi', function(e) {
              var _token = $("input[name='_token']").val();
              var id_aktivitas = $(this).val();
              console.log(id_aktivitas);
              $.ajax({
                url : "{{route('bagitugas.batalrevisi')}}",
                type : 'POST',
                data : {_token : _token, id_aktivitas : id_aktivitas},
                success : function(data) {
                  console.log(data);
                  $("#descalert").text('Revisi tugas dibatalkan')
                  $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                    $(".alert").slideUp(500);
                  });
                  $("#verifikasi").modal('hide');
                  //
                  $("#listtugas").load(location.href + ' #listtugas');
                  $(".listbagitugas").load(location.href + ' .listbagitugas');
                },
                error : function(response){
                  console.log(response);
                  var obj = response.responseJSON
                  for (let i in obj) {
                    showValidationErrors(i, obj[i][0]);
                  }
                  // associate_errors(erros, $form);
                }
              });
            });

            $(document).on('click', '.edittanggal', function(){

                var id = $(this).find("input[name='id_aktvt']").val();
                var due_date = $(this).find("input[name='duedate']").val();
                console.log(id);
                $('.submittgl').val(id);
                if (due_date == '') {
                    $('.datepicker').datepicker({ autoclose: true, dateFormat: 'dd-mm-yy'}).datepicker( "setDate", new Date() );
                    console.log('gada');
                } else {
                  $('.datepicker').datepicker({ autoclose: true, dateFormat: 'dd-mm-yy'}).datepicker( "setDate", new Date(due_date) );
                }
            });

            $(document).on('click', '.submittgl', function(){
                var _token = $("input[name='_token']").val();
                var id_aktivitas = $(this).val();
                var date = $(".datepicker").val()
                console.log(date, id_aktivitas);
                $.ajax({
                  url : "{{route('bagitugas.editTanggal')}}",
                  type : 'PUT',
                  data : {_token : _token, due_date : date, id_aktivitas : id_aktivitas},
                  success : function(data) {
                    console.log(data);
                    $("#tanggaledit").modal('hide');

                    $(".listbagitugas").load(location.href + ' .listbagitugas');
                    $("#listtugas").load(location.href + ' #listtugas');
                    $("#descalert").text('Perubahan batas tanggal berhasil disimpan');
                    $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                      $(".alert").slideUp(500);
                    });
                  },
                  error : function(response){
                    console.log(response);
                    var obj = response.responseJSON
                    for (let i in obj) {
                      showValidationErrors(i, obj[i][0]);
                    }
                    // associate_errors(erros, $form);
                  }
                });

            });
          })
          </script>

        @endsection
