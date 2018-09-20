<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="login-status" content="{{ Auth::check() }}">
  <meta name="userId" content="{{ Auth::check() ? Auth::id() : '' }}">

  <title>@yield('title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{URL::asset('bower_components/bootstrap/dist/css/bootstrap.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{URL::asset('bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{URL::asset('bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{URL::asset('plugins/bootstrap-slider/slider.css')}}">

  <link rel="stylesheet" href="{{URL::asset('dist/css/AdminLTE.css')}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
  folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{URL::asset('dist/css/skins/_all-skins.min.css')}}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="shortcut icon" href="{{{ asset('dist/img/helfalogo.png') }}}">
    @yield('script1')
    <style>
    .slider {
  -webkit-appearance: none;
  width: 100%;
  height: 15px;
  border-radius: 5px;
  background: #d3d3d3;
  outline: none;
  opacity: 0.7;
  -webkit-transition: .2s;
  transition: opacity .2s;
}

.slider:hover {
  opacity: 1;
}

.slider::-webkit-slider-thumb {
  -webkit-appearance: none;
  appearance: none;
  width: 25px;
  height: 25px;
  border-radius: 50%;
  background: #3c8dbc;
  cursor: pointer;
}

.slider::-moz-range-thumb {
  width: 25px;
  height: 25px;
  border-radius: 50%;
  background: #3c8dbc;
  cursor: pointer;
}
</style>

</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
    @if (Auth::guest())
{{-- <body class="hold-transition" style="background-image: url({{URL::asset('dist/img/bg2.jpg')}}); height:100%"> --}}
@else
  <body class="hold-transition skin-blue layout-top-nav">
  @endif
  <div class="wrapper">

    @if (Auth::guest())
    @else
      <header class="main-header">
        <nav class="navbar navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              @if (Auth::guard('admin')->check())
              <a href="{{route('admin.menu')}}" class="navbar-brand"><b>Admin</b>PROJECT</a>
              @else
                <a href="{{route('admin.menu')}}" class="navbar-brand" ><i class="fa fa-home"></i> PROJECT</a>
              @endif
            </div>

            <!-- /.navbar-collapse -->
            <!-- Navbar Right Menu -->
            <div id="app" class="navbar-custom-menu">
              <ul class="nav navbar-nav">
                <!-- Notifications Menu -->
                <notification1  v-bind:notifications="notifications"></notification1>

                <!-- Tasks Menu -->

                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                  <!-- Menu Toggle Button -->
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <!-- The user image in the navbar-->
                    <img src="{{URL::asset('dist/img/useradmin.png')}}" class="user-image" alt="User Image">
                    <!-- hidden-xs hides the username on small devices so only the image appears. -->
                    @if (Auth::guard('admin')->check())
                    <span class="hidden-xs">{{ Auth::user()->name }}</span>
                  @else
                      <span class="hidden-xs">{{ Auth::user()->username }}</span>
                  @endif
                  </a>
                  <ul class="dropdown-menu" style="width: 100px;">
                      <table class="table table-striped no-border table-hover no-margin">
                        <tbody>
                        <tr>
                          <td>
                            @if (Auth::guard('admin')->check())
                            <a href="{{route('admin.formedit', ['id_admin' => Auth::id()])}}" class="btn btn-primary btn-block"  style="background-color : transparent; color:black;">Profile</a>
                            @else
                              <a href="{{route('anggota.edit.form', ['id_anggota' => Auth::id()])}}" class="btn btn-primary btn-block" style="background-color : transparent; color:black;"> Edit profile</a>
                            @endif
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();" class="btn btn-danger btn-block"  style="background-color : transparent; color:black;">Sign out</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                              {{ csrf_field() }}
                            </form>
                          </td>
                        </tr>

                      </tbody>
                      </table>
                  <!-- Menu Footer-->
                  </ul>
                </li>
              </ul>
            </div>
            <!-- /.navbar-custom-menu -->
          </div>
          <!-- /.container-fluid -->
        </nav>
      </header>
    @endif

@yield ('content')

@if (Auth::guest())

@else

    <footer class="main-footer">
  <div class="container">
    <strong>Copyright &copy; 2018 <a href="">MyProjectManagement</a>.</strong>
  </div>
  <!-- /.container -->
</footer>
@endif
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script type="text/javascript">
window.Laravel = { csrfToken: '{{ csrf_token() }}' };
</script>


<script src="{{URL::asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
{{-- <script src="{{URL::asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script> --}}
<script src="{{URL::asset('bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- SlimScroll -->
<script src="{{URL::asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{URL::asset('bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{URL::asset('dist/js/adminlte.min.js')}}"></script>

<script src="{{URL::asset('plugins/bootstrap-slider/bootstrap-slider.js')}}"></script>
<!-- AdminLTE for demo purposes -->
{{-- <script src="{{URL::asset('dist/js/demo.js')}}"></script> --}}
<script src="{{URL::asset('bower_components/moment/moment.js')}}"></script>
<script src="{{ URL::asset('js/app.js') }}"></script>

  @yield('script2')
</body>
</html>
