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
          {{$Title = 'Data Kecamatan'}}
        @endsection
        {{$Title}}
      </h3>
        <div class="row">
          <div class="col-lg-12">

            <div class="well well-sm">
              <div class="panel-heading">
                <a href="/data-kecamatan/tambah">
                  <button class="btn btn-labeled btn-info" type="button">
                    <span class="btn-label"><i class="fa fa-plus"></i>
                  </span><b>Tambah Data</b></button>
                </a>
              </div>
              <div class="panel-body no-padding">
                <div class="table-responsive">
                  <table id="datatable2" class="table table-striped table-bordered table-hover tabel-data-custom" data-toggle="table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Nama Kecamatan</th>
                        <th>Jumlah Kelurahan</th>
                        <th>Jumlah Sekolah</th>
                        <th style="width:25%;">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                        $no = 0;
                      @endphp
                      @foreach ($Kecamatan as $DataKecamatan)
                        <tr>
                          <td>{{$no+=1}}</td>
                          <td>{{$DataKecamatan->nama_kecamatan}}</td>
                          <td>{{count($DataKecamatan->Kelurahan)}}</td>
                          <td>{{count($DataKecamatan->Sekolah)}}</td>
                          <td>
                            <button class="btn btn-labeled btn-primary btn-xs" type="button"
                            onclick="Ubah('{{Crypt::encryptString($DataKecamatan->id)}}', '{{$DataKecamatan->nama_kecamatan}}')">
                              <span class="btn-label"><i class="fa fa-pencil"></i>
                            </span><b>Edit</b></button>
                            <button class="btn btn-labeled btn-danger btn-xs" type="button"
                            onclick="{{count($DataKecamatan->Kelurahan) == 0 ? 'Hapus' : 'cantHapus'}}('{{Crypt::encryptString($DataKecamatan->id)}}', '{{$DataKecamatan->nama_kecamatan}}')">
                              <span class="btn-label"><i class="fa fa-close"></i>
                            </span><b>Hapus</b></button>
                          </td>
                        </tr>
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
<script>
  function Ubah(id,Nama)
  {
    // swal({
    //   title   : "Ubah",
    //   text    : "Anda Akan di Arahkan ke Halaman Ubah Data Kecamatan '"+Nama+"'",
    //   icon    : "info",
    // })
    window.location = "/data-kecamatan/"+id+"/edit";
  }

  function Hapus(id,Nama)
  {
    swal({
      title   : "Hapus",
      text    : "Yakin Ingin Menghapus Data Kecamatan '"+Nama+"' ?",
      icon    : "warning",
      buttons : [
        "Batal",
        "Hapus",
      ],
    })
    .then((hapus) => {
      if (hapus) {
        // swal({
        //   title  : "Hapus",
        //   text   : "Data Kecamatan '"+Nama+"' Akan di Hapus",
        //   icon   : "info",
        //   timer  : 2500,
        // });
        window.location = "/data-kecamatan/"+id+"/hapus";
      } else {
        // swal({
        //   title  : "Batal Hapus",
        //   text   : "Data Kecamatan '"+Nama+"' Batal di Hapus",
        //   icon   : "info",
        //   timer  : 2500,
        // })
      }
    });
  }

  function cantHapus(id,Nama)
  {
    swal({
      title   : "Hapus",
      text    : "Data Kecamatan '"+Nama+"' Tidak dapat di Hapus Karena Ada Data Kelurahan",
      icon    : "error",
    })
  }
</script>
