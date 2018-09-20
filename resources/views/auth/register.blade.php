@extends('Layouts.header-anggota')


@section('title', 'Login 2')
<!-- =============================================== -->

@section('content')
<body class="hold-transition" style="background-image: url({{URL::asset('dist/img/bg-admin.jpg')}});">
  <div class="wrapper" style="height: 100%; margin-bottom: -30px;">
<div class="content-wrapper"  style="background-color:transparent; margin:0px; ">


  <div class="register-box" style="margin-top:60px; ">


    <div class="register-box-body" style="background-color:rgba(255,255,255, 0.6);">
      <center>
        <img src="{{URL::asset('dist/img/useradmin.png')}}" class="user-image" />
      </center>
      <div class="register-logo"  style="color:white">
        <b>Admin</b>PROJECT
      </div>

      <form method="POST" action="{{ route('register') }}">
        {{ csrf_field() }}

        <div class="form-group has-feedback {{ $errors->has('name') ? ' has-error' : '' }}">
          <input id="name" type="text" class="form-control" placeholder="Nama Lengkap" name="name" value="{{ old('name') }}" required autofocus>
          <span class="glyphicon glyphicon-user form-control-feedback"></span>

          @if ($errors->has('name'))
            <span class="help-block">
              <strong>{{ $errors->first('name') }}</strong>
            </span>
          @endif
        </div>
        <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
          <input id="email" type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" required>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

          @if ($errors->has('email'))
              <span class="help-block">
                  <strong>{{ $errors->first('email') }}</strong>
              </span>
          @endif
        </div>
        <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
          <input id="password" type="password" class="form-control" placeholder="Password" name="password" required>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>

          @if ($errors->has('password'))
              <span class="help-block">
                  <strong>{{ $errors->first('password') }}</strong>
              </span>
          @endif
        </div>
        <div class="form-group has-feedback">
          <input id="password-confirm" type="password" class="form-control" placeholder="Konfirmasi password" name="password_confirmation" required>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Registrasi</button>
          </div>
          <!-- /.col -->
        </div>
      </form> <br>
      <center>
        <a href="{{ route('admin.login') }}" class="text-center">Sudah punya akun?</a>
      </center>

    </div>
    <!-- /.form-box -->
  </div>
  </div>
  <!-- /.register-box -->
@endsection
@section('script2')
  <script>
  $(document).ready(function(){
    function clearValidationError(name) {
      var group = $(".form-group");
      group.removeClass('has-error');
      group.find('.help-block').text('');
    }

    $("#name, #email, #password").on('keyup', function () {
      clearValidationError($(this).attr('id').replace('#', ''))
    });
  });

  </script>

@endsection
