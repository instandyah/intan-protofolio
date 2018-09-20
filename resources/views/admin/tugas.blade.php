
@extends('Layouts.header-admin')

@section('title', 'Dashboard Tugas')
<!-- =============================================== -->
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper isi">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row"  style="padding-bottom:0px;">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8" style="padding-bottom:0px;">
          <h2 class="judul">
            Tugas <small>{{ $tugas -> nama_tugas}}</small>
          </h2>

        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content" style="padding-top:0px;">
      <div class="alert alert-success" style="display: none;">
        <h4><i class="icon fa fa-check"></i> Sukses!</h4>
        <p id="descalert">Proyek Berhasil ditambahkan.</p>
      </div>
      @if(session()->has('message'))
        <div class="alert alert-success hapus">
          <h4><i class="icon fa fa-check"></i> Sukses!</h4>
          <p>{{ session()->get('message') }}</p>
        </div>
      @endif
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
            <div id="pjpj" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
              @if ($realpj == true)
                @if ($tugas -> Pj == null)
                  <p style="font-size:13px; color:#777" class="pull-left">Penanggung jawab: <a a style="cursor : pointer;" data-toggle="modal" data-target="#Edit-PJ-anggota">Belum ditentukan</a></p>
                @else
                  <p style="font-size:13px; color:#777" class="pull-left">Penanggung jawab: <a id="editedit" a style="cursor : pointer;" data-toggle="modal" data-target="#Edit-PJ-anggota">{{$tugas -> name}}</a></p>
                @endif

              @else
                @if ($tugas -> Pj == null)
                  <p style="font-size:13px; color:#777" class="pull-left">Penanggung jawab: Belum ditentukan</p>
                @else
                  <p style="font-size:13px; color:#777" class="pull-left">Penanggung jawab: {{$tugas -> name}}</p>
                @endif

              @endif

              <p style="font-size:13px; color:#777" class="pull-right">Dibuat oleh: {{ $tugas -> dibuat_oleh}}, {{$tugas -> created_at}}</p>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
              @if ($realpj == true || $tugas -> name == Auth::user() -> name)
                  <button id="buttonedit" type="button" class="btn btn-primary btn-flat pull-right" data-toggle="modal" data-target="#Edit-tugas"> <i class="fa fa-edit"></i> Edit Tugas</button>
              @endif
            </div>
          </div>
          <div class="row">

            {{-- @if ($enable == true) --}}
                <div class="col-md-6">
            {{-- @else
              <div class="col-md-12">
            @endif --}}

              <div class="box box-solid">

                <div class="box-header with-border">
                  <h4 class="box-title">Daftar Sub Tugas</h4>
                </div>
                <div class="box-body">
                  <!-- the events -->
                  <div id="external-events">
                    <div class="subtugas">
                      @foreach ($subtugas as $subtugasnampilin)
                        <div id="{{ $subtugasnampilin -> id_subtugas}}" class="external-event bg-teal subtugasklik" data-toggle="modal" data-target="#Edit-subtugas" style="cursor:pointer">{{ $subtugasnampilin -> nama_subtugas}}
                          <input type="hidden" id="selectedbobot" name="" value="{{ $subtugasnampilin -> bobot }}">
                          {{-- <input type="hidden" id="selectedurutan" name="" value="{{ $subtugasnampilin -> dikerjakan_setelah }}"> --}}
                        </div>
                      @endforeach
                    </div>
                  </div>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /. box -->
            </div>
            @if ($realpj == true || $tugas -> name == Auth::user() -> name)
              <div class="col-md-6">
                <div class="box box-solid">
                  <div class="box-header with-border">
                    <h3 class="box-title">Tambah Sub Tugas</h3>
                  </div>
                  <div class="box-body">

                    <!-- /btn-group -->
                    <div id="subtugasvalidasi" class="form-group-group">
                      <label>Nama Sub Tugas</label>
                      <input id="nama_subtugas" name="nama_subtugas" value="{{ old('nama_subtugas') }}" type="text" class="form-control" placeholder="Nama Sub Tugas" required>
                      {{ csrf_field() }}
                    </div>
                    <span id="validasisubtugas" class="help-block has-error" style="color : #a94442;"></span>

                    <div class="row">
                      <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="form-group">
                          <label>Bobot Kesulitan Sub Tugas</label>
                          <select id="opsibobot" class="form-control select2" style="width: 100%;">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                            <option>6</option>
                            <option>7</option>
                            <option>8</option>
                            <option>9</option>
                            <option>10</option>
                          </select>
                        </div>
                      </div>
                      {{-- <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="form-group">

                          <label>Prioritas</label>
                          <input type="hidden" id="opsieditval1" value="">
                          <select id="opsiurutan" class="form-control select2" style="width: 100%;">

                            <option value="default">Prioritas</option>
                            @for ($i = 1; $i <= count($subtugas) + 1; $i++)
                              <option>{{$i}}</option>
                            @endfor

                        </select>
                      </div>
                    </div> --}}
                  </div>
                  <br>
                  <div class="form-group-btn">
                    <button id="submit_subtugas" type="button" class="btn btn-primary btn-flat  pull-right">Tambah</button>
                    <button id="bataltambah" type="button" class="btn btn-danger btn-flat">Batal</button>
                  </div>
                  <!-- /input-group -->
                  <br>


                </div>
              </div>
            </div>
            @endif

        </div>
        <!-- /.row -->
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<div class="modal fade" id="Edit-subtugas">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="box box-primary">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Sunting Sub Tugas</h4>
          </div>
          <form class="form-horizontal">
            {{ csrf_field() }}
            <div class="modal-body" style="padding-bottom : 0px;">
              <!-- form -->
              <!-- form start -->

              <div class="box-body">
                @if ($realpj == true || $tugas -> name == Auth::user() -> name)
                  <div class="form-group" id="form-group-nama_subtugasedit">
                    <label>Nama Sub Tugas</label>
                    <input name="nama_subtugasedit" id="nama_subtugasedit" value="" type="text" class="form-control" placeholder="Nama Sub Tugas">
                    <span class="help-block"></span>
                  </div>
                  <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                      <div class="form-group">
                        <label>Bobot Kesulitan Sub Tugas</label>
                        <select id="opsibobotedit" class="form-control select2" style="width: 100%;">
                          <option>1</option>
                          <option>2</option>
                          <option>3</option>
                          <option>4</option>
                          <option>5</option>
                          <option>6</option>
                          <option>7</option>
                          <option>8</option>
                          <option>9</option>
                          <option>10</option>
                        </select>
                      </div>
                    </div>
                </div>
                @else
                  <div class="form-group">
                    <label>Nama Sub Tugas :</label> <p id="nst"></p>
                    <label>Bobot :</label> <p id="bst"></p>
                  </div>
                @endif


            </div>
            <!-- /.box-body -->

            <!--  -->
          </div>
          <div class="modal-footer">
            @if ($realpj == true || $tugas -> name == Auth::user() -> name)
              <button type="button" id="deletesubtugas" class="btn btn-danger btn-flat pull-left" data-dismiss="modal" data-toggle="modal" data-target="#verifikasi">Hapus Sub Tugas</button>
              <button type="button" class="btn btn-danger  btn-flat" data-dismiss="modal">Batal</button>
              <button id="submit_subtugas_edit" type="button" class="btn btn-primary  btn-flat">Simpan Perubahan</button>
            @else
              <button type="button" class="btn btn-primary  btn-flat" data-dismiss="modal">Ok</button>
            @endif

          </div>
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="Edit-PJ-anggota">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="box box-primary">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Penanggung jawab anggota</h4>
          </div>
          <form class="form-horizontal" method="POST" action="">
            {{ csrf_field() }}
            <div class="modal-body">
              <!-- form -->
              <!-- form start -->
              <div class="formeditproyek">
                <div class="box-body">
                  <div class="form-group " id="nama_penanggungjawab">
                    <label>Pilih Penanggungjawab</label>
                      <select id="penanggungjawabanggota" class="form-control selectpjproyek" style="width: 100%;">
                        @foreach ($listadmins as $admins)
                          <option>{{ $admins -> name}}</option>
                        @endforeach
                      </select>

                  </div>
                </div>
              </div>

              <!-- /.box-body -->
              <!--  -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-flat btn-danger" data-dismiss="modal">Batal</button>
              <button type="button" id="submit_proyek" name="submit" class="btn btn-flat btn-primary">Simpan Perubahan</button>
            </div>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

