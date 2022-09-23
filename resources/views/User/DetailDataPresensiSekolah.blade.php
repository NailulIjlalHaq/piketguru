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
          {{$Title = 'Detail Presensi Sekolah'}}
        @endsection
        {{$Title}}
      </h3>
        <div class="row">
          <div class="col-lg-12">

            <div class="well well-sm">
              <div class="panel-body">
                <div class="table-responsive no-padding">
                  <table class="table table-striped table-bordered table-hover tabel-data-custom">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Nama Pegawai</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                        <th>Absensi</th>
                        <th>Keterangan</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                        $no = 0;
                      @endphp
                        @foreach ($Absensi as $DataAbsensi)
                          @if ($DataAbsensi->Pegawai != null)
                            <tr>
                              <td>{{$no+=1}}</td>
                              <td>{{$DataAbsensi->Pegawai->nama}}</td>
                              <td>{{$DataAbsensi->jam_masuk != null ? $DataAbsensi->jam_masuk : '-'}}</td>
                              <td>{{$DataAbsensi->jam_pulang != null ? $DataAbsensi->jam_pulang : '-'}}</td>
                              <td>
                                <div class="text-center">
                                  <div class="pull label" style="background-color:{{$DataAbsensi->KategoriAbsen->kode_warna}};">
                                    {{$DataAbsensi->KategoriAbsen->keterangan}}
                                  </div>
                                </div>
                              </td>
                              <td>{{$DataAbsensi->keterangan}}</td>
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
