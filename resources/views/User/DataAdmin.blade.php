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
          {{$Title = 'Data Admin'}}
        @endsection
        {{$Title}}
      </h3>
        <div class="row">
          <div class="col-lg-12">

            <div class="well well-sm">
              <div class="panel-heading">
                <a href="/data-admin/tambah">
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
                        <th>Nama</th>
                        <th>E-Mail</th>
                        <th>Username</th>
                        <th style="width:25%;">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                        $no = 0;
                      @endphp
                      @foreach ($User as $DataUser)
                        <tr>
                          <td>{{$no+=1}}</td>
                          <td><img class="img-thumbnail img-circle thumb30" src="/Public/img/user/{{$DataUser->foto}}"> {{$DataUser->nama}}</td>
                          <td>{{$DataUser->email}}</td>
                          <td>{{$DataUser->username}}</td>
                          <td>
                            <button class="btn btn-labeled btn-primary btn-xs" type="button"
                            onclick="Ubah('{{Crypt::encryptString($DataUser->id)}}', '{{$DataUser->nama}}')">
                              <span class="btn-label"><i class="fa fa-pencil"></i>
                            </span><b>Edit</b></button>
                            <button class="btn btn-labeled btn-danger btn-xs" type="button"
                            onclick="{{$DataUser->id == Auth::user()->id ? 'cantHapus' : 'Hapus'}}('{{Crypt::encryptString($DataUser->id)}}', '{{$DataUser->nama}}')">
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
@section('bawahan')
  <script>
  function Ubah(id,Nama)
  {
    window.location = "/data-admin/"+id+"/edit";
  }

  function Hapus(id,Nama)
  {
    swal({
      title   : "Hapus",
      text    : "Yakin Ingin Menghapus Data Admin '"+Nama+"' ?",
      icon    : "warning",
      buttons : [
        "Batal",
        "Hapus",
      ],
    })
    .then((hapus) => {
      if (hapus) {
        window.location = "/data-admin/"+id+"/hapus";
      }
    });
  }

  function cantHapus(id,Nama)
  {
    swal({
      title   : "Hapus",
      text    : "Tidak Dapat Menghapus Data Sendiri",
      icon    : "error",
    })
  }
</script>
@endsection
