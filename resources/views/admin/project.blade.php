
@extends('Layouts.header-admin')

@section('title', 'Daftar Proyek')
<!-- =============================================== -->
@section('content')

  <div class="content-wrapper isi">

      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="row"  style="padding-bottom:0px;">
          <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8" style="padding-bottom:0px;">
            <h2 class="judul">
              Dashboard
              <small>proyek</small>

            </h2>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"  style="padding-bottom:0px;">
            <br>
            {{-- <ol class="breadcrumb pull-right" style="background-color:transparent; margin-bottom:0px;">
              <li style="font-size:10pt;" class="pull-right"><a href="#" id="buttonedit" data-toggle="modal" data-target="#tambahdengankode"><i class="fa fa-plus"></i> Tambah proyek menggunakan kode</a></li>
            </ol> --}}

          </div>
        </div>
      </section>

      <!-- Main content -->
      <section class="content" style="padding-top:0px;" >

          <div class="alert alert-success" style="display: none;">
            <h4><i class="icon fa fa-check"></i> Sukses!</h4>

            <p id="descalert">  Proyek Berhasil ditambahkan.</p>
          </div>
          <div class="box box-default" style="background-color:rgba(255,255,255, 0.6);">
            <div class="box-body">
            <div class="proyekbox">
              <br>
              <div class="row">
                <div class="daftar_project">
                  <div class="col-md-3">
                    <button id="tambah_proyek" type="button" class="btn  btn-proyek btn-block btn-modal btn-lg btn-flat"  data-toggle="modal" data-target="#buat-proyek">
                      <i class="fa fa-plus"></i><br>
                      Tambah Project
                    </button>
                  </div>
                  @foreach ($projects as $projects)
                    <div class="col-md-3">
                      <a href="{{route('project.select', ['id_project' => $projects -> id_project ])}}">
                        <button type="button" class="btn  btn-proyek btn-block  btn-primary btn-lg btn-flat" >
                          {{ $projects -> nama_project }}
                        </button>
                      </a>
                    </div>
                  @endforeach
                </div>




              </div>
            </div>
          </div>
            <!-- /.box -->
          </div>

          <!-- /.col -->

      </section>

    <!-- /.content -->
  </div>

  <!--modal-->
  <div class="modal fade" id="buat-proyek">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="box box-primary">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Buat Project Baru</h4>
            </div>
            <form class="form-horizontal" id="form-project" method="POST" action="{{ route('project.create') }}">
              <div class="modal-body">
                <!-- form -->
                <!-- form start -->

                {{ csrf_field() }}
                <div class="box-body">
                  <div class="form-group" id="form-group-nama_project">
                    <label>Nama Proyek</label>
                    <input id="nama_project" type="text" class="form-control" placeholder="Nama Proyek" name="nama_project" value="" required>
                    <span class="help-block"></span>
                  </div>
                  <div class="form-group" id="form-group-nama_penanggungjawab">
                    <label>Nama Penanggungjawab</label>
                    <input id="nama_penanggungjawab" type="text" class="form-control" placeholder="Nama Penanggungjawab" name="nama_penanggungjawab" value="{{ Auth::user()->name }}" required disabled>
                    <span class="help-block"></span>
                  </div>
                  <div class="form-group">
                  </div>
                </div>
                <!-- /.box-body -->
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-flat btn-danger pull-left" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-flat btn-success pull-left" data-dismiss="modal" data-toggle="modal" data-target="#tambahdengankode">Tambah Dengan Kode</button>
                <button type="button" id="submit_proyek" class="btn btn-flat btn-primary">Simpan</button>
              </div>
            </form>
            <!--  -->


          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>


  <div class="modal fade" id="tambahdengankode">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="box box-primary">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Tambah Proyek Dengan Kode</h4>
            </div>
            <form class="form-horizontal" >
              <div class="modal-body">
                <!-- form -->
                <!-- form start -->

                {{ csrf_field() }}
                <div class="box-body">
                  <div class="form-group" id="form-group-kode_project">
                    <label>Masukkan Kode Proyek</label>
                    <input id="kode_project" type="text" class="form-control" placeholder="Kode Proyek" name="kode_project" value="" required>
                    <span class="help-block"></span>
                  </div>
                </div>
                <!-- /.box-body -->
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-flat btn-danger pull-left" data-dismiss="modal">Batal</button>
                <button type="button" id="submit_kodeproyek" class="btn btn-flat btn-primary">Tambah</button>
              </div>
            </form>
            <!--  -->


          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

  @endsection
  @section('script')
    <script>
    $(document).ready(function() {
      $("#submit_proyek").click(function(e) {
        e.preventDefault();
        var _token = $("input[name='_token']").val();
        var nama_project = $("input[name='nama_project']").val();
        var nama_penanggungjawab = $("input[name = 'nama_penanggungjawab']").val();
        if (nama_project == '') {
          showValidationErrors('nama_project', 'Nama proyek harus diisi');
        } else {
          $.ajax({
            url : "{{ route('project.create') }}",
            type : 'POST',
            data : {_token : _token, nama_project : nama_project, nama_penanggungjawab : nama_penanggungjawab},
            success : function(data) {
              console.log(data);
              $("#buat-proyek").modal('hide');
              $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                $(".alert").slideUp(500);
              });
              $(".daftar_project").load(location.href + ' .daftar_project');
            },
            error : function(response){
              console.log(response.responseJSON);
              var obj = response.responseJSON
              for (let i in obj) {
                showValidationErrors(i, obj[i][0]);
              }
              if (response.status == 500) {
                showValidationErrors('nama_project', 'Nama proyek sudah ada')
              }
            }
          });
        }
      });

      $("#submit_kodeproyek").click(function(e) {
        e.preventDefault();
        var _token = $("input[name='_token']").val();
        var kode_project = $("input[name='kode_project']").val();
        var id = '{{ Auth::id() }}';
        if (kode_project == '') {
          showValidationErrors('kode_project', 'Kode proyek harus diisi');
        } else {
          $.ajax({
            url : "{{ route('project.addkode') }}",
            type : 'POST',
            data : {_token : _token, kode_project : kode_project, id_admin : id},
            success : function(data) {
              console.log(data);
              if (data == 'already in') {
                $("#descalert").text('Anda sudah masuk');
                $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                  $(".alert").slideUp(500);
                });
                $("#tambahdengankode").modal('hide');
              } else {
                $("#tambahdengankode").modal('hide');
                $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                  $(".alert").slideUp(500);
                });
                $(".daftar_project").load(location.href + ' .daftar_project');
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

      function showValidationErrors(name, error) {
        var group = $("#form-group-" + name);
        group.addClass('has-error');
        group.find('.help-block').text(error);
      }

      function clearValidationError(name) {
        var group = $("#form-group-" + name);
        group.removeClass('has-error');
        group.find('.help-block').text('');
      }
      $("#nama_project, #nama_penanggungjawab, #kode_project").on('keyup', function () {
        clearValidationError($(this).attr('id').replace('#', ''))
      });

      $(document).on('click', '#tambah_proyek', function(event) {
        $('#nama_project').val("");
        $('#kode_project').val("");
        clearValidationError($('#nama_project').attr('id').replace('#', ''));
        clearValidationError($('#kode_project').attr('id').replace('#', ''));
      })

    });
    </script>
  @endsection
