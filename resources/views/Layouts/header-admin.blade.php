<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="userId" content="{{ Auth::check() ? Auth::id() : '' }}">
  <meta name="login-status" content="{{ Auth::check() }}">
  <title>@yield ('title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- Bootstrap 3.3.7 -->

  <link rel="stylesheet" href="{{URL::asset('bower_components/bootstrap/dist/css/bootstrap.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{URL::asset('bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{URL::asset('bower_components/Ionicons/css/ionicons.min.css')}}">
  {{-- date picker --}}
  <link rel="stylesheet" href="{{URL::asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{URL::asset('dist/css/AdminLTE.css')}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
  folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{URL::asset('dist/css/skins/_all-skins.min.css')}}">
  <link rel="stylesheet" href="{{URL::asset('bower_components/select2/dist/css/select2.css')}}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
  href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="shortcut icon" href="{{{ asset('dist/img/helfalogo.png') }}}">
  <script>

  </script>
  <style>
  .mousechange:hover {
    cursor: pointer;
  }
  </style>
</head>
<!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
<!-- the fixed layout is not compatible with sidebar-mini -->

<body class="hold-transition skin-blue fixed sidebar-mini" style="padding-right:0px;">
  <!-- Site wrapper -->
  <div class="wrapper">

    <header class="main-header">
      <!-- Logo -->
      <a href="{{route('admin.menu')}}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><img src="{{URL::asset('dist/img/helfalogo.png')}}" style="width:30px;" /></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><img src="{{URL::asset('dist/img/helfa_white.png')}}" style="width:80px;" /></span>
      </a>
      <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>
      </nav>
      <!-- Header Navbar: style can be found in header.less -->
      <!-- <nav class="navbar navbar-static-top"></nav> -->
    </header>

    <!-- =============================================== -->

    <!-- Left side column. contains the sidebar -->
    <aside id="app" class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->

        <section id="notif" class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="{{URL::asset('dist/img/useradmin.png')}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p>{{ Auth::user()->name }}</p>
              <a href="{{route('admin.formedit', ['id_admin' => Auth::id()])}}" class="text-gray"><i class="fa fa-edit text-gray"></i> Edit Profile</a>
            </div>
          </div>
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu" data-widget="tree">
            <li>
              <a href="{{route('admin.projectlist')}}">
                <i class="fa fa-dashboard"></i> <span>Menu Proyek</span>
              </a>
            </li>
            <li>
              <a href="{{route('admin.anggotalist')}}">
                <i class="fa fa-dashboard"></i> <span>Menu Anggota</span>
              </a>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-tasks"></i> <span>Daftar Project</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>

                <ul id="menusidee" data-role="listview" data-inset="true" class="treeview-menu aku">
                  {{-- <div class="menusidee" style="padding-left : 10px;"> --}}
                    @foreach ($projects as $listproject)
                      <li><a href="{{route('project.select', ['id_project' => $listproject -> id_project ])}}"><i class="fa fa-circle-o"></i> {{$listproject -> nama_project}}</a></li>
                    @endforeach
                  {{-- </div> --}}
                </ul>


            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-group "></i> <span>Daftar Anggota</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>

                <ul id="menusidee" data-role="listview" data-inset="true" class="treeview-menu aku">
                  {{-- <div class="menusidee" style="padding-left : 10px;"> --}}
                    @foreach ($anggotas as $listanggota)
                      <li><a href="{{route('anggotaaccount.select', ['id_anggota' => $listanggota -> id_anggota])}}"><i class="fa fa-circle-o"></i> {{$listanggota -> username}}</a></li>
                    @endforeach
                  {{-- </div> --}}
                </ul>


            </li>
            <notification v-bind:notifications="notifications"></notification>
            <li>
              <a href="{{ route('logout') }}"
              onclick="event.preventDefault();
              document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> <span>Keluar</span></a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
              </form>
            </li>
          </ul>
        </section>


      <!-- /.sidebar -->
    </aside>

    @yield ('content')

    <footer class="main-footer">
  <div class="container">
    <strong>Copyright &copy; 2018 <a href="">MyProjectManagement</a>.</strong>
  </div>
  <!-- /.container -->
</footer>

    <!-- ./wrapper -->
    <!-- jQuery 3 -->
    <script type="text/javascript">
    window.Laravel = { csrfToken: '{{ csrf_token() }}' };
    </script>
    <script src="{{ asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    {{-- <script src="{{ URL::asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script> --}}
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ URL::asset('bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
    <!-- Slimscroll -->
    <script src="{{ URL::asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{ URL::asset('bower_components/fastclick/lib/fastclick.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{ URL::asset('dist/js/adminlte.min.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ URL::asset('dist/js/demo.js')}}"></script>
    {{-- date picker --}}
    <!-- bootstrap datepicker -->
    <script src="{{ URL::asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
    <!-- fullCalendar -->
    <script src="{{ URL::asset('bower_components/moment/moment.js')}}"></script>
    <script src="{{ URL::asset('bower_components/select2/dist/js/select2.full.min.js')}}"></script>
    <script src="{{ URL::asset('bower_components/fullcalendar/dist/fullcalendar.min.js')}}"></script>



    @yield('script')
    @stack('scripts')
  </div>
  </body>
  </html>
