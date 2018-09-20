
@extends('Layouts.header-anggota')

@section('title', 'Aktivitas')
<!-- =============================================== -->
@section('script1')

@endsection

@section('content')

  <div class="content-wrapper isi">
    <div class="container">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Proyek
          <small>{{$project -> nama_project}}</small>
        </h1>

        <ol class="breadcrumb">
          <li><i class="fa fa-user"></i>  Penanggung Jawab : {{$project -> nama_penanggungjawab}}</li>

        </ol>
      </section>

      <!-- Main content -->
      <section class="content" >
        <div class="alert alert-success sukses" style="display: none;">
          <h4><i class="icon fa fa-check"></i> Sukses!</h4>
          <p id="descalert">  Tugas Berhasil dihapus.</p>
        </div>
        <div class="alert alert-danger gagal" style="display: none;">
          <h4><i class="icon fa fa-exclamation"></i> Sukses!</h4>
          <p id="descalertgagal"></p>
        </div>
        <div class="box box-default">
          <div class="box-body">
            <div class="row">
              <div class="col-sm-12 col-md-12 col-xs-12 col-lg-12">
                <a href="{{route('anggota.project', ['id_project' => $project -> id_project])}}">
                  <button type="button" class="btn btn-success btn-flat" data-toggle="modal" data-target="#daftar-anggota"> <i class="fa fa-group"></i> Lihat Daftar Anggota</button>
                </a>
                <a href="{{route('anggota.project.admin', ['id_project' => $project -> id_project])}}">
                  <button type="button" class="btn btn-warning btn-flat" data-toggle="modal" data-target="#daftar-anggota"> <i class="fa fa-group"></i> Lihat Daftar Admin</button>
                </a>
                <a href="{{route('this', ['id_project' => $project -> id_project, 'id_anggota' => Auth::id()])}}">
                  <button type="button" class="btn bg-light-blue  btn-flat pull-right"><i class="fa fa-eye"></i> Lihat Progress</button>
                </a>

              </div>
            </div>
            <br>
            <br>
            <div class="box-body">
              <div class="row">
                <div class="col-lg-12">

                  <div class="col-md-3">
                    <div class="ada">
                    <div class="box box-solid box-primary">
                      <div class="box-header with-border">
                        <h4 class="box-title"><i class="fa fa-list"></i> Daftar Tugas</h4>
                      </div>
                      <div class="box-body" id="Tersedia" ondrop="drop(event, this)" ondragover="noAllowDrop(event)">
                        {{ csrf_field() }}
                        <?php $i = 1; ?>
                        <!-- the events -->
                        @foreach ($tugases as $listtugas)
                          @if ($listtugas -> status == null)
                            <div class="box box-default" >
                              <div class="box-header with-border no-padding">
                                @if ($listtugas -> id_PJ1 !== Auth::id())
                                  <button type="button" class="btn btn-block btn-accordion btn-flat no-margin no-border" data-toggle="collapse" data-parent="#accordion" href={{"#collapse".$i}} style="text-align:left; background-color:transparent; "> {{$listtugas -> nama_tugas}} - {{$listtugas -> PJ1}}</button>{{-- ini isinya nama_tugas --}}
                                @else
                                  <button type="button" class="btn btn-block btn-accordion btn-flat no-margin no-border" data-toggle="collapse" data-parent="#accordion" href={{"#collapse".$i}} style="text-align:left; background-color:transparent; "> {{$listtugas -> nama_tugas}}</button>{{-- ini isinya nama_tugas --}}
                                @endif

                                <!-- /.box-tools -->
                              </div>
                              <!-- /.box-header -->
                              <div id={{"collapse".$i}} class="panel-collapse collapse">
                            <!-- /.box-header -->
                            <div class="box-body">
                              <?php
                              $udah = false;
                              ?>
                              @foreach ($subtugases as $listsubtugas)
                                @if(($listsubtugas -> nama_tugas == $listtugas -> nama_tugas) && ($listsubtugas -> status == null))
                                  @if ($listsubtugas -> due_date == null)
                                    @if ($listsubtugas -> keterangan == 'revisi')
                                      <div class="external-event bg-teal dskrps" data-toggle="modal" data-target="#deskripsirev" id="{{$listsubtugas -> id_aktivitas}}" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">
                                        {{$listsubtugas -> nama_subtugas}} revisi {{$listsubtugas -> revisi_hit}}
                                        <input type="hidden" name="deskripsi_revisi" value="{{$listsubtugas -> deskripsi}}">
                                        <input type="hidden" name="nasub" value="{{$listsubtugas -> nama_subtugas}}">
                                        <input type="hidden" name="konfimass" value="{{$listsubtugas -> confirm}}">
                                        <input type="hidden" name="duedate" value="{{$listsubtugas -> due_date}}">
                                        <input type="hidden" name="stat" value="{{$listsubtugas -> status}}">
                                      </div>
                                    @else
                                      <div class="external-event bg-teal dskrps" data-toggle="modal" data-target="#deskripsirev" id="{{$listsubtugas -> id_aktivitas}}" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">
                                        {{$listsubtugas -> nama_subtugas}}
                                        <input type="hidden" name="deskripsi_revisi" value="{{$listsubtugas -> deskripsi}}">
                                        <input type="hidden" name="nasub" value="{{$listsubtugas -> nama_subtugas}}">
                                        <input type="hidden" name="konfimass" value="{{$listsubtugas -> confirm}}">
                                        <input type="hidden" name="duedate" value="{{$listsubtugas -> due_date}}">
                                        <input type="hidden" name="stat" value="{{$listsubtugas -> status}}">
                                      </div>
                                    @endif
                                  @elseif($listsubtugas -> due_date != null && $udah == false)
                                    @if ($listsubtugas -> keterangan == 'revisi')
                                      <div class="external-event bg-teal dskrps" data-toggle="modal" data-target="#deskripsirev" id="{{$listsubtugas -> id_aktivitas}}" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">
                                        {{$listsubtugas -> nama_subtugas}} revisi {{$listsubtugas -> revisi_hit}}
                                        <input type="hidden" name="deskripsi_revisi" value="{{$listsubtugas -> deskripsi}}">
                                        <input type="hidden" name="nasub" value="{{$listsubtugas -> nama_subtugas}}">
                                        <input type="hidden" name="konfimass" value="{{$listsubtugas -> confirm}}">
                                        <input type="hidden" name="duedate" value="{{$listsubtugas -> due_date}}">
                                        <input type="hidden" name="stat" value="{{$listsubtugas -> status}}">
                                      </div>
                                    @else
                                      <div class="external-event bg-teal dskrps" data-toggle="modal" data-target="#deskripsirev" id="{{$listsubtugas -> id_aktivitas}}" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">
                                        {{$listsubtugas -> nama_subtugas}}
                                        <input type="hidden" name="deskripsi_revisi" value="{{$listsubtugas -> deskripsi}}">
                                        <input type="hidden" name="nasub" value="{{$listsubtugas -> nama_subtugas}}">
                                        <input type="hidden" name="konfimass" value="{{$listsubtugas -> confirm}}">
                                        <input type="hidden" name="duedate" value="{{$listsubtugas -> due_date}}">
                                        <input type="hidden" name="stat" value="{{$listsubtugas -> status}}">
                                      </div>

                                    @endif
                                    <?php
                                      $udah = true;
                                     ?>
                                  @elseif($listsubtugas -> due_date != null && $udah == true)
                                    @if ($listsubtugas -> keterangan == 'revisi')
                                      <div class="external-event bg-gray dskrps" data-toggle="modal" data-target="#deskripsirev" id="{{$listsubtugas -> id_aktivitas}}" draggable="false" ondragstart="drag(event)" ondragover="noAllowDrop(event)">
                                        {{$listsubtugas -> nama_subtugas}} revisi {{$listsubtugas -> revisi_hit}}
                                        <input type="hidden" name="deskripsi_revisi" value="{{$listsubtugas -> deskripsi}}">
                                        <input type="hidden" name="nasub" value="{{$listsubtugas -> nama_subtugas}}">
                                        <input type="hidden" name="konfimass" value="{{$listsubtugas -> confirm}}">
                                        <input type="hidden" name="duedate" value="{{$listsubtugas -> due_date}}">
                                        <input type="hidden" name="stat" value="{{$listsubtugas -> status}}">
                                      </div>
                                    @else
                                      <div class="external-event bg-gray dskrps" data-toggle="modal" data-target="#deskripsirev" id="{{$listsubtugas -> id_aktivitas}}" draggable="false" ondragstart="drag(event)" ondragover="noAllowDrop(event)">
                                        {{$listsubtugas -> nama_subtugas}}
                                        <input type="hidden" name="deskripsi_revisi" value="{{$listsubtugas -> deskripsi}}">
                                        <input type="hidden" name="nasub" value="{{$listsubtugas -> nama_subtugas}}">
                                        <input type="hidden" name="konfimass" value="{{$listsubtugas -> confirm}}">
                                        <input type="hidden" name="duedate" value="{{$listsubtugas -> due_date}}">
                                        <input type="hidden" name="stat" value="{{$listsubtugas -> status}}">
                                      </div>

                                    @endif
                                  @endif
                                @endif
                              @endforeach
                              {{-- <div class="external-event bg-teal" id="drag1" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">Lunch</div>
                              <div class="external-event bg-teal" id="drag2" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">Go home</div>
                              <div class="external-event bg-teal" id="drag3" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">Do homework</div>
                              <div class="external-event bg-teal" id="drag4" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">Work on UI design</div>
                              <div class="external-event bg-teal" id="drag5" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">Sleep tight</div> --}}
                            </div>
                          </div>
                            <!-- /.box-body -->
                          </div>
                          <?php $i++; ?>
                          @endif
                        @endforeach




                      </div>
                      <!-- /.box-body -->
                    </div>

                    </div>
                  </div>
                  <div class="box-body no-padding">
                    <div class="col-md-3">
                      <div class="kerjakan">


                      <div class="box box-solid box-success">
                        <div class="box-header with-border">
                          <h4 class="box-title"> <i class="fa fa-hourglass-start"></i> Dikerjakan</h4>
                        </div>
                        <div class="box-body" id="Dikerjakan" ondrop="drop(event)" ondragover="allowDrop(event)">
                          <?php $j = 1; ?>
                          @foreach ($tugases as $tugasdo)
                            @if ($tugasdo -> status == "Dikerjakan")
                              <div class="box box-default" >
                                <div class="box-header with-border no-padding">
                                  @if ($tugasdo -> id_PJ1 !== Auth::id())
                                    <button type="button" class="btn btn-block btn-accordion btn-flat no-margin no-border" data-toggle="collapse" data-parent="#accordion" href={{"#collapsea".$j}} style="text-align:left; background-color:transparent; "> {{$tugasdo -> nama_tugas}} - {{$tugasdo -> PJ1}}</button>{{-- ini isinya nama_tugas --}}
                                  @else
                                    <button type="button" class="btn btn-block btn-accordion btn-flat no-margin no-border" data-toggle="collapse" data-parent="#accordion" href={{"#collapsea".$j}} style="text-align:left; background-color:transparent; "> {{$tugasdo -> nama_tugas}}</button>{{-- ini isinya nama_tugas --}}
                                  @endif

                                  <!-- /.box-tools -->
                                </div>
                                <!-- /.box-header -->
                                <div id={{"collapsea".$j}} class="panel-collapse collapse">
                                <!-- /.box-header -->
                                <div class="box-body">
                                  @foreach ($subtugases as $listsubtugas1)
                                    @if(($listsubtugas1 -> nama_tugas == $tugasdo -> nama_tugas) && ($listsubtugas1 -> status == 'Dikerjakan'))
                                      @if ($listsubtugas1 -> keterangan == 'revisi')
                                        {{-- <div class="external-event bg-teal" id="{{$listsubtugas1 -> id_aktivitas}}" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">{{$listsubtugas1 -> nama_subtugas}} revisi {{$listsubtugas1 -> revisi_hit}}</div> --}}
                                        <div class="external-event bg-teal dskrps" data-toggle="modal" data-target="#deskripsirev" id="{{$listsubtugas1 -> id_aktivitas}}" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">
                                          {{$listsubtugas1 -> nama_subtugas}} revisi {{$listsubtugas1 -> revisi_hit}}
                                          <input type="hidden" name="deskripsi_revisi" value="{{$listsubtugas1 -> deskripsi}}">
                                          <input type="hidden" name="nasub" value="{{$listsubtugas1 -> nama_subtugas}}">
                                          <input type="hidden" name="konfimass" value="{{$listsubtugas1 -> confirm}}">
                                          <input type="hidden" name="duedate" value="{{$listsubtugas1 -> due_date}}">
                                          <input type="hidden" name="stat" value="{{$listsubtugas1 -> status}}">
                                          <input type="hidden" name="prog" value="{{$listsubtugas1 -> progress}}">
                                          <input type="hidden" name="ua" value="{{$listsubtugas1 -> updated_at}}">
                                        </div>
                                      @else
                                          <div class="external-event bg-teal dskrps" data-toggle="modal" data-target="#deskripsirev" id="{{$listsubtugas1 -> id_aktivitas}}" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">
                                            {{$listsubtugas1 -> nama_subtugas}}
                                            <input type="hidden" name="deskripsi_revisi" value="{{$listsubtugas1 -> deskripsi}}">
                                            <input type="hidden" name="nasub" value="{{$listsubtugas1 -> nama_subtugas}}">
                                            <input type="hidden" name="konfimass" value="{{$listsubtugas1 -> confirm}}">
                                            <input type="hidden" name="duedate" value="{{$listsubtugas1 -> due_date}}">
                                            <input type="hidden" name="stat" value="{{$listsubtugas1 -> status}}">
                                            <input type="hidden" name="prog" value="{{$listsubtugas1 -> progress}}">
                                            <input type="hidden" name="ua" value="{{$listsubtugas1 -> updated_at}}">
                                          </div>
                                      @endif

                                    @endif
                                  @endforeach
                                </div>
                              </div>
                                <!-- /.box-body -->
                              </div>
                              <?php $j++; ?>
                              @endif
                            @endforeach

                        </div>
                      </div>
                      <!-- /.box-body -->
                    </div>
                    </div>


                    <div class="col-md-3">
                      <div class="selesai">


                      <div class="box box-solid box-info">
                        <div class="box-header with-border">
                          <h4 class="box-title"> <i class="fa fa-check"></i> Selesai</h4>
                        </div>
                        <div class="box-body" id="Selesai" ondrop="drop(event, this)" ondragover="allowDrop(event)">
                          <!-- the events -->
                          <?php $k = 1; ?>
                          @foreach ($tugases as $tugasdone)
                            @if ($tugasdone -> status == "Selesai")
                              <div class="box box-default" >
                                <div class="box-header with-border no-padding">
                                  @if ($tugasdone -> id_PJ1 !== Auth::id())
                                    <button type="button" class="btn btn-block btn-accordion btn-flat no-margin no-border" data-toggle="collapse" data-parent="#accordion" href={{"#collapseb".$k}} style="text-align:left; background-color:transparent; "> {{$tugasdone -> nama_tugas}} - {{$tugasdone -> PJ1}}</button>{{-- ini isinya nama_tugas --}}
                                  @else
                                      <button type="button" class="btn btn-block btn-accordion btn-flat no-margin no-border" data-toggle="collapse" data-parent="#accordion" href={{"#collapseb".$k}} style="text-align:left; background-color:transparent; "> {{$tugasdone -> nama_tugas}}</button>{{-- ini isinya nama_tugas --}}
                                  @endif
                                  <!-- /.box-tools -->
                                </div>
                                <!-- /.box-header -->
                                <div id={{"collapseb".$k}} class="panel-collapse collapse">
                                <div class="box-body">
                                  @foreach ($subtugases as $listsubtugas3)
                                    @if(($listsubtugas3 -> nama_tugas == $tugasdone -> nama_tugas) && ($listsubtugas3 -> status == 'Selesai'))
                                      @if ($listsubtugas3 -> confirm !== null)
                                        @if ($listsubtugas3 -> keterangan == 'revisi')
                                          {{-- <div class="external-event bg-teal" id="{{$listsubtugas3 -> id_aktivitas}}" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">{{$listsubtugas3 -> nama_subtugas}} revisi {{$listsubtugas3 -> revisi_hit}} <small class="pull-right"> {{$listsubtugas3 -> confirm}} <i class="fa fa-check-circle-o"></i> </small></div> --}}
                                          <div class="external-event bg-teal dskrps" data-toggle="modal" data-target="#deskripsirev" id="{{$listsubtugas3 -> id_aktivitas}}" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">
                                            {{$listsubtugas3 -> nama_subtugas}} revisi {{$listsubtugas3 -> revisi_hit}}
                                            <input type="hidden" name="deskripsi_revisi" value="{{$listsubtugas3 -> deskripsi}}">
                                            <input type="hidden" name="nasub" value="{{$listsubtugas3 -> nama_subtugas}}">
                                            <input type="hidden" name="konfimass" value="{{$listsubtugas3 -> confirm}}">
                                            <input type="hidden" name="duedate" value="{{$listsubtugas3 -> due_date}}">
                                            <input type="hidden" name="prog" value="100">
                                            <input type="hidden" name="ed" value="{{$listsubtugas3 -> end_date}}">
                                            <br /><small><i class="fa fa-check-circle-o"></i> </small>
                                          </div>
                                        @else
                                          <div class="external-event bg-teal dskrps" data-toggle="modal" data-target="#deskripsirev" id="{{$listsubtugas3 -> id_aktivitas}}" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">
                                            {{$listsubtugas3 -> nama_subtugas}}
                                            <input type="hidden" name="deskripsi_revisi" value="{{$listsubtugas3 -> deskripsi}}">
                                            <input type="hidden" name="nasub" value="{{$listsubtugas3 -> nama_subtugas}}">
                                            <input type="hidden" name="konfimass" value="{{$listsubtugas3 -> confirm}}">
                                            <input type="hidden" name="duedate" value="{{$listsubtugas3 -> due_date}}">
                                            <input type="hidden" name="prog" value="100">
                                            <input type="hidden" name="ed" value="{{$listsubtugas3 -> end_date}}">
                                            <br /><small><i class="fa fa-check-circle-o"></i> </small>
                                          </div>
                                        @endif
                                      @else
                                        @if ($listsubtugas3 -> keterangan == 'revisi')
                                          {{-- <div class="external-event bg-teal" id="{{$listsubtugas3 -> id_aktivitas}}" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">{{$listsubtugas3 -> nama_subtugas}} revisi {{$listsubtugas3 -> revisi_hit}}</div> --}}
                                          <div class="external-event bg-teal dskrps" data-toggle="modal" data-target="#deskripsirev" id="{{$listsubtugas3 -> id_aktivitas}}" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">
                                            {{$listsubtugas3 -> nama_subtugas}} revisi {{$listsubtugas3 -> revisi_hit}}
                                            <input type="hidden" name="deskripsi_revisi" value="{{$listsubtugas3 -> deskripsi}}">
                                            <input type="hidden" name="nasub" value="{{$listsubtugas3 -> nama_subtugas}}">
                                            <input type="hidden" name="konfimass" value="{{$listsubtugas3 -> confirm}}">
                                            <input type="hidden" name="duedate" value="{{$listsubtugas3 -> due_date}}">
                                            <input type="hidden" name="prog" value="100">
                                            <input type="hidden" name="ed" value="{{$listsubtugas3 -> end_date}}">
                                          </div>
                                        @else
                                          <div class="external-event bg-teal dskrps" data-toggle="modal" data-target="#deskripsirev" id="{{$listsubtugas3 -> id_aktivitas}}" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">
                                            {{$listsubtugas3 -> nama_subtugas}}
                                            <input type="hidden" name="deskripsi_revisi" value="{{$listsubtugas3 -> deskripsi}}">
                                            <input type="hidden" name="nasub" value="{{$listsubtugas3 -> nama_subtugas}}">
                                            <input type="hidden" name="konfimass" value="{{$listsubtugas3 -> confirm}}">
                                            <input type="hidden" name="duedate" value="{{$listsubtugas3 -> due_date}}">
                                            <input type="hidden" name="prog" value="100">
                                            <input type="hidden" name="ed" value="{{$listsubtugas3 -> end_date}}">
                                          </div>
                                        @endif
                                      @endif
                                    @endif
                                  @endforeach
                                  {{-- <div class="external-event bg-teal" id="drag1" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">Lunch</div>
                                  <div class="external-event bg-teal" id="drag2" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">Go home</div>
                                  <div class="external-event bg-teal" id="drag3" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">Do homework</div>
                                  <div class="external-event bg-teal" id="drag4" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">Work on UI design</div>
                                  <div class="external-event bg-teal" id="drag5" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">Sleep tight</div> --}}
                                </div>
                              </div>
                                <!-- /.box-body -->
                              </div>
                                <?php $k++; ?>
                              @endif

                            @endforeach

                        </div>
                      </div>
                      <!-- /.box-body -->
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="postpone">
                      <div class="box box-solid box-warning">
                        <div class="box-header with-border">
                          <h4 class="box-title"> <i class="fa fa-clock-o"></i> Postpone</h4>
                        </div>
                        <div class="box-body" id="Ditunda" ondrop="drop(event, this)" ondragover="allowDrop(event)">
                          <?php $l = 1; ?>
                          @foreach ($tugases as $tugaspostpone)
                            @if ($tugaspostpone -> status == "Ditunda")
                              <div class="box box-default" >
                                <div class="box-header with-border no-padding">
                                  @if ($tugaspostpone -> id_PJ1 !== Auth::id())
                                    <button type="button" class="btn btn-block btn-accordion btn-flat no-margin no-border" data-toggle="collapse" data-parent="#accordion" href={{"#collapsec".$l}} style="text-align:left; background-color:transparent; "> {{$tugaspostpone -> nama_tugas}} - {{$tugaspostpone -> PJ1}}</button>{{-- ini isinya nama_tugas --}}
                                  @else
                                  <button type="button" class="btn btn-block btn-accordion btn-flat no-margin no-border" data-toggle="collapse" data-parent="#accordion" href={{"#collapsec".$l}} style="text-align:left; background-color:transparent; "> {{$tugaspostpone -> nama_tugas}}</button>{{-- ini isinya nama_tugas --}}
                                  @endif

                                  <!-- /.box-tools -->
                                </div>
                                <!-- /.box-header -->
                                <div id={{"collapsec".$l}} class="panel-collapse collapse">
                                <!-- /.box-header -->
                                <div class="box-body">
                                  @foreach ($subtugases as $listsubtugas4)
                                    @if(($listsubtugas4 -> nama_tugas == $tugaspostpone -> nama_tugas) && ($listsubtugas4 -> status == 'Ditunda'))
                                      @if ($listsubtugas4 -> confirm !== null)
                                        @if ($listsubtugas4 -> keterangan == 'revisi')
                                          {{-- <div class="external-event bg-teal" id="{{$listsubtugas4 -> id_aktivitas}}" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">{{$listsubtugas4 -> nama_subtugas}} revisi  {{$listsubtugas4 -> revisi_hit}} <small class="pull-right"> {{$listsubtugas4 -> confirm}} <i class="fa fa-check-circle-o"></i> </small></div> --}}
                                          <div class="external-event bg-teal dskrps" data-toggle="modal" data-target="#deskripsirev" id="{{$listsubtugas4 -> id_aktivitas}}" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">
                                            {{$listsubtugas4 -> nama_subtugas}} revisi {{$listsubtugas4 -> revisi_hit}} <br>
                                            <input type="hidden" name="deskripsi_revisi" value="{{$listsubtugas4 -> deskripsi}}">
                                            <input type="hidden" name="nasub" value="{{$listsubtugas4 -> nama_subtugas}}">
                                            <input type="hidden" name="duedate" value="{{$listsubtugas4 -> due_date}}">
                                            <input type="hidden" name="konfimass" value="{{$listsubtugas4 -> confirm}}">
                                            <input type="hidden" name="prog" value="{{$listsubtugas4 -> progress}}">
                                            <input type="hidden" name="ps" value="{{$listsubtugas4 -> postpone_start}}">
                                            <small><i class="fa fa-check-circle-o"></i> </small>
                                          </div>
                                        @else
                                        <div class="external-event bg-teal" id="{{$listsubtugas4 -> id_aktivitas}}" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">
                                          {{$listsubtugas4 -> nama_subtugas}} <br>
                                          <input type="hidden" name="deskripsi_revisi" value="{{$listsubtugas4 -> deskripsi}}">
                                          <input type="hidden" name="nasub" value="{{$listsubtugas4 -> nama_subtugas}}">
                                          <input type="hidden" name="duedate" value="{{$listsubtugas4 -> due_date}}">
                                          <input type="hidden" name="konfimass" value="{{$listsubtugas4 -> confirm}}">
                                          <input type="hidden" name="prog" value="{{$listsubtugas4 -> progress}}">
                                          <input type="hidden" name="ps" value="{{$listsubtugas4 -> postpone_start}}">
                                          <small ><i class="fa fa-check-circle-o"></i> </small></div>
                                        @endif
                                      @else
                                        @if ($listsubtugas4 -> keterangan == 'revisi')
                                          {{-- <div class="external-event bg-teal" id="{{$listsubtugas4 -> id_aktivitas}}" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">{{$listsubtugas4 -> nama_subtugas}} revisi  {{$listsubtugas4 -> revisi_hit}}</div> --}}
                                          <div class="external-event bg-teal dskrps" data-toggle="modal" data-target="#deskripsirev" id="{{$listsubtugas4 -> id_aktivitas}}" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">
                                            {{$listsubtugas4 -> nama_subtugas}} revisi {{$listsubtugas4 -> revisi_hit}} <br>
                                            <input type="hidden" name="deskripsi_revisi" value="{{$listsubtugas4 -> deskripsi}}">
                                            <input type="hidden" name="nasub" value="{{$listsubtugas4 -> nama_subtugas}}">
                                            <input type="hidden" name="duedate" value="{{$listsubtugas4 -> due_date}}">
                                            <input type="hidden" name="konfimass" value="{{$listsubtugas4 -> confirm}}">
                                            <input type="hidden" name="prog" value="{{$listsubtugas4 -> progress}}">
                                            <input type="hidden" name="ps" value="{{$listsubtugas4 -> postpone_start}}">
                                          </div>
                                        @else
                                        <div class="external-event bg-teal dskrps" data-toggle="modal" data-target="#deskripsirev" id="{{$listsubtugas4 -> id_aktivitas}}" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">
                                          {{$listsubtugas4 -> nama_subtugas}} <br>
                                          <input type="hidden" name="deskripsi_revisi" value="{{$listsubtugas4 -> deskripsi}}">
                                          <input type="hidden" name="nasub" value="{{$listsubtugas4 -> nama_subtugas}}">
                                          <input type="hidden" name="duedate" value="{{$listsubtugas4 -> due_date}}">
                                          <input type="hidden" name="konfimass" value="{{$listsubtugas4 -> confirm}}">
                                          <input type="hidden" name="prog" value="{{$listsubtugas4 -> progress}}">
                                          <input type="hidden" name="ps" value="{{$listsubtugas4 -> postpone_start}}">
                                        </div>
                                        @endif
                                      @endif

                                    @endif
                                  @endforeach
                                  {{-- <div class="external-event bg-teal" id="drag1" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">Lunch</div>
                                  <div class="external-event bg-teal" id="drag2" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">Go home</div>
                                  <div class="external-event bg-teal" id="drag3" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">Do homework</div>
                                  <div class="external-event bg-teal" id="drag4" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">Work on UI design</div>
                                  <div class="external-event bg-teal" id="drag5" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">Sleep tight</div> --}}
                                </div>
                              </div>
                                <!-- /.box-body -->
                              </div>
                              <?php $l++; ?>
                              @endif
                            @endforeach
                        </div>
                      </div>
                      <!-- /.box-body -->
                    </div>
                    </div>
                  </div>
                </div>

              </div>
              <!-- /.row -->
            </div>
          </div>
        </div>
      </section>
      <!-- /.content -->
      @if ($tugasespj2 !== [])
        <section class="content" style="padding-top:0px;" >

              <div class="row">
                <div class="col-lg-12">
                  <div class="adu">
                  <div class="box box-solid box-default no-border">
                    <div class="box-header no-border">
                      <h4 class="box-title"><i class="fa fa-list"></i> Daftar Tugas Yang Ditangani Anggota Lain</h4>
                    </div>
                    <div class="box-body" id="Tersedia" ondrop="drop(event, this)" ondragover="noAllowDrop(event)">
                      {{ csrf_field() }}
                      <?php $i = 1; ?>
                      <!-- the events -->
                      @foreach ($tugasespj2 as $listtugas11)
                        {{-- @if ($listtugas11 -> status !== null) --}}
                          <div class="box box-danger" >
                            <div class="box-header with-border no-padding">
                                <button type="button" class="btn btn-block btn-accordion btn-flat no-margin no-border" data-toggle="collapse" data-parent="#accordion" href={{"#collapsew".$i}} style="text-align:left; background-color:transparent; "> {{$listtugas11 -> nama_tugas}}</button>{{-- ini isinya nama_tugas --}}

                              <!-- /.box-tools -->
                            </div>
                            <!-- /.box-header -->
                            <div id={{"collapsew".$i}} class="panel-collapse collapse">
                          <!-- /.box-header -->
                          <div class="box-body">
                            @foreach ($subtugasespj2 as $listsubtugas11)
                              @if($listsubtugas11 -> nama_tugas == $listtugas11 -> nama_tugas)
                               {{-- && ($listsubtugas11 -> status !== null) --}}
                                @if ($listsubtugas11 -> keterangan == 'revisi')
                                  {{-- <div class="external-event bg-red" id="{{$listsubtugas11 -> id_aktivitas}}" draggable="false" ondragstart="drag(event)" ondragover="noAllowDrop(event)">{{$listsubtugas11 -> nama_subtugas}} revisi {{$listsubtugas11 -> revisi_hit}} - {{$listsubtugas11 -> PJ2}}
                                    <small class="pull-right">{{$listsubtugas11 -> status}}
                                      @if ($listsubtugas11 -> confirm !== null)
                                      {{$listsubtugas11 -> confirm}} <i class="fa fa-check-circle-o"></i>
                                    @endif
                                    </small>
                                    </div> --}}
                                    <div class="external-event bg-red dskrps" data-toggle="modal" data-target="#deskripsirev" id="{{$listsubtugas11 -> id_aktivitas}}" draggable="false" ondragstart="drag(event)" ondragover="noAllowDrop(event)" style="cursor:pointer">
                                      {{$listsubtugas11 -> nama_subtugas}} revisi {{$listsubtugas11 -> revisi_hit}}  - {{$listsubtugas11 -> PJ2}}
                                      <input type="hidden" name="deskripsi_revisi" value="{{$listsubtugas11 -> deskripsi}}">
                                      <input type="hidden" name="nasub" value="{{$listsubtugas11 -> nama_subtugas}}">
                                      <input type="hidden" name="duedate" value="{{$listsubtugas11 -> due_date}}">
                                      <input type="hidden" name="konfimass" value="{{$listsubtugas11 -> confirm}}">
                                      <input type="hidden" name="prog" value="{{$listsubtugas11 -> progress}}">
                                      <input type="hidden" name="ua" value="{{$listsubtugas11 -> updated_at}}">
                                      <small class="pull-right">{{$listsubtugas11 -> status}}
                                        @if ($listsubtugas11 -> confirm !== null)
                                        {{$listsubtugas11 -> confirm}} <i class="fa fa-check-circle-o"></i>
                                      @endif
                                      </small>
                                    </div>
                                @else
                                  <div class="external-event bg-red dskrps" data-toggle="modal" data-target="#deskripsirev" id="{{$listsubtugas11 -> id_aktivitas}}" draggable="false" ondragstart="drag(event)" ondragover="noAllowDrop(event)" style="cursor:pointer">{{$listsubtugas11 -> nama_subtugas}} - {{$listsubtugas11 -> PJ2}}
                                    <input type="hidden" name="deskripsi_revisi" value="{{$listsubtugas11 -> deskripsi}}">
                                    <input type="hidden" name="nasub" value="{{$listsubtugas11 -> nama_subtugas}}">
                                    <input type="hidden" name="duedate" value="{{$listsubtugas11 -> due_date}}">
                                    <input type="hidden" name="konfimass" value="{{$listsubtugas11 -> confirm}}">
                                    <input type="hidden" name="prog" value="{{$listsubtugas11 -> progress}}">
                                    <input type="hidden" name="ua" value="{{$listsubtugas11 -> updated_at}}">
                                    <small class="pull-right">{{$listsubtugas11 -> status}}
                                      @if ($listsubtugas11 -> confirm !== null)
                                      {{$listsubtugas11 -> confirm}} <i class="fa fa-check-circle-o"></i>
                                    @endif
                                    </small>
                                  </div>
                                @endif

                              @endif
                            @endforeach
                            {{-- <div class="external-event bg-teal" id="drag1" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">Lunch</div>
                            <div class="external-event bg-teal" id="drag2" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">Go home</div>
                            <div class="external-event bg-teal" id="drag3" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">Do homework</div>
                            <div class="external-event bg-teal" id="drag4" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">Work on UI design</div>
                            <div class="external-event bg-teal" id="drag5" draggable="true" ondragstart="drag(event)" ondragover="noAllowDrop(event)">Sleep tight</div> --}}
                          </div>
                        </div>
                          <!-- /.box-body -->
                        </div>
                        <?php $i++; ?>
                        {{-- @endif --}}
                      @endforeach




                    </div>
                    <!-- /.box-body -->
                  </div>

                  </div>
                </div>

              </div>

        </section>
      @else
        <section>

        </section>
      @endif

    </div>
  </div>
  <div class="modal fade" id="deskripsirev">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="box box-primary">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="deskripsirevisitugas"></h4>
            </div>
            <div class="modal-body">
              <!-- form -->
              <!-- form start -->
              <div class="box-body">
                <label>Keterangan Tugas</label><br>
                <p class="dk"></p>
                <p class="dd"></p>
                <p class="cf"></p>
                <p class="prgr"></p>
              </div>
              <div id="input_progress" class="box-body">

              <form class="form-horizontal">
                {{csrf_field()}}

                {{-- <input type="text" value="" class="slider form-control" data-slider-min="0" data-slider-max="100"
                         data-slider-step="5" data-slider-value="[0,0]" data-slider-orientation="horizontal"
                         data-slider-selection="before" data-slider-tooltip="show" data-slider-id="red"> --}}
                         <label>Masukan Progress</label><br>
                         <small class="pull-left">0%</small><small class="pull-right">100%</small>
                         <input type="range" min="0" max="100" value="" class="slider" id="myRange"><br>
                         <p>Ubah progress menjadi : <span id="demo"></span>%</p>
                         <input type="hidden" name="prgrs" value="">
                         <button type="button" class="btn btn-danger btn-flat " data-dismiss="modal">Batal</button>
                         <button id="submitprogres" type="button" class="btn btn-primary btn-flat ">Simpan progress</button>

                <!-- /.box-body -->
              </form>
            </div>
              <!--  -->
            </div>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

@endsection

@section('script2')
  <script>




    function allowDrop(ev) {
      ev.preventDefault();
    }

    function drop(ev) {
      ev.preventDefault();
      var id_aktivitas = ev.dataTransfer.getData("text");
      ev.target.appendChild(document.getElementById(id_aktivitas));
      var status = ev.target.id;
      var _token = $("input[name='_token']").val();
      console.log(id_aktivitas+ " ke "+ status);
      $.ajax({
        url : "/anggota/aktivitas/"+ id_aktivitas,
        type : 'PUT',
        data : {_token : _token, status : status},
        success : function(data) {
          console.log(data);
          if (data == 'sudah dikerjakan') {
            $("#descalertgagal").text('Status tugas sudah selesai')
            $(".gagal").fadeTo(2000, 500).slideUp(500, function(){
              $(".gagal").slideUp(500);
            });
          } else if (data == 'dari postpone') {
            $("#descalert").text('Tugas kembali dalam pengerjaan')
            $(".sukses").fadeTo(2000, 500).slideUp(500, function(){
              $(".sukses").slideUp(500);
            });
          } else if (data == 'dari tersedia') {
            $("#descalert").text('Tugas dalam pengerjaan')
            $(".sukses").fadeTo(2000, 500).slideUp(500, function(){
              $(".sukses").slideUp(500);
            });
          } else if (data == 'tugas selesai') {
            $("#descalert").text('Status tugas selesai')
            $(".sukses").fadeTo(2000, 500).slideUp(500, function(){
              $(".sukses").slideUp(500);
            });
          } else if (data == 'belum pernah dikerjakan') {
            $("#descalertgagal").text('Tugas belum dikerjakan')
            $(".gagal").fadeTo(2000, 500).slideUp(500, function(){
              $(".gagal").slideUp(500);
            });
          } else if (data == 'tugas postpone') {
            $("#descalert").text('Status tugas di tunda')
            $(".sukses").fadeTo(2000, 500).slideUp(500, function(){
              $(".sukses").slideUp(500);
            });
          }
        $(".kerjakan").load(' .kerjakan');
        $(".ada").load(' .ada');
        $(".postpone").load(' .postpone');
        $(".selesai").load(' .selesai');
        $('.collapsed-box').collapse('hide');
          // $(".daftar_project").load(location.href + ' .daftar_project');
        },
        error : function(response){
          console.log(response);
          var obj = response.responseJSON
          for (let i in obj) {
            showValidationErrors(i, obj[i][0]);
          }
          // associate_errors(erros, $form);
        }
      });

    }
    function drag(ev) {
      ev.dataTransfer.setData("text", ev.target.id);
      console.log(ev.target.id);
    }

    function noAllowDrop(ev) {
      ev.stopPropagation();
    }

    $(document).ready(function () {

    $(document).on('click', '.dskrps', function(e) {
      var deskripsi_revisi = $(this).find("input[name='deskripsi_revisi']").val();
      var nasub = $(this).find("input[name='nasub']").val();
      var duedate = $(this).find("input[name='duedate']").val();
      var konf = $(this).find("input[name='konfimass']").val();
      var stats = $(this).find("input[name='stat']").val();
      var progr = $(this).find("input[name='prog']").val();
      var id_aktivitas = $(this).attr('id');
      var ua =  $(this).find("input[name='ua']").val();
      var ed =  $(this).find("input[name='ed']").val();
      var ps =  $(this).find("input[name='ps']").val();
      console.log(id_aktivitas);
      $('#submitprogres').val(id_aktivitas);
      $('#input_progress').find("input[name='prgrs']").val(progr);
      $('#input_progress').find("#myRange").val(progr);
      $('#input_progress').find("#demo").text(progr);
      $('.dk').text(deskripsi_revisi);
      if (progr !== undefined) {
        if (ua !== undefined) {
          if (ua !== '') {
              $('.prgr').text('Progres saat ini: '+progr+'% diupdate pada : '+ua);
          }
        } else if (ed !== undefined){
          $('.prgr').text('Progres sudah '+progr+'% selesai pada : '+ed);
        } else if (ps !== undefined) {
          $('.prgr').text('Progres saat ini: '+progr+'% ditunda sejak : '+ps);
        }

      }

      if (duedate =='') {
          $('.dd').text('Batas tanggal tidak ditentukan');
      } else {
          $('.dd').text('Batas tanggal : '+duedate);
      }
      $('.cf').text(konf);
      if (stats == 'Dikerjakan') {
        // console.log("ini status "+stats);
        $("#input_progress").show();
      } else {
        $("#input_progress").hide();
      }


      console.log(duedate);
      $('#deskripsirevisitugas').text('Tugas '+nasub);
    });

    $(document).on('click', '#submitprogres', function(e) {
      var val = slider.value;
      var id_aktivitas = $(this).val();
      var curr_progres = $("input[name='prgrs']").val();
      var _token = $("input[name='_token']").val();
      console.log(val);
      if (curr_progres == val) {
        $("#deskripsirev").modal('hide');
        $("#descalertgagal").text('Tidak ada update progres')
        $(".gagal").fadeTo(2000, 500).slideUp(500, function(){
          $(".gagal").slideUp(500);
        });
      } else {
        $.ajax({
          url : "/anggota/aktivitas/editprogres/"+ id_aktivitas,
          type : 'PUT',
          data : {_token : _token, progress : val},
          success : function(data) {
            console.log(data);
          $(".kerjakan").load(' .kerjakan');
          $(".ada").load(' .ada');
          $(".postpone").load(' .postpone');
          $(".selesai").load(' .selesai');
          $('.collapsed-box').collapse('hide');
          $("#deskripsirev").modal('hide');
          $("#descalert").text('Update progres berhasil!')
          $(".sukses").fadeTo(2000, 500).slideUp(500, function(){
            $(".sukses").slideUp(500);
          });
            // $(".daftar_project").load(location.href + ' .daftar_project');
          },
          error : function(response){
            console.log(response);
            var obj = response.responseJSON
            for (let i in obj) {
              showValidationErrors(i, obj[i][0]);
            }
            // associate_errors(erros, $form);
          }
        });
      }

    });
    var slider = document.getElementById("myRange");
    var output = document.getElementById("demo");
    output.innerHTML = slider.value;

    slider.oninput = function() {
      output.innerHTML = this.value;
    }

})
  </script>

@endsection
