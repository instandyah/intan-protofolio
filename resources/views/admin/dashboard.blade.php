
@extends('Layouts.header-admin')

@section('title', 'Dashboard Proyek')
<!-- =============================================== -->
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper isi">
    <!-- Content Header (Page header) -->
    <section class="content-header" style="margin-bottom : 0px;">
      <div class="row"  style="padding-bottom:0px;">
        <div class="col-lg-8 col-md-8" style="padding-bottom:0px;">
          <h2 class="judul">
            Dashboard
            <small>{{ $projects -> nama_project}}</small>

          </h2>
        </div>
        <div class="col-lg-4 col-md-4 pull-right"  style="padding-bottom:0px;">
          {{-- <br><h2>
            <a href="#" id="buttonedit" data-toggle="modal" data-target="#Edit-proyek" style="font-size:10pt; margin-bottom:0px;" class="pull-right"><i class="fa fa-pencil"></i> Sunting </a>

          </h2> --}}
          <br>
          <ol class="breadcrumb pull-right pr" style="background-color:transparent; margin-bottom:0px;">
            @if ($projects -> nama_penanggungjawab == Auth::user() -> name)
              <li style="font-size:10pt;"><a href="#" id="buttonedit" data-toggle="modal" data-target="#Edit-proyek"><i class="fa fa-pencil"></i> Sunting
                <input type="hidden" id="selectedpjproyek" name="" value="{{ $projects -> nama_penanggungjawab }}">
              </a></li>
            @endif

            <li style="font-size:10pt;"><a href="{{route('project.detail', ['id_project' => $projects -> id_project ])}}"><i class="fa fa-info-circle"></i> Daftar Admin </a></li>
          </ol>

        </div>
      </div>

    </section>

    <!-- Main content -->
    <section class="content" style="padding-top: 0px;">
      <div class="alert alert-success" style="display: none;">
        <h4><i class="icon fa fa-check"></i> Sukses!</h4>
      <p id="descalert">  Proyek Berhasil ditambahkan.</p>
      </div>
      @if(session()->has('message'))
        <div class="alert alert-success hapus">
          <h4><i class="icon fa fa-check"></i> Sukses!</h4>
          <p>{{ session()->get('message') }}</p>
        </div>
      @endif
      <div class="box box-default">
        <div class="box-body">
          <div class="callout callout-info">
            <h4>Kode Proyek : {{ $projects -> kode_project}}</h4>
          <p class="oy" style=" font-size:12px">{{$projects -> nama_penanggungjawab}}, Dibuat Tanggal : {{$projects -> created_at}}</p>
          </div>

          <table class="table table-striped">
            <tr>
              <th><h4>Progres Proyek</h4></th>
              <th style="width: 40px"></th>
            </tr>
            <tr>
              <td style="width:90%">
                <div class="progress progress-lg progress-striped active">
                  <div class="progress-bar progress-bar-primary" style="width: {{$persentase}}%"></div>
                </div>
              </td>
              <td><center>
                <span class="badge bg-aqua" style="width:38px; height:25px; padding:4px; font-size:12pt; margin-top:5px;">{{$persentase}} %</span>
              </center></td>
            </tr>
            <tr style="background-color:white;">
              <td><a href="{{route('gantchartproject', ['id_project' => $projects -> id_project, 'progress' => $persentase])}}"><button type="button" class="btn btn-default btn-flat"> <i class="fa fa-eye"></i> Lihat Progres Project</button></a>

              </td>
            </tr>
          </table>
          <br>
        </div>
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="nav-tabs-custom tab-primary ">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#tugas" data-toggle="tab">Kelola Tugas</a></li>
                  <li><a href="#anggota" data-toggle="tab">Kelola Anggota</a></li>
                </ul>
                <div class="tab-content">
                  <!-- Font Awesome Icons -->
                  <div class="tab-pane active" id="tugas">
                    <div class="proyekbox">
                      <br>
                      <p>Kelola Tugas</p>
                      <div class="tugas">
                        <div class="row">
                          @if ($enableadd == 'yes')
                            <div class="col-md-3">
                              <button id="tambah_tugas" type="button" class="btn  btn-proyek btn-block btn-modal btn-reddit btn-lg btn-flat" data-toggle="modal" data-target="#tambah-tugas">
                                <i class="fa fa-plus"></i><br>
                                Tambah Tugas
                              </button>
                            </div>
                          @endif
                          @foreach ($tugas as $tugas)
                            <div class="col-md-3">
                              <a href="{{route('tugas.select', ['id_tugas' => $tugas -> id_tugas])}}">
                                <button type="button" class="btn  btn-proyek btn-block  btn-tumblr btn-lg btn-flat" style="white-space: normal;">
                                  {{ $tugas -> nama_tugas}}
                                </button>
                              </a>
                            </div>
                          @endforeach
                        </div>
                      </div>

                    </div>
                  </div>
                  <!-- /#fa-icons -->

                  <!-- glyphicons-->
                  <div class="tab-pane" id="anggota">
                    <div class="proyekbox">
                      <br>
                      <p>Kelola Anggota</p>
                      <div class="anggota">
                        <div class="row">
                          @if ($enableadd == 'yes')
                          <div class="col-md-3">
                            <button id="tambah_anggota" type="button" class="btn  btn-proyek btn-block btn-modal btn-lg btn-flat"  data-toggle="modal" data-target="#viewlist">
                              <i class="fa fa-plus"></i><br>
                              Tambah Anggota
                            </button>
                          </div>
                        @endif
                          @foreach ($anggota as $anggota)
                            <div class="col-md-3">
                              <a href="{{route('anggota.dashboard', ['id_anggota' => $anggota -> id_anggota, 'id_project' => $projects -> id_project])}}">
                                <button type="button" class="btn  btn-proyek btn-block  btn-success btn-lg btn-flat" style="white-space: normal;">
                                  {{ $anggota -> username }}
                                </button>
                              </a>
                            </div>
                          @endforeach

                        </div>
                      </div>

                    </div>
                  </div>
                  <!-- /#ion-icons -->

                </div>
                <!-- /.tab-content -->
              </div>
              <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </section>

      </div>
      <!-- /.box -->

    </section>

    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!--modal-->
  <div class="modal fade" id="Edit-proyek">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="box box-primary">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Sunting Proyek</h4>
            </div>
            <form class="form-horizontal" method="POST" action="{{route('project.edit', ['id_project' => $projects -> id_project ])}}">
              {{ csrf_field() }}
              <div class="modal-body">
                <!-- form -->
                <!-- form start -->
                <div class="formeditproyek">
                  <div class="box-body">
                    <div class="form-group" id="form-group-nama_project">
                      <label>Nama Proyek</label>
                      <input id="nama_project" type="text" class="form-control" placeholder="Nama Proyek" name="nama_project" value="{{$projects -> nama_project}}" required>
                      <span class="help-block"></span>
                    </div>
                    <div class="form-group " id="form-group-nama_penanggungjawab">
                      <label>Nama Penanggungjawab</label>
                      @if ($enable == true)
                        <select id="penanggungjawab" class="form-control selectpjproyek" style="width: 100%;">
                          @foreach ($adminlist as $admins)
                            <option>{{$admins -> name}}</option>
                          @endforeach
                        </select>
                        {{-- <input id="nama_penanggungjawab" type="text" class="form-control" placeholder="Nama Penanggungjawab" name="nama_penanggungjawab" value="{{ $projects -> nama_penanggungjawab}}" required > --}}
                      @else
                        {{-- <input id="nama_penanggungjawab" type="text" class="form-control" placeholder="Nama Penanggungjawab" name="nama_penanggungjawab" value="{{ $projects -> nama_penanggungjawab}}" required  disabled>
                        <span class="help-block"></span> --}}
                        <select id="penanggungjawab" class="form-control selectpjproyek" style="width: 100%;" disabled>
                          @foreach ($adminlist as $admins)
                            <option>{{$admins -> name}}</option>
                          @endforeach
                        </select>
                      @endif

                    </div>
                    <div class="form-group">
                      <input type="hidden" name="_method" value="PUT">
                    </div>
                  </div>
                </div>

                <!-- /.box-body -->
                <!--  -->
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-flat btn-danger pull-left" data-dismiss="modal" data-toggle="modal" data-target="#verifikasi">Hapus Proyek</button>
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
                @if ($enable == true)
                    <p>Sekali melakukan penghapusan maka anda tidak dapat mengembalikan proyek yang sudah dihapus</p>
                @else
                  <p>Kirimkan permintaan hapus proyek pada penanggung jawab terkait?</p>
                @endif
                <!--  -->
              </div>
              <div class="modal-footer">
                <form action="{{route('project.delete')}}" method="POST">
                  {{csrf_field()}}
                  <input type="hidden" name="id_project" value="{{$projects -> id_project}}">
                  <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">Tidak</button>
                  <button type="submit" name="submit" class="btn btn-flat btn-default">Ya</button>
                  {{-- <input type="hidden" name="_method" value="DELETE"> --}}
                </form>
              </div>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>



        <div class="modal fade" id="viewlist">
          <div class="modal-dialog" style="margin-top:100px;">
            <div class="modal-content">
              <div class="box box-primary">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Tambah anggota yang sudah ada</h4>
                  </div>
                  <div class="modal-body" style="max-height: 300px;  overflow: auto;">
                    <!-- form -->
                    <!-- form start -->

                      {{csrf_field()}}
                      <div class="box-body">
                        <div class="listanggotaada">


                      <table class="table table-striped" id="checkbox">
                        <tr>
                          <th style="width: 10px">#</th>
                          <th>Username</th>
                          <th>Tanggal dibuat</th>
                          <th>Di buat oleh</th>
                          <th>Aksi</th>
                        </tr>
                        {{ csrf_field() }}
                        <?php $i = 1; ?>
                        @foreach ($anggotaexist as $exist)

                          <tr>
                            <td>{{$i}}.</td>
                            <td>{{ $exist -> username}}</td>
                            <td>{{$exist -> created_at}}</td>
                            <td>{{$exist -> dibuat_oleh}}</td>
                            <td ><input type="checkbox" value="{{$exist -> id_anggota}}"></td>
                          </tr>
                          <?php $i++; ?>
                        @endforeach
                      </table>
                      </div>
                      <div class="form-group" id="form-group-anggotatambah">
                        <span class="help-block"></span>
                      </div>
                      </div>
                      <!-- /.box-body -->

                    <!--  -->
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-flat" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary  btn-flat" id="tambahkananggota">Tambahkan</button>
                  </div>
                </div>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>

        <div class="modal fade" id="tambah-tugas">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="box box-primary">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Tambahkan Tugas</h4>
                  </div>
                  <form class="form-horizontal" method="POST" action="{{route('tugas.create', ['id_project' => $projects -> id_project ])}}">
                    {{ csrf_field() }}
                    <div class="modal-body" style="overflow-y: auto;">
                      <!-- form -->
                      <!-- form start -->

                      <div class="box-body">
                        <div class="form-group" id="form-group-nama_tugas">
                          <label>Nama Tugas</label>
                          <input id="nama_tugas" type="text" class="form-control" placeholder="Nama Tugas" name="nama_tugas" value=" {{ old('nama_tugas') }}" required>
                          <span class="help-block"></span>
                        </div>

                        <div class="form-group">
                        </div>
                      </div>
                      <!-- /.box-body -->

                      <!--  -->
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal">Batal</button>
                      <button type="button" id="submit_tugas" class="btn btn-primary  btn-flat">Simpan</button>
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
          $(document).ready(function() {

            $(".hapus").fadeTo(2000, 500).slideUp(500, function(){
              $(".hapus").slideUp(500);
            });

            $(document).on('click', '#buttonedit', function(e) {
              clearValidationError($('#nama_project').attr('id').replace('#', ''));
              var selected = $(this).find('#selectedpjproyek').val();
              $('#penanggungjawab > option').each(function(){
                if($(this).text()==selected) $(this).parent('select').val($(this).val())
              })
              console.log(selected);
            });

            $("#Edit-proyek").on('hidden.bs.modal', function() {
              $(".formeditproyek").load(location.href + ' .formeditproyek');
            });

            $("#viewlist").on('hidden.bs.modal', function() {
              $(".listanggotaada").load(location.href + ' .listanggotaada');
            });

            $("#submit_proyek").click(function(e) {
              e.preventDefault();
              var _token = $("input[name='_token']").val();
              var nama_project = $("input[name='nama_project']").val();
              var nama_penanggungjawab = $('#penanggungjawab').find(":selected").text();
              var text = '{{$projects -> nama_project}}';
              if (nama_project == '') {
                showValidationErrors('nama_project', 'Nama proyek harus diisi');
              } else {
                console.log(nama_penanggungjawab);
                $.ajax({
                  url : "{{route('project.edit', ['id_project' => $projects -> id_project ])}}",
                  type : 'PUT',
                  data : {_token : _token, nama_project : nama_project, nama_penanggungjawab : nama_penanggungjawab},
                  success : function(data) {
                    $("#Edit-proyek").modal('hide');
                    $("#nama_project").val(data.nama_project);
                    $(".pr").load(location.href + ' .pr');
                    $("#descalert").text('Perubahan data proyek berhasil disimpan')
                    $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                      $(".alert").slideUp(500);
                    });
                    $(".judul").load(location.href + ' .judul');
                    $(".oy").load(location.href + ' .oy');
                    $('li > a:contains("'+text+'")').html('<i class="fa fa-circle-o"></i>'+data.nama_project);

                  },
                  error : function(response){
                    console.log(response);
                    var obj = response.responseJSON
                    for (let i in obj) {
                      showValidationErrors(i, obj[i][0]);
                    }
                    if (response.status == 500) {
                      showValidationErrors('nama_project', 'Nama proyek sudah ada')
                    }
                  }
                });
              }
            });


            $("#tambahkananggota").click(function(e) {
              e.preventDefault();
              var _token = $("input[name='_token']").val();
              var anggotadipilih = [];
              $('#checkbox :checked').each(function() {
                anggotadipilih.push($(this).val());
              });
                $('input[type=checkbox]').change(
                  function(){
                    if (this.checked) {
                        clearValidationError('anggotatambah');
                    }
                  });
              console.log(anggotadipilih);
              if (anggotadipilih.length == 0) {
                showValidationErrors('anggotatambah', 'tidak ada anggota yang di checklist');
              } else {
                $.ajax({
                  url : "{{route('anggota.tambah', ['id_project' => $projects -> id_project ])}}",
                  type : 'POST',
                  data : {_token : _token, anggotadipilih : anggotadipilih},
                  success : function(data){
                    console.log(data);
                    $("#viewlist").modal('hide');
                    $("#descalert").text('Anggota berhasil ditambahkan')
                    $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                      $(".alert").slideUp(500);
                    });
                    $(".anggota").load(location.href + ' .anggota');
                    $(".listanggotaada").load(location.href + ' .listanggotaada');
                  },
                  error : function(response){
                    console.log(response);
                    if (response.status == 500) {
                      showValidationErrors('anggotatambah', 'tidak ada anggota yang di checklist');
                    }
                  }
                });
              }
            });

            $("#submit_tugas").click(function(e) {
              e.preventDefault();
              var _token = $("input[name='_token']").val();
              var nama_tugas = $("input[name='nama_tugas']").val();
              if (nama_tugas == '') {
                showValidationErrors('nama_tugas', 'Nama tugas harus diisi');
              } else {
                $.ajax({
                  url : "{{route('tugas.create', ['id_project' => $projects -> id_project ])}}",
                  type : 'POST',
                  data : {_token : _token, nama_tugas : nama_tugas},
                  success : function(data) {

                    console.log(data);
                    $("#tambah-tugas").modal('hide');
                    $("#descalert").text('Tugas berhasil ditambahkan');
                    $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                      $(".alert").slideUp(500);
                    });
                    $(".tugas").load(location.href + ' .tugas');
                  },
                  error : function(response){
                    console.log(response);
                    var obj = response.responseJSON
                    for (let i in obj) {
                      showValidationErrors(i, obj[i][0]);
                    }
                  }
                });
              }
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

            $("#nama_project, #username, #password, #nama_tugas").on('keyup', function () {
              clearValidationError($(this).attr('id').replace('#', ''))
            });

            $(document).on('click', '#tambah_anggota', function(event) {
              clearValidationError('anggotatambah');
            });

            $(document).on('click', '#tambah_tugas', function(event) {
              $('#nama_tugas').val("");
              clearValidationError($('#nama_tugas').attr('id').replace('#', ''))
            });

          });
          </script>

        @endsection
