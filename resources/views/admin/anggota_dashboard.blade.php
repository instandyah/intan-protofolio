
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
        <p id="descalert">Perubahan berhasil disimpan.</p>
      </div>
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
            <div class="col-lg-12">
              <p style="font-size:13px; color:#777" class="pull-left">{{$anggota -> dibuat_oleh}}, {{$anggota -> created_at}}</p><br>
            </div>

          </div>

          @if ($penanggungjwb == 'ya')
            <div class="row">
              <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 ">
                <button id="modaleditanggota" type="button" class="btn btn-primary btn-flat" data-toggle="modal" data-target="#Edit-anggota"> <i class="fa fa-edit"></i> Edit Anggota</button>
              </div>
            </div>
          @endif
          <br><br>
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">Daftar Proyek</h3>
                </div>
                <div class="listproject">
                  <table class="table table-striped">
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Username</th>
                      <th>Nama Proyek</th>
                      <th>Nama Penanggungjawab</th>
                      <th>Tanggal Bergabung</th>
                      <th>Dibawa oleh</th>
                      <th>Aksi</th>
                    </tr>
                    {{ csrf_field() }}
                    <?php $i = 1; ?>
                    @foreach ($listproyek as $proyek)
                      <tr>
                        <td>{{$i}}.</td>
                        <td>{{ $proyek -> username}}</td>
                        <td>
                          {{ $proyek -> nama_project}}
                        </td>
                        <td>{{$proyek -> nama_penanggungjawab}}</td>
                        <td>{{$proyek -> created_at}}</td>
                        <td>{{$proyek -> dibawa_oleh}}</td>
                        <td >
                          
                        @if ($proyek -> pjproyek == 'ya')
                          <button type="button" id="{{ $proyek -> id_project}}" class="btn btn-danger btn-flat deletefromproject" data-toggle="modal" data-target="#verifikasi"><i class="fa fa-trash-o"></i>
                          <input type="hidden" id="nama_project" value="{{$proyek -> nama_project}}">
                        </button>
                      @endif
                      </td>
                      </tr>
                      <?php $i++; ?>
                    @endforeach
                  </table>
                </div>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!-- /.box -->

      </section>

      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!--modal-->


      <div class="modal fade" id="Edit-anggota">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="box box-primary">
              <form class="form-horizontal">
                {{csrf_field()}}
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Sunting Anggota {{$anggota -> username}}</h4>
                  </div>
                  <div class="modal-body">
                    <!-- form -->
                    <!-- form start -->
                    <div class="formeditanggota">
                      <div class="box-body">
                        <div class="form-group" id="form-group-username">
                          <label>Username</label>
                          <input id="username" name="username" type="text" class="form-control" placeholder="Username" value="{{ $anggota -> username }}">
                          <span class="help-block"></span>
                        </div>
                        <div class="form-group" id="form-group-password">
                          <label>Password</label>
                          <input id="password" name="password" type="password" class="form-control" placeholder="Password" value="">
                          <span class="help-block"></span>
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
                    <button id="deleteanggota" type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal" data-toggle="modal" data-target="#verifikasi">Hapus Anggota</button>
                    <button type="button" class="btn btn-danger btn-flat " data-dismiss="modal">Batal</button>
                    <button id="submit_anggota" type="button" class="btn btn-primary btn-flat ">Simpan Perubahan</button>
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
                  <form class="" action="{{route('anggota.delete', ['id_anggota' => $anggota -> id_anggota ])}}" method="post">
                    {{csrf_field()}}
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default btn-flat " data-dismiss="modal">Tidak</button>
                      <button id="submitdeleteanggota" type="submit" class="btn btn-default btn-flat ">Ya</button>
                      <button id="submitdeletefromproyek" type="button" class="btn btn-default btn-flat ">Hapus</button>
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

            $("#submit_anggota").click(function(e) {
              e.preventDefault();
              var _token = $("input[name='_token']").val();
              var username = $("input[name='username']").val();
              var password = $("input[name='password']").val();
              var text = '{{$anggota -> username}}';
              if ((username == '' && password == '') || (username.length < 6 && password.length < 6)) {
                obj = {
                  "username" : ["Username minimal harus 6 karakter"],
                  "password" : ["Password minimal harus 6 karakter"]
                }
                for (let i in obj) {
                     showValidationErrors(i, obj[i][0]);
                   }
              } else if (username == '' || username.length < 6){
                showValidationErrors('username', 'Username minimal harus 6 karakter');
              } else if (password == '' || password.length < 6) {
                showValidationErrors('password', 'Password minimal harus 6 karakter');
              } else {
                $.ajax({
                  url : "{{route('anggota.edit', ['id_anggota' => $anggota -> id_anggota ])}}",
                  type : 'PUT',
                  data : {_token : _token, username : username, password : password},
                  success : function(data) {
                    console.log(data);
                    $("#descalert").text('Perubahan data anggota berhasil disimpan')
                    $(".alert").fadeTo(2000, 500).slideUp(500, function(){

                      $(".alert").slideUp(500);
                    });
                    $("#Edit-anggota").modal('hide');
                    $("#password").val('');
                    $(".judul").load(location.href + ' .judul');
                    $(".listproject").load(location.href + ' .listproject');
                    $('li > a:contains("'+text+'")').html('<i class="fa fa-circle-o"></i>'+data.username);
                  },
                  error : function(response){
                    console.log(response);
                    var obj = response.responseJSON
                    for (let i in obj) {
                      showValidationErrors(i, obj[i][0]);
                    }
                    if (response.status == 500) {
                      showValidationErrors('username', 'Username sudah dipakai')
                    }
                    // associate_errors(erros, $form);
                  }
                });
              }
            });

            //MODAL ON hidden
            $("#Edit-anggota").on('hidden.bs.modal', function() {
              $(".formeditanggota").load(location.href + ' .formeditanggota');
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

            $("#username, #password").on('keyup', function () {
              clearValidationError($(this).attr('id').replace('#', ''))
            });


            $(document).on('click', '#deleteanggota', function()
            {
              $("#desc").text('Sekali melakukan penghapusan maka anda tidak dapat mengembalikan anggota yang sudah dihapus')
              $("#submitdeleteanggota").show();
              $("#submitdeletefromproyek").hide();
            });

            $(document).on('click', '.deletefromproject', function()
            {
                var nama_project = $(this).find('#nama_project').val();

              $("#desc").text('Apakah anda yakin melakukan penghapusan {{$anggota -> username}} dari '+nama_project +'?')
              $("#submitdeleteanggota").hide();
              $("#submitdeletefromproyek").show();
            });

            $(document).on('click', '#submitdeletefromproyek', function(event) {
              var _token = $("input[name='_token']").val();
              var id_anggota = "{{ $anggota -> id_anggota}}"
              var id_project = $('.deletefromproject').attr('id');
              console.log(id_project);
              console.log(id_anggota);
              $.ajax({
                url : "{{route('project.anggota.delete')}}",
                type : 'POST',
                data : {_token : _token, id_project : id_project, id_anggota : id_anggota},
                success : function(data) {

                  $("#descalert").text('Anggota berhasil dihapus dari proyek.')
                  $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                    $(".alert").slideUp(500);
                  });
                  $("#verifikasi").modal('hide');

                  $(".listproject").load(location.href + ' .listproject');
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


          })
          </script>

        @endsection
