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
          {{$Title = 'Data Sekolah'}}
        @endsection
        {{$Title}}
        <small>{{$Sekolah->nama_sekolah}}</small>
      </h3>
        <div class="row">
          <div class="col-lg-12">

            <div class="panel well">
              <button class="btn btn-labeled btn-info" type="button" onclick="Ubah('{{Crypt::encryptString($Sekolah->id)}}', '{{$Sekolah->nama}}')">
                <span class="btn-label"><i class="fa fa-pencil"></i>
              </span><b>Edit Data Sekolah</b></button>
              <div class="panel-body">
                <div class="table-responsive">
                  <table class="table table-hover">
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
                         <td>{{$Sekolah->Pegawai->nama}}</td>
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
                         <td>Kelurahan</td>
                         <td>{{$Sekolah->Kelurahan->nama_kelurahan}}</td>
                      </tr>
                      <tr>
                         <td>Nomor Telepon</td>
                         <td>{{$Sekolah->no_telepon}}</td>
                      </tr>
                      <tr>
                         <td>E-Mail</td>
                         <td>{{$Sekolah->email}}</td>
                      </tr>
                      <tr>
                         <td>Jumlah Pegawai</td>
                         <td>{{count($Sekolah->AllPegawai)}} Orang</td>
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
<script>
  function Ubah(id,Nama)
  {
    swal({
      title   : "Ubah",
      text    : "Anda Akan di Arahkan ke Halaman Ubah Data Kelurahan '"+Nama+"'",
      icon    : "info",
    })
    window.location = "/data-sekolah/"+id+"/edit";
  }

  function Hapus(id,Nama)
  {
    swal({
      title   : "Hapus",
      text    : "Yakin Ingin Menghapus Data Kelurahan '"+Nama+"' ?",
      icon    : "warning",
      buttons : [
        "Batal",
        "Hapus",
      ],
    })
    .then((hapus) => {
      if (hapus) {
        swal({
          title  : "Hapus",
          text   : "Data Kelurahan '"+Nama+"' Akan di Hapus",
          icon   : "info",
          timer  : 2500,
        });
        window.location = "/data-kelurahan/"+id+"/hapus";
      } else {
        swal({
          title  : "Batal Hapus",
          text   : "Data Kelurahan '"+Nama+"' Batal di Hapus",
          icon   : "info",
          timer  : 2500,
        })
      }
    });
  }

  function cantHapus(id,Nama)
  {
    swal({
      title   : "Hapus",
      text    : "Data Kelurahan '"+Nama+"' Tidak dapat di Hapus Karena Ada Data Sekolah",
      icon    : "warning",
    })
  }
</script>
