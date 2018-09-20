@extends('Layouts.header-anggota')
@section('title', 'Semua Pemberitahuan')
<!-- =============================================== -->
@section('content')


      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper isi">

        <section class="content">
          @if(session()->has('message'))
            <div class="alert alert-success hapus">
              <h4><i class="icon fa fa-check"></i> Sukses!</h4>
              <p>{{ session()->get('message') }}</p>
            </div>
          @endif

          <!-- /.box -->
          <div class="box box-solid box-success">
            <div class="box-header ">
              <h3 class="box-title"><i class="fa fa-globe"></i> Pemberitahuan</h3>
            </div>
            <!-- /.box-header -->
            <div id="notifull" class="box-body table-responsive no-padding">
              <br>
              <notificationfull :notificationss="{{ json_encode($notifications) }}"></notificationfull>
              {{-- <table class="table table-striped">
                @foreach ($notifications as $notification)
                  <tr>

                    <td style="width: 15px"><i class="fa fa-circle-o"></i></td>
                    <td class="isi">{{ $notification['data']['data']['text'] }}
                      <input type="hidden" class="type" value="{{ $notification['data']['data']['type']}}">
                      <input type="hidden" class="idnotif" value="{{ $notification['id']}}">
                    </td>
                    <td style="width: 170px"> few minutes ago</td>

                  </tr>

                @endforeach
              </table> --}}
            </div>
            <!-- /.box-body -->
          </div>
        </section>

        <!-- /.content -->
      </div>


@endsection
@push('script')
  <script type="text/javascript" src="{{ asset('js/notifull.js') }}" rel="javascript"></script>
@endpush
@section('script')
  <script>
    $(document).ready(function () {
      $(".hapus").fadeTo(2000, 500).slideUp(500, function(){
        $(".hapus").slideUp(500);
      });
    });
  </script>
@endsection
