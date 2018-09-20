
@extends('Layouts.header-anggota')

@section('title', 'Halaman utama')
<!-- =============================================== -->
@section('content')

  <div class="content-wrapper isi" style="background-image: url({{URL::asset('dist/img/bg2.jpg')}});">
    <div class="container">
      <!-- Content Header (Page header) -->
      <section class="content-header">

      </section>

      <!-- Main content -->

      <section class="content" style="padding-top:0px;" >
        <div class="row">
          <div class="col-lg-offset-3">

              <br>

                <div class="row" style="width:auto;">
                  <br>
                  <div class="col-lg-8" style="background-color:rgba(255,255,255, 0.6);">
                    <br>
                    <div class="col-lg-6">
                      <a href="{{route('admin.projectlist')}}">
                        <button type="button" class="btn  btn-proyek btn-block  btn-warning btn-lg btn-flat no-border" >
                          Dashboard Proyek
                        </button>
                      </a>
                    </div>
                    <div class="col-lg-6">
                      <a href="{{route('admin.anggotalist')}}">
                        <button type="button" class="btn  btn-proyek btn-block  btn-primary btn-lg btn-flat no-border" >
                          Dashboard Anggota
                        </button>
                      </a>
                    </div>
                      <br>
                  </div>


                </div>



            </div>
            <!-- /.box -->


          <!-- /.col -->
        </div>
      </section>
    </div>
    <!-- /.content -->
  </div>

  <!--modal-->

  @endsection
  @section('script2')
    <script>
    $(document).ready(function() {

    });
    </script>
  @endsection
