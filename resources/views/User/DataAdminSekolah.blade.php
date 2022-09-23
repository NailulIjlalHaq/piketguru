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
          {{$Title = 'Data Admin Sekolah'}}
        @endsection
        {{$Title}}
      </h3>
        <div class="row">
          <div class="col-lg-12">

            <div class="well well-sm">
              <div class="panel-heading no-padding">
                <a href="/data-admin-sekolah/tambah">
                  <button class="btn btn-labeled btn-info" type="button">
                    <span class="btn-label"><i class="fa fa-plus"></i>
                  </span><b>Tambah Data</b></button>
                </a>
              </div>
              <div class="panel-body">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover tabel-data-custom" id="datatable2">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Sekolah Induk</th>
                        <th>E-Mail</th>
                        <th>Status</th>
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
                          <td>
                            <img class="img-thumbnail img-circle thumb30" src="/Public/img/user/{{$DataUser->foto}}">
                            {{$DataUser->nama}}
                          </td>
                          <td>{{$DataUser->Sekolah->nama_sekolah}}</td>
                          <td>{{$DataUser->email}}</td>
                          <td>
                            @if ($DataUser->tipe == 0)
                              <div class="label label-danger">Suspend</div>
                            @elseif ($DataUser->tipe == 2)
                              <div class="label label-info">Aktif</div>
                            @endif
                          </td>
                          <td>
                            <button class="btn btn-labeled btn-primary btn-xs" type="button"
                            onclick="Ubah('{{Crypt::encryptString($DataUser->id)}}', '{{$DataUser->nama}}')">
                              <span class="btn-label"><i class="fa fa-pencil"></i>
                            </span><b>Edit</b></button>
                            <button class="btn btn-labeled btn-danger btn-xs" type="button"
                            onclick="Hapus('{{Crypt::encryptString($DataUser->id)}}', '{{$DataUser->nama}}')">
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
    window.location = "/data-admin-sekolah/"+id+"/edit";
  }

  function Hapus(id,Nama)
  {
    swal({
      title   : "Hapus",
      text    : "Yakin Ingin Menghapus Data Admin Sekolah '"+Nama+"' ?",
      icon    : "warning",
      buttons : [
        "Batal",
        "Hapus",
      ],
    })
    .then((hapus) => {
      if (hapus) {
        window.location = "/data-admin-sekolah/"+id+"/hapus";
      }
    });
  }
</script>
@endsection
