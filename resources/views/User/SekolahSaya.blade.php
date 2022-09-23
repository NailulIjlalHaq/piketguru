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
          {{$Title = 'Data Sekolah Saya'}}
        @endsection
        {{$Title}}
      </h3>
      <div class="row">
        <div class="col-lg-12">
          <div class="well well-sm">
            <div class="panel-heading">
              <a href="/sekolah-saya/edit">
                <button class="btn btn-labeled btn-info" type="button">
                  <span class="btn-label"><i class="fa fa-pencil"></i>
                </span><b>Edit Data Sekolah</b></button>
              </a>
            </div>
            <div class="panel-body">
              <div class="table-responsive">
                <table class="table">
                  <tbody>
                    <tr>
                      <td>NPSN</td>
                      <td>{{$Sekolah->npsn}}</td>
                    </tr>
                    <tr>
                      <td>NSS</td>
                      <td>{{$Sekolah->nss}}</td>
                    </tr>
                    <tr>
                      <td>Nama Sekolah</td>
                      <td>{{$Sekolah->nama_sekolah}}</td>
                    </tr>
                    <tr>
                      <td>Kepala Sekolah</td>
                      <td>{{$Sekolah->pegawai_id != 0 ? $Sekolah->Pegawai->nama : '-'}}</td>
                    </tr>
                    <tr>
                      <td>Jenjang</td>
                      <td>{{$Sekolah->Jenjang->nama_jenjang}}</td>
                    </tr>
                    <tr>
                      <td>Status</td>
                      <td>{{$Sekolah->Status->nama_status}}</td>
                    </tr>
                    <tr>
                      <td>Kecamatan</td>
                      <td>{{$Sekolah->Kecamatan->nama_kecamatan}}</td>
                    </tr>
                    <tr>
                      <td>Kelurahan</td>
                      <td>{{$Sekolah->Kelurahan->nama_kelurahan}}</td>
                    </tr>
                    <tr>
                       <td>Alamat</td>
                       <td>{{$Sekolah->alamat}}</td>
                    </tr>
                    <tr>
                      <td>Nomor Telepon</td>
                      <td>{{$Sekolah->no_telepon}}</td>
                    </tr>
                    <tr>
                      <td>E-Mail</td>
                      <td>{{$Sekolah->email}}</td>
                    </tr>
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
