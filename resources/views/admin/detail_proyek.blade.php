
@extends('Layouts.header-admin')

@section('title', 'Detail Proyek')
<!-- =============================================== -->
@section('content')


      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper isi">
        <!-- Content Header (Page header) -->
        <section class="content-header" style="margin-bottom : 0px;">
          <div class="row"  style="padding-bottom:0px;">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8" style="padding-bottom:0px;">
              <h3>
                Detail Proyek
              </h3>
            </div>
          </div>
        </section>

        <!-- Main content -->
        <section class="content" style="padding-top : 0px">
          <div class="alert alert-success" style="display: none;">
            <h4><i class="icon fa fa-check"></i> Sukses!</h4>
            Admin berhasil dihapus.
          </div>
          <div class="box box-primary">
            <div class="box-header">
            <h3 class="box-title">Daftar Admin Proyek</h3>
            </div>
            <div class="box-body">
              <div class="box-body no-padding">
                <br>
                <div class="listadmin">


              <table class="table table-striped">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Nama Admin</th>
                  <th>Alamat Email</th>
                  <th>Tanggal Bergabung</th>
                  @if ($enable == true)
                    <th>Aksi</th>
                  @endif
                </tr>
                {{ csrf_field() }}
                <?php $i = 1; ?>
                @foreach ($adminlist as $admins)

                  <tr>
                    <td>{{$i}}.</td>
                    <td>{{ $admins -> name}}</td>
                    <td>
                      {{ $admins -> email}}
                    </td>
                    <td>{{$admins -> tglgabung}}</td>
                    @if ($enable == true)
                      <td ><button type="button" id="{{ $admins -> id_admin}}" class="btn btn-danger btn-flat idadmin" data-toggle="modal" data-target="#verifikasi"><i class="fa fa-trash-o"></i></button></td>
                    @endif
                  </tr>
                  <?php $i++; ?>
                @endforeach
              </table>
              </div>
            </div>
            </div>

          </div>
          <!-- /.box -->

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
                  <strong>Apakah anda yakin melakukan penghapusan admin?</strong>
                  <!--  -->
                </div>
                <form id="formdelete">
                  {{csrf_field()}}
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat " data-dismiss="modal">Tidak</button>
                    <button type="button" name="submit" class="btn btn-default btn-flat deleteadmin">Ya</button>
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
  <script>
    $(document).ready(function () {
      $(document).on('click', '.deleteadmin', function(event) {
        var _token = $("input[name='_token']").val();
        var id = $('.idadmin').attr('id');
        var id_project = "{{ $id_project}}";
        $.ajax({
          url : "{{route('project.admin.delete')}}",
          type : 'DELETE',
          data : {_token : _token, id_project : id_project, id_admin : id},
          success : function(data) {


            $(".alert").fadeTo(2000, 500).slideUp(500, function(){
              $(".alert").slideUp(500);
            });
            $("#verifikasi").modal('hide');

            $(".listadmin").load(location.href + ' .listadmin');
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
      })
    })

  </script>

@endsection
