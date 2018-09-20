
@extends('Layouts.header-anggota')

@section('title', 'Daftar admin')
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
            <small>Daftar Admin</small>
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
                    <th>Nama Admin</th>
                    <th>Alamat Email</th>
                    <th>Tanggal Bergabung</th>
                  </tr>
                  {{ csrf_field() }}
                  <?php $i = 1; ?>
                  @foreach ($admins as $admin)

                    <tr>
                      <td>{{$i}}.</td>
                      <td>{{ $admin -> name}}</td>
                      <td>
                        {{ $admin -> email}}
                      </td>
                      <td>{{$admin -> tglgabung}}</td>
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
