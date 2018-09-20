
@extends('Layouts.header-anggota')

@section('title', 'Proyek')
<!-- =============================================== -->
@section('content')

  <div class="content-wrapper isi">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header" style="margin-bottom:0px;">
      <div class="row"  style="padding-bottom:0px;">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 no-padding" style="padding-bottom:0px;">
          <h2>
            Daftar
            <small>Project</small>
          </h2>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content" style="padding-top:0px;">
      <div class="row">
        <div class="box box-primary">
          <!-- /.box-header -->

          <!-- /.box-body -->
          <div class="proyekbox">
          <br>
            <div class="row">
              @foreach ($projects as $project)
                <div class="col-md-3">
                    <a href="{{route('anggota.aktivitas', ['id_project' => $project -> id_project])}}"><button type="button"  class="btn  btn-proyek btn-block btn-flat btn-primary btn-lg" >
                      {{ $project -> nama_project}}
                    </button></a>
                  </div>
              @endforeach
            </div>
          </div>
          <!-- /.box -->
        </div>

        <!-- /.col -->
      </div>
    </section>
  </div>
  <!-- /.content -->
</div>

@endsection
