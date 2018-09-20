@extends('Layouts.header-anggota')


@section('title', 'Login Admin')
<!-- =============================================== -->

@section('content')
  <body class="hold-transition" style="background-image: url({{URL::asset('dist/img/bg-admin.jpg')}}); height:100%">

  <div class="login-box">

    <!-- /.login-logo -->
    <div class="login-box-body" style="background-color:rgba(255,255,255, 0.6);">

      <center>
      <img src="{{URL::asset('dist/img/useradmin.png')}}" class="user-image" />
      </center>

      <div class="login-logo" style="color:white">
        <b>Admin</b>PROJECT
      </div>

      <form method="POST" action="{{ route('admin.login.submit') }}">
        {{ csrf_field() }}
        <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
          <input id="email" type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" required autofocus>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

        </div>
        <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
          <input id="password" type="password" class="form-control" placeholder="Password" name="password" required>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          {{-- @if ($errors->has('password'))
              <span class="help-block text-center">
                  <strong>{{ $errors->first('password') }}</strong>
              </span>
          @endif --}}
        </div>
        <div id="errorrow" class="row">
          @if (($errors->has('email')) && ($errors->has('password')))
              <span class="help-block text-center">
                  <strong style="color : #dd4b39">{{ $errors->first('email') }} dan {{ $errors->first('password') }} </strong>
              </span>
          @elseif (($errors->has('email')) || ($errors->has('password')))
            <span class="help-block text-center">
                <strong style="color : #dd4b39">{{ $errors->first('email') }} {{ $errors->first('password') }} </strong>
            </span>
          @endif
          <div class="col-xs-12">
            <button type="submit" class="btn btn-primary btn-block btn-flat" style="border-color:#3c8dbc;" onMouseOver="this.style.border-color='#286090'">Masuk</button>
          </div>
          <!-- /.col -->
        </div>
        <br>
        <center>
          {{-- <a href="" onMouseOver="this.style.color='white'" onMouseOut="this.style.color='#3c8dbc'" >Lupa password</a>  --}}
           <a href="{{ route('register') }}" class="text-center"  onMouseOver="this.style.color='white'" onMouseOut="this.style.color='#3c8dbc'" >Belum punya akun?</a>
        </center>
      </form>



    </div>
    <!-- /.login-box-body -->
  </div>
<!-- /.register-box -->
@endsection
@section('script2')
  <script>
  $(document).ready(function(){
    function clearValidationError(name) {
      var group = $(".form-group");
      group.removeClass('has-error');
      $('#errorrow').find('.help-block').text('');
    }

    $("#email, #password").on('keyup', function () {
      clearValidationError($(this).attr('id').replace('#', ''))
    });
  });

  </script>

@endsection
