
@extends('Layouts.header-anggota')

@section('title', 'Daftar anggota')
<!-- =============================================== -->
@section('script1')

@endsection

@section('content')

  <div class="content-wrapper isi">
      <div class="container">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            {{$project -> nama_project}}
            <small>Daftar Anggota</small>
          </h1>

          <ol class="breadcrumb">
            <li><i class="fa fa-user"></i>  Penanggung Jawab : {{$project -> nama_penanggungjawab}}</li>

          </ol>
        </section>

        <!-- Main content -->
        <section class="content" >
          <div class="box box-default">
            <div class="box-body">
              <div class="box-body no-padding">
                <br>



              <table class="table table-striped">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Username</th>
                  <th>Tanggal Bergabung</th>
                  <th>Dibuat Oleh</th>
                  <th>Dibawa Oleh</th>
                  <th>Aksi</th>
                </tr>
                {{ csrf_field() }}
                <?php $i = 1; ?>
                @foreach ($anggotas as $listanggota)

                  <tr>
                    <td>{{$i}}.</td>
                    <td>{{ $listanggota -> username}}</td>
                    <td>
                      {{ $listanggota -> created_at}}
                    </td>
                    <td>{{$listanggota -> dibuat_oleh}}</td>
                    <td>{{$listanggota -> dibawa_oleh}}</td>

                    <td ><a target="blank" href="{{route('this', ['id_project' => $project -> id_project, 'id_anggota' => $listanggota -> id_anggota])}}"><button id="{{$listanggota -> id_anggota}}" type="button" class="btn bg-light-blue  btn-flat"><i class="fa fa-eye"></i> Lihat Progress</button></a></td>
                  </tr>
                  <?php $i++; ?>
                @endforeach
              </table>

            </div>
            </div>
          </div>
        </section>
        <!-- /.content -->
      </div>
    </div>

@endsection

@section('script2')


@endsection
