
@extends('Layouts.header-admin')

@section('title', 'Edit Profil')
<!-- =============================================== -->
@section('content')

  <div class="content-wrapper isi">
      <!-- Content Header (Page header) -->
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
          Perubahan data profil berhasil disimpan.
        </div>

        <div class="box box-primary">
          <div class="box-body">

              <form class="form-horizontal">
                {{ csrf_field() }}
                <div class="dataadmin">
                    <div class="form-group has-feedback" id="form-group-name">
                      <label for="inputName" class="col-lg-3 col-md-3  control-label">Nama</label>

                      <div class=" col-lg-6 col-md-6 ">
                        <input type="email" class="form-control" id="name" placeholder="Nama" name="name" value="{{$admin -> name}}" required>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        <span class="help-block"></span>
                      </div>
                    </div>
                    <div class="form-group has-feedback" id="form-group-email">
                      <label for="inputEmail" class="col-lg-3 col-md-3  control-label">Email</label>

                      <div class="col-lg-6 col-md-6 ">
                        <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="{{$admin -> email}}" required>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
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

      <!-- /.content -->
    </div>
@endsection
@section('script')
  <script>
    $(document).ready(function () {
      $("#batal").click(function(e) {
        $(".dataadmin").load(location.href + ' .dataadmin');
      });
      $("#submitedit").click(function(e) {
        e.preventDefault();
        var _token = $("input[name='_token']").val();
        var name = $("input[name='name']").val();
        var email = $("input[name='email']").val();
        var password = $("input[name='password']").val();
        if (name == '' && email == '' && password == '') {
          obj = {
            "name" : ["Nama harus diisi"],
            "email" : ["Email harus diisi"],
            "password" : ["Password minimal harus 6 karakter"]
          }
          for (let i in obj) {
               showValidationErrors(i, obj[i][0]);
             }
        } else if (name == '') {
          showValidationErrors('name', 'Nama harus diisi');
        } else if (email == '') {
          showValidationErrors('email', 'Email harus diisi');
        } else if (password == '' || password.length < 6) {
          showValidationErrors('password', 'Password minimal harus 6 karakter');
        } else {
          $.ajax({
            url : "{{route('admin.edit', ['id_admin' => $admin -> id_admin ])}}",
            type : 'PUT',
            data : {_token : _token, name : name, email : email, password : password},
            success : function(data) {
              console.log(data);
              $("#descalert").text('Perubahan data profil admin berhasil disimpan.');
              $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                $(".alert").slideUp(500);
              });

              $(".dataadmin").load(location.href + ' .dataadmin');
            },
            error : function(response){
              console.log(response);
              var obj = response.responseJSON
              for (let i in obj) {
                showValidationErrors(i, obj[i][0]);
              }
              if (response.status == 500) {
                showValidationErrors('email', 'Email sudah dipakai')
              }
            }
          });
        }
      });

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
        $("#name, #email, #password").on('keyup', function () {
          clearValidationError($(this).attr('id').replace('#', ''))
        });

    })

  </script>

@endsection
