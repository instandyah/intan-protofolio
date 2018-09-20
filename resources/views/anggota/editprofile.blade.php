
@extends('Layouts.header-anggota')

@section('title', 'Edit Profile')
<!-- =============================================== -->
@section('script1')

@endsection

@section('content')

  <div class="content-wrapper isi">
    <div class="row">
      <div class="col-lg-8 col-md-8 col-md-offset-2 col-lg-offset-2">
        <section class="content-header">
          <div class="row"  style="padding-bottom:0px;">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8" style="padding-bottom:0px;">
              <h2>
                Sunting Profil
              </h2>
            </div>
          </div>
        </section>

        <!-- Main content -->
        <section class="content" style="padding-top : 0px">
          <div class="alert alert-success" style="display: none;">
            <h4><i class="icon fa fa-check"></i> Sukses!</h4>
            Perubahan data berhasil disimpan.
          </div>

          <div class="box box-primary">
            <div class="box-body">

                <form class="form-horizontal">
                  {{ csrf_field() }}
                  <br>
                  <div class="dataanggota">
                      <div class="form-group has-feedback" id="form-group-username">
                        <label for="inputName" class="col-lg-3 col-md-3  control-label">Username</label>

                        <div class=" col-lg-6 col-md-6 ">
                          <input type="text" class="form-control" id="username" placeholder="username" name="username" value="{{$anggota -> username}}">
                          <span class="glyphicon glyphicon-user form-control-feedback"></span>
                          <span class="help-block"></span>
                        </div>
                      </div>
                      <div class="form-group has-feedback" id="form-group-password">
                        <label for="inputnewpass" class="col-lg-3 col-md-3 control-label">Password Baru</label>
                        <div class="col-lg-6 col-md-6">
                          <input type="password" class="form-control" id="password" placeholder="Password Baru" name="password">
                          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                          <span class="help-block"></span>
                        </div>
                      </div>
                      </div>
                      <div class="form-group">
                        <div class="col-lg-offset-3 col-lg-12 col-md-12 col-sm-12">
                          <button id="submitedit" type="button" class="btn btn-primary btn-flat">Submit</button>
                          <button id="batal" type="button" class="btn btn-danger btn-flat">batal</button>
                        </div>
                      </div>

                    </form>


            </div>

          </div>
          <!-- /.box -->

        </section>
      </div>

    </div>
      <!-- Content Header (Page header) -->


      <!-- /.content -->
    </div>

@endsection

@section('script2')
  <script>
    $(document).ready(function () {
      $("#batal").click(function(e) {
        $(".dataanggota").load(location.href + ' .dataanggota');
      });
      $("#submitedit").click(function(e) {
        e.preventDefault();
        var _token = $("input[name='_token']").val();
        var username = $("input[name='username']").val();
        var password = $("input[name='password']").val();

        $.ajax({
          url : "{{route('anggota.edit.profil', ['id_anggota' => $anggota -> id_anggota ])}}",
          type : 'PUT',
          data : {_token : _token, username : username, password : password},
          success : function(data) {
            console.log(data);
            $("#descalert").text('Perubahan data tugas berhasil disimpan.');
            $(".alert").fadeTo(2000, 500).slideUp(500, function(){
              $(".alert").slideUp(500);
            });

            $(".dataanggota").load(location.href + ' .dataanggota');
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

      function showValidationErrors(name, error) {
          var group = $("#form-group-" + name);
          group.addClass('has-error');
          group.find('.help-block').text(error);
        }

        function clearValidationError(name) {
            var group = $("#form-group-" + name);
            group.removeClass('has-error');
            group.find('.help-block').text('');
        }
        $("#username, #password").on('keyup', function () {
          clearValidationError($(this).attr('id').replace('#', ''))
        });

    })

  </script>
@endsection