<div class="modal fade" id="Edit-tugas">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="box box-primary">
        <form class="form-horizontal">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Sunting Tugas {{$tugas -> nama_tugas}}</h4>
            </div>
            <div class="modal-body">
              <!-- form -->
              <!-- form start -->
              <div class="formedittugas">
              <div class="box-body">
                <div class="form-group" id="form-group-nama_tugas">
                  <label>Nama Tugas</label>
                  <input id="nama_tugas" name="nama_tugas" type="text" class="form-control" placeholder="Nama Tugas" value="{{ $tugas -> nama_tugas }}">
                  <span class="help-block"></span>
                </div>
                <div class="form-group">
                  <input type="hidden" name="_method" value="PUT">
                </div>
              </div>
            </div>
              <!-- /.box-body -->

              <!--  -->
            </div>
            <div class="modal-footer">
              <button type="button" id="deletetugas" class="btn btn-danger btn-flat pull-left" data-dismiss="modal" data-toggle="modal" data-target="#verifikasi">Hapus Tugas</button>
              <button type="button" class="btn btn-danger btn-flat " data-dismiss="modal">Batal</button>
              <button type="button" id="submit_tugas" class="btn btn-primary btn-flat ">Simpan Perubahan</button>
            </div>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

  <!--modal-->
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
              @if ($realpj == true)
                  <p id="desc">Sekali melakukan penghapusan maka anda tidak dapat mengembalikan tugas yang sudah dihapus</p>
              @else
                <p id="desc">Kirimkan permintaan hapus tugas pada penanggung jawab terkait?</p>
              @endif

              <!--  -->
            </div>
            <form id="formdelete" action="{{route('tugas.delete', ['id_tugas' => $tugas -> id_tugas ])}}" method="POST">
              {{csrf_field()}}
              <div class="modal-footer">
                {{-- <input type="hidden" name="id_tugas" value="{{ $tugas -> id_tugas }}"> --}}
                <button type="button" class="btn btn-default btn-flat " data-dismiss="modal">Tidak</button>
                <button id="submitdeletetugas" type="submit" name="submit" class="btn btn-default btn-flat ">Ya</button>
                <button id="submitdelete" type="button" class="btn btn-default btn-flat " style="display:none;">Ya</button>
                {{-- <input type="hidden" name="_method" value="DELETE"> --}}
              </div>
            </form>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

  @endsection

  @section('script')

    <!-- Page specific script -->
    <script>
    $(document).ready(function () {

      $(".hapus").fadeTo(2000, 500).slideUp(500, function(){
        $(".hapus").slideUp(500);
      });

      $(document).on('click', '.subtugasklik', function(event) {
        var text = $.trim($(this).text());
        var id = $(this).attr('id');
        var selected = $(this).find('#selectedbobot').val();

        $('#nst').text(text);
        $('#bst').text(selected);
        $('#deletesubtugas').val(id);
        $('#nama_subtugasedit').val(text);
        $('#submit_subtugas_edit').val(id);
        // $('#opsieditval1').val(editopsi1);

        $('#opsibobotedit > option').each(function(){
          if($(this).text()==selected) $(this).parent('select').val($(this).val())
        })
        clearValidationError($('#nama_subtugasedit').attr('id').replace('#', ''));
        console.log(id);
        // console.log(editopsi1);

      })

      $("#submit_subtugas_edit").click(function(e) {
        e.preventDefault();
        var _token = $("input[name='_token']").val();
        // var text = $('#opsieditval1').val();

        var nama_subtugasedit = $("input[name='nama_subtugasedit']").val();;
        var id =   $('#submit_subtugas_edit').val();
        var bobot = $('#opsibobotedit').find(":selected").text();

        if (nama_subtugasedit == '') {
          showValidationErrors('nama_subtugasedit', 'Nama sub tugas harus diisi');
        } else {
          $.ajax({
            url : "{{route('subtugas.edit')}}",
            type : 'PUT',
            data : {_token : _token, nama_subtugasedit : nama_subtugasedit, id_subtugas : id, bobot : bobot},
            success : function(data) {
              console.log(data);
              $("#descalert").text('Perubahan data sub tugas berhasil disimpan.');
              $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                $(".alert").slideUp(500);
              });
              $("#Edit-subtugas").modal('hide');
              $(".subtugas").load(location.href + ' .subtugas');
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

      $(document).on('click', '#deletesubtugas', function()
      {
        var id = $('#deletesubtugas').val();
        $("#submitdelete").show();
        $("#submitdelete").val(id);
        $("#submitdeletetugas").hide();
        $("#desc").text('Sekali melakukan penghapusan maka anda tidak dapat mengembalikan subtugas yang sudah dihapus')
        $("#Edit-subtugas").modal('hide');
      });

      $("#submitdelete").click(function(e) {
        var _token = $("input[name='_token']").val();
        var id_subtugas = $(this).val();
        // var text = $('#opsieditval1').val();
        console.log(id_subtugas);
        // console.log(text);
        $.ajax({
          url : '/project/tugas/subtugas/'+ id_subtugas,
          type : 'DELETE',
          data : {_token : _token},
          success : function(data) {
            console.log(data);
            $("#descalert").text('Penghapusan sub tugas berhasil.');
            $(".alert").fadeTo(2000, 500).slideUp(500, function(){
              $(".alert").slideUp(500);
            });
            $("#verifikasi").modal('hide');
            $(".subtugas").load(location.href + ' .subtugas');
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
      });

      $(document).on('click', '#deletetugas', function()
      {
        // $("#desc").text('Sekali melakukan penghapusan maka anda tidak dapat mengembalikan tugas yang sudah dihapus')
        $("#submitdelete").hide();
        $("#submitdeletetugas").show();
      });

      $(document).on('click', '#buttonedit', function()
      {
        // $('#verifikasidelete').find('#formdelete').attr('action', '');
        clearValidationError($('#nama_tugas').attr('id').replace('#', ''))
      });


      $("#submit_tugas").click(function(e) {
        e.preventDefault();
        var _token = $("input[name='_token']").val();
        var nama_tugas = $("input[name='nama_tugas']").val();
        if (nama_tugas == '') {
          showValidationErrors('nama_tugas', 'Nama tugas harus diisi');
        } else {
          $.ajax({
            url : "{{route('tugas.edit', ['id_tugas' => $tugas -> id_tugas ])}}",
            type : 'PUT',
            data : {_token : _token, nama_tugas : nama_tugas},
            success : function(data) {
              if (data.jenis) {
                  console.log('ini permintaan edit');
                  $("#descalert").text('Permintaan edit berhasil dikirim ke '+data.admin);
                  $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                    $(".alert").slideUp(500);
                  });
                  $("#Edit-tugas").modal('hide');

              } else {
                console.log(data);
                $("#descalert").text('Perubahan data tugas berhasil disimpan.');
                $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                  $(".alert").slideUp(500);
                });
                $("#Edit-tugas").modal('hide');

                $(".judul").load(location.href + ' .judul');
              }
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

      $("#Edit-tugas").on('hidden.bs.modal', function() {
        $(".formedittugas").load(location.href + ' .formedittugas');
      })

      $("#submit_subtugas").click(function(e) {
        e.preventDefault();
        var _token = $("input[name='_token']").val();
        var nama_subtugas = $("input[name='nama_subtugas']").val();
        var bobot = $('#opsibobot').find(":selected").text();

        if (nama_subtugas == '') {
          showValidationErrors('nama_subtugas', 'Nama subtugas harus diisi');
        } else {
          $.ajax({
            url : "{{route('subtugas.create', ['id_tugas' => $tugas -> id_tugas ])}}",
            type : 'POST',
            data : {_token : _token, nama_subtugas : nama_subtugas, bobot : bobot},
            success : function(data) {
              console.log(data);
              $("#descalert").text('Sub tugas berhasil ditambahkan.');
              $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                $(".alert").slideUp(500);
              });
              $('#nama_subtugas').val("");
              $(".subtugas").load(location.href + ' .subtugas');

              $('#opsibobot > option').each(function(){
                if($(this).text()=='1') $(this).parent('select').val($(this).val())
              });

            },
            error : function(response){
              console.log(response);
              var obj = response.responseJSON
              for (let i in obj) {
                showValidationErrors(i, obj[i][0]);
              }
            }
          });
        }
      });

      $(document).on('click', '#editedit', function(e) {
        var selected = $(this).text();
        $('#penanggungjawabanggota > option').each(function(){
          if($(this).text()==selected) $(this).parent('select').val($(this).val())
        })
        console.log(selected);
      });

      $(document).on('click', '#submit_proyek', function(e) {
        e.preventDefault();
        var _token = $("input[name='_token']").val();
        var selected = $('#nama_penanggungjawab').find(":selected").text();;

        console.log(selected);
        $.ajax({
          url : "{{route('tugas.editpj', ['id_tugas' => $tugas -> id_tugas])}}",
          type : 'PUT',
          data : {_token : _token, penanggungjawab : selected, id_tugas : {{$tugas -> id_tugas}}},
          success : function(data) {
            console.log(data);
            $("#descalert").text('Penanggung jawab tugas berhasil diubah')
            $(".alert").fadeTo(2000, 500).slideUp(500, function(){
              $(".alert").slideUp(500);
            });
            $("#Edit-PJ-anggota").modal('hide');
            $("#pjpj").load(location.href + ' #pjpj');

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
      });

      $('#bataltambah').click(function(e) {
        $('#nama_subtugas').val("");
        $('#opsibobot > option').each(function(){
          if($(this).text()=='1') $(this).parent('select').val($(this).val())
        });
        // $('#opsiurutan > option').each(function(){
        //   if($(this).text()=='Prioritas') $(this).parent('select').val($(this).val())
        // });
        clearValidationError('nama_subtugas')
      });

      function showValidationErrors(name, error) {
        if (name == 'nama_subtugas') {
          var group = $("#subtugasvalidasi");
          group.addClass('has-error');
          $('#validasisubtugas').text(error);
        } else {
          var group = $("#form-group-" + name);
          group.addClass('has-error');
          group.find('.help-block').text(error);
        }

      }

      function clearValidationError(name) {
        if (name == 'nama_subtugas') {
          var group = $("#subtugasvalidasi");
          group.removeClass('has-error');
          $('#validasisubtugas').text('');
        } else {
          var group = $("#form-group-" + name);
          group.removeClass('has-error');
          group.find('.help-block').text('');
        }

      }
      $("#nama_subtugas").on('keyup', function () {
        clearValidationError('nama_subtugas')
      });

      $("#nama_tugas, #nama_subtugasedit").on('keyup', function () {
        clearValidationError($(this).attr('id').replace('#', ''))
      });


    })
    </script>
  @endsection
