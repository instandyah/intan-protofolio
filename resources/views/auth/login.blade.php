
@extends('Layouts.header-anggota')

@section('title', 'Login Anggota')
<!-- =============================================== -->
@section('content')
<body class="hold-transition" style="background-image: url({{URL::asset('dist/img/bg2.jpg')}}); height:100%">
  <div class="content-wrapper" style="background-color:transparent">
      <div class="container" >
        <!-- Content Header (Page header) -->


        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-lg-offset-2 col-md-offset-2 col-sm-6 col-sm-offset-2 col-lg-6 col-md-6" style="margin-top:13%">
              <div class="row" style=" padding:0px">

                  <div class="box box-info" >

                <div class="box-header" style="color:white; background-color:#00c0ef; margin-top:0px">
                  <br>
                <h3 class="box-title"><i class="fa fa-sign-in"></i> Login Anggota<br></h3>

                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form" method="POST" action="{{ route('login') }}">
                  {{ csrf_field() }}
                  <div class="box-body">
                    <br>
                    <div class="input-group{{ $errors->has('username') ? ' has-error' : '' }}">
                      <span class="input-group-addon">@</span>
                        <input type="text" class="form-control" id="username" placeholder="Username" name="username" value="{{ old('username') }}" required autofocus>
                    </div>
                    @if ($errors->has('username'))
                        <span class="help-block" style="color:#a94442">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif
                    <br>
                    <div class="input-group{{ $errors->has('password') ? ' has-error' : '' }}">
                      <span class="input-group-addon">
                        <i class="fa fa-lock"></i>
                      </span>
                        <input type="password" class="form-control" id="password" placeholder="Password" name="password" required>

                      </div>
                      @if ($errors->has('password'))
                          <span class="help-block">
                              <strong>{{ $errors->first('password') }}</strong>
                          </span>
                      @endif
                      <br>
                      <button type="submit" class="btn btn-flat" style="width:100%; background-color:#00c0ef; color:white">Sign in</button>

                    </div>
                    <br>
                    <div style="width: 100%; background-color:#BFCACD;">
                      <center>
                        <a class="btn" style=" color:#666D6F" href="{{ route('password.request') }}">
                            Forgot Your Password?
                        </a>
                      </center>

                    </div>

                  <!-- /.box-body -->

                </form>
              </div>

              </div>

            </div>


            <!-- /.col -->
          </div>
        </section>
      </div>
      <!-- /.content -->
    </div>

@endsection
@section('script2')
  <script>
  $(document).ready(function(){
    function clearValidationError(name) {
      var group = $(".input-group");
      group.removeClass('has-error');
      $('.box-body').find('.help-block').text('');
    }

    $("#username, #password").on('keyup', function () {
      clearValidationError($(this).attr('id').replace('#', ''))
    });
  });

  </script>

@endsection
