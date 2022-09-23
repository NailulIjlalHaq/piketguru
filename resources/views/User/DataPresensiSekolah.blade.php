@extends('User.Layouts.Master')
@section('content')
  <script>
    @if (session('success'))
    swal({
      title   : "Berhasil",
      text    : "{{session('success')}}",
      icon    : "success",
    })
    @endif
  </script>
  <section>
    <!-- Page content-->
    <div class="content-wrapper">
      <h3>
        @section('title')
          {{$Title = 'Data Presensi Sekolah'}}
        @endsection
        {{$Title}}
        <small>{{$Sekolah->nama_sekolah}}</small>
      </h3>
        <div class="row">
          <div class="col-lg-12">

            <div class="well well-sm">
              <div class="panel-heading">
                <a href="/input-presensi-sekolah">
                  <button class="btn btn-labeled btn-info" type="button">
                    <span class="btn-label"><i class="fa fa-plus"></i>
                  </span><b>Tambah Data</b></button>
                </a>
              </div>
              <div class="panel-body">
                <div class="table-responsive no-padding">
                  <table class="table table-striped table-bordered table-hover tabel-data-custom" id="datatable2">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th style="width:25%;">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                        $no = 0;
                        $DumpTanggal = '01012011';
                      @endphp
                      @foreach ($Absensi as $DataAbsensi)
                        @if ($DumpTanggal != $DataAbsensi->tanggal)
                          @php
                            $DumpTanggal = $DataAbsensi->tanggal;
                          @endphp
                          <tr>
                            <td>{{$no+=1}}</td>
                            <td>{{Carbon\Carbon::parse($DataAbsensi->tanggal)->format('d-m-Y')}}</td>
                            <td>
                              <button class="btn btn-labeled btn-primary btn-xs" type="button" onclick="Info('{{Crypt::encryptString(Auth::user()->sekolah_id)}}','{{Crypt::encryptString($DataAbsensi->tanggal)}}')">
                              <span class="btn-label"><i class="fa fa-info"></i>
                              </span><b>Detail</b></button>
                            </td>
                          </tr>
                        @endif
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>
        </div>
     </div>
  </section>
@endsection
@section('bawahan')
  <script>
  function Info(idSekolah,tanggal)
  {
    window.location = "/data-presensi-sekolah/"+idSekolah+"/"+tanggal;
  }
</script>
@endsection
