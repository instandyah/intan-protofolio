
@extends('Layouts.header-admin')

@section('title', 'Dashboard akun anggota')
<!-- =============================================== -->
@section('content')

  <div class="content-wrapper isi">

      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="row"  style="padding-bottom:0px;">
          <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8" style="padding-bottom:0px;">
            <h2 class="judul">
              Dashboard
              <small>anggota</small>

            </h2>
          </div>
        </div>
      </section>

      <!-- Main content -->
      <section class="content" style="padding-top:0px;" >

          <div class="alert alert-success" style="display: none;">
            <h4><i class="icon fa fa-check"></i> Sukses!</h4>
            <p id="descalert">  Proyek Berhasil ditambahkan.</p>
          </div>
          <div class="box box-default" style="background-color:rgba(255,255,255, 0.6);">
              <div class="box-body">
            <div class="proyekbox">
              <br>
              <div class="row">
                <div class="anggota">
                  <div class="col-md-3">
                    <button id="tambah_anggota" type="button" class="btn  btn-proyek btn-block btn-modal btn-lg btn-flat"  data-toggle="modal" data-target="#tambah-anggota">
                      <i class="fa fa-plus"></i><br>
                      Tambah anggota
                    </button>
                  </div>
                  @foreach ($anggota as $anggota)
                    <div class="col-md-3">
                      <a href="{{route('anggotaaccount.select', ['id_anggota' => $anggota -> id_anggota])}}">
                        <button type="button" class="btn  btn-proyek btn-block  btn-success btn-lg btn-flat" >
                          {{ $anggota -> username }}
                        </button>
                      </a>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
            <!-- /.box -->
          </div>
          <!-- /.col -->

      </section>

    <!-- /.content -->
  </div>
  <div class="modal fade" id="tambah-anggota">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="box box-primary">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Tambahkan Anggota</h4>
            </div>
            {{-- <form class="form-horizontal"  method="POST" action="{{route('anggota.create', ['id_project' => $projects -> id_project ])}}"> --}}
              <div class="modal-body">
                <!-- form -->
                <!-- form start -->
                {{ csrf_field() }}
                <div class="box-body">
                  <div class="form-group" id="form-group-username">
                    <label>Username</label>
                    <input id="username" type="text" class="form-control" placeholder="Username anggota" name="username" value="{{ old('username') }}" required>
                    <span class="help-block"></span>
                  </div>
                  <div class="form-group" id="form-group-password">
                    <label>Password</label>
                    <input id="password" name="password" type="password" class="form-control" placeholder="Password Anggota" required>
                    <span class="help-block"></span>
                  </div>
                  <div class="form-group">
                  </div>
                </div>
                <!-- /.box-body -->

                <!--  -->
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-flat btn-danger pull-left" data-dismiss="modal">Batal</button>
                <button type="button" id="submit_anggota" class="btn btn-flat btn-primary">Simpan</button>
              </div>
            {{-- </form> --}}
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
        $("#submit_anggota").click(function(e) {
          e.preventDefault();
          var _token = $("input[name='_token']").val();
          var username = $("input[name='username']").val();
          var password = $("input[name = 'password']").val();
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
              url : "{{route('anggota.create')}}",
              type : 'POST',
              data : {_token : _token, username : username, password : password},
              success : function(data) {
                console.log(data);
                $("#tambah-anggota").modal('hide');
                $("#descalert").text('Anggota berhasil ditambahkan')
                $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                  $(".alert").slideUp(500);
                });
                $(".anggota").load(location.href + ' .anggota');
              },
              error : function(response){
                console.log(response.responseJSON);
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

        $("#username, #password").on('keyup', function () {
          clearValidationError($(this).attr('id').replace('#', ''))
        });

        $(document).on('click', '#tambah_anggota', function(event) {
          $('#username').val("");
          $('#password').val("");
          clearValidationError($('#password').attr('id').replace('#', ''))
          clearValidationError($('#username').attr('id').replace('#', ''))
        });
      });
    </script>
  @endsection
