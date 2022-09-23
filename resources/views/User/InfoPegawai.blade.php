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
          {{$Title = 'Info Pegawai'}}
        @endsection
        {{$Title}}
        <small>{{$Pegawai->nama}}</small>
      </h3>
        <div class="row">
          <div class="col-lg-12">

            <div class="panel well">
              <a href="/data-pegawai">
                <button class="btn btn-labeled btn-primary" type="button">
                  <span class="btn-label"><i class="icon-action-undo"></i>
                </span><b>Kembali</b></button>
              </a>
              <div class="panel-body">
                <div class="table-responsive">
                  <table class="table table-hover">
                    <tbody>
                      <tr>
                         <td>NIP</td>
                         <td>{{$Pegawai->nip}}</td>
                      </tr>
                      <tr>
                         <td>NUPTK</td>
                         <td>{{$Pegawai->nuptk}}</td>
                      </tr>
                      <tr>
                         <td>Nama</td>
                         <td>{{$Pegawai->nama}}</td>
                      </tr>
                      <tr>
                         <td>Tempat Lahir</td>
                         <td>{{$Pegawai->tempat_lahir}}</td>
                      </tr>
                      <tr>
                         <td>Tanggal Lahir</td>
                         <td>{{Carbon\Carbon::parse($Pegawai->tanggal_lahir)->format('d-m-Y')}}</td>
                      </tr>
                      <tr>
                         <td>Alamat</td>
                         <td>{{$Pegawai->alamat}}</td>
                      </tr>
                      <tr>
                         <td>Jenis Kelamin</td>
                         <td>{{$Pegawai->jenis_kelamin == '1' ? 'Laki - Laki' : 'Perempuan'}}</td>
                      </tr>
                      <tr>
                         <td>No Telepon</td>
                         <td>{{$Pegawai->no_handphone}}</td>
                      </tr>
                      <tr>
                         <td>E-mail</td>
                         <td>{{$Pegawai->email}}</td>
                      </tr>
                      <tr>
                         <td>Asal Sekolah</td>
                         <td>{{$Pegawai->Sekolah->nama_sekolah}}</td>
                      </tr>
                      <tr>
                         <td>ID Sidik Jari</td>
                         <td>{{$Pegawai->sidikjari_id}}</td>
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
      title   : "Info",
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
