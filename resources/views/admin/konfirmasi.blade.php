
@extends('Layouts.header-admin')

@section('title', 'Konfirmasi Penghapusan')
<!-- =============================================== -->
@section('content')


      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper isi">

        <section class="content">
          <!-- /.box -->
          <div class="info-box">
            @if (isset($notification['data']['data']['namatugas_baru']))
            <span class="info-box-icon bg-yellow"><i class="fa fa-edit"></i></span>
            @else
              <span class="info-box-icon bg-red"><i class="fa fa-warning"></i></span>
            @endif


            <div class="info-box-content">
              <span class="info-box-text"> </span>
              <span class="info-box-number">{{$notification['data']['data']['text']}}</span>
              @if (isset($notification['data']['data']['namatugas_baru']))
                <div class="progress  bg-yellow">
                  <div class="progress-bar" style="width: 0%"></div>
                </div>
              @else
                <div class="progress  bg-red">
                  <div class="progress-bar" style="width: 0%"></div>
                </div>
              @endif
                  <span class="progress-description">
                    @if (!isset($notification['data']['data']['id_tugas']))
                        <div class="row">
                          <div class="col-lg-2">
                              <button type="button" name=""  class="btn btn-success btn-flat no-border" data-toggle="modal" data-target="#verifikasi"> Konfirmasi penghapusan </button>
                          </div>
                          <div class="col-lg-8">
                            <form action="{{route('tolak.konfirm')}}" method="POST">
                              {{csrf_field()}}
                              <input type="hidden" name="id_admin" value="{{$notification['data']['id_admin']}}">
                              <input type="hidden" name="id_project" value="{{$notification['data']['data']['id_project']}}">
                              <button type="submit" name="submit" class="btn btn-danger btn-flat no-border"> Tolak Konfirmasi  </button>
                            </form>
                          </div>
                        </div>
                    @else
                      @if (isset($notification['data']['data']['namatugas_baru']))
                        <div class="row">
                          <div class="col-lg-2">
                            <form  action="{{route('tugas.edit', ['id_tugas' => $notification['data']['data']['id_tugas']])}}" method="POST">
                              {{csrf_field()}}
                              <input type="hidden" name="nama_tugas" value="{{$notification['data']['data']['namatugas_baru']}}">
                              <input type="hidden" name="jenis" value="edit">
                              <input type="hidden" name="_method" value="PUT">
                              <button type="submit" name="submit"  class="btn btn-success btn-flat no-border"> Konfirmasi Perubahan </button>
                            </form>
                          </div>
                          <div class="col-lg-8">
                            <form action="{{route('tugas.tolak.konfirmasi')}}" method="POST">
                              {{csrf_field()}}
                              <input type="hidden" name="id_admin" value="{{$notification['data']['id_admin']}}">
                              <input type="hidden" name="id_tugas" value="{{$notification['data']['data']['id_tugas']}}">
                              <input type="hidden" name="jenis" value="edit">
                              <button type="submit" name="submit" class="btn btn-danger btn-flat no-border"> Tolak Konfirmasi  </button>
                            </form>
                          </div>
                        </div>
                      @else
                        <div class="row">
                          <div class="col-lg-2">
                              <button type="button" name=""  class="btn btn-success btn-flat no-border" data-toggle="modal" data-target="#verifikasi"> Konfirmasi penghapusan </button>
                          </div>
                          <div class="col-lg-8">
                            <form action="{{route('tugas.tolak.konfirmasi')}}" method="POST">
                              {{csrf_field()}}
                              <input type="hidden" name="id_admin" value="{{$notification['data']['id_admin']}}">
                              <input type="hidden" name="id_tugas" value="{{$notification['data']['data']['id_tugas']}}">
                              <input type="hidden" name="jenis" value="hapus">
                              <button type="submit" name="submit" class="btn btn-danger btn-flat no-border"> Tolak Konfirmasi  </button>
                            </form>
                          </div>
                        </div>
                      @endif
                    @endif




                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>

        </section>

        <!-- /.content -->
      </div>
      <div class="modal modal-danger fade" id="verifikasi">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="box box-danger">
              <div class="modal-header" id="verifikasidelete">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Peringatan</h4>
                </div>
                <div class="modal-body">
                  <strong>Apakah anda yakin?</strong>
                  @if (!isset($notification['data']['data']['id_tugas']))
                      <p id="desc">Sekali melakukan penghapusan proyek anda tidak dapat mengembalikan proyek yang sudah dihapus</p>
                  @else
                      <p id="desc">Sekali melakukan penghapusan tugas anda tidak dapat mengembalikan tugas yang sudah dihapus</p>
                  @endif

                  <!--  -->
                </div>
                @if (!isset($notification['data']['data']['id_tugas']))
                <form action="{{route('project.delete')}}" method="POST">
                  {{csrf_field()}}
                  <div class="modal-footer">
                    <input type="hidden" name="id_project" value="{{$notification['data']['data']['id_project']}}">
                    <button type="button" class="btn btn-default btn-flat " data-dismiss="modal">Tidak</button>
                    <button type="submit" name="submit" class="btn btn-default btn-flat ">Ya</button>
                  </div>
                </form>
                @else
                  <form action="{{route('tugas.delete', ['id_tugas' => $notification['data']['data']['id_tugas'] ])}}" method="POST">
                    {{csrf_field()}}
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default btn-flat " data-dismiss="modal">Tidak</button>
                      <button type="submit" name="submit" class="btn btn-default btn-flat ">Ya</button>
                    </div>
                  </form>
                @endif
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

@endsection
